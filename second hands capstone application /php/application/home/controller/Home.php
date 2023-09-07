<?php

namespace app\home\controller;

use app\common\controller\Common;
use think\Request;
use think\Db;


class Home extends Common
{
    protected $id;

    public function _initialize(){
        parent::_initialize();
        $request = Request::instance();
        $header = $request->header();
        if(!array_key_exists('n-token',$header)){
            exit(error('Please login first','',404));
        }
        $token =  $header['n-token'];
        $token = token_decrypt1($token);
        if($token){
            $token = json_decode($token, true);
            $this->id = $token['id'];
        }else{
            exit(error('Please login first','',404));
        }
    }

    protected function uploadFile($dir,$size=1024 * 1024 * 5,$ext='jpg,jpeg,png'){
        $res['status'] = false;
        $res['msg'] = "File upload error";
        $validate = [
            'size' => $size,
            'ext'=>$ext
        ];

        $path = ROOT_PATH . 'public' . DS . 'uploads' . DS . $dir;
        if(!is_dir($path)){
            if(mkdir($path, '0777')){
                if(is_writable($path)){
                    //写入文件保护
                    @file_put_contents($this->path . DS . "index.html", '');
                }else{
                    $res['msg'] = '文件夹' . $dir . '没有写入权限';
                    return $res;
                }
            }else{
                $res['msg'] = '创建文件夹' . $dir . '失败';
                return $res;
            }
        }

        $file = request()->file('file');


        if($file){
            $info = $file->validate($validate)->rule('uniqid')->move($path);
            if($info){
                $name =  $info->getSaveName();
                $res['status'] = true;
                $res['msg'] = $name;
            }else{
                $res['msg'] = $file->getError();
            }
        }
        return $res;
    }


    public function upload(){
        $res = $this->uploadFile("avatar");
        if ($res['status']) {
            $name = $res['msg'];
            $path = ROOT_PATH . 'public' . DS . 'uploads' . DS . 'avatar' . DS . $name;
            try {
                $image = new \com\picture\Image($path);
                $image->open($path)->thumb(150, 150, 3)->save($path);
            } catch (\Exception $e) {
                return error("System error");
            }
            return success('avatar/' . $name);
        } else {
            return error('Upload Error');
        }
    }

    public function getUserInfo(){
        $info = db('home_user')->field('mobile,nickname,sdu_num,email,avatar')->find($this->id);
        $info['password'] = '';
        return success($info);
    }

    public function editUserInfo(){
        $param = $this->checkParam('mobile,email');
        if(db('home_user')->where('mobile',$param['mobile'])->where('id','NEQ',$this->id)->count()){
            return error("Mobile already exists");
        }
        if(db('home_user')->where('email',$param['email'])->where('id','NEQ',$this->id)->count()){
            return error("Email already exists");
        }
        if(strlen($param['password'])){
            $param['password'] = user_md5($param['password']);
        }else{
            unset($param['password']);
        }
        $param['update_time'] = format_date(time());
        if(db('home_user')->where('id',$this->id)->update($param)){
            $count = db('home_score')->where('user_id', $this->id)->where('task_id', 12)->count();
            if($count == 0 && $param['avatar'] != 'avatar/default.jpg'){
                db('home_user')->where('id',$this->id)->setInc('score',5);
                $data['user_id'] = $this->id;
                $data['desc'] = '+5';
                $data['type'] = 'Long term tasks';
                $data['create_time'] = format_date(time());
                $data['create_day'] = format_date(time(), 'Y-m-d');
                $data['task_id'] = 12;
                db('home_score')->insert($data);
            }
            $count = db('home_score')->where('user_id', $this->id)->where('task_id', 13)->count();
            if($count == 0 && $param['nickname'] != 'u_'.$param['mobile']){
                db('home_user')->where('id',$this->id)->setInc('score',10);
                $data['user_id'] = $this->id;
                $data['desc'] = '+10';
                $data['type'] = 'Long term tasks';
                $data['create_time'] = format_date(time());
                $data['create_day'] = format_date(time(), 'Y-m-d');
                $data['task_id'] = 13;
                db('home_score')->insert($data);
            }
            return success("", "Modified successfully");
        }else{
            return error("System error");
        }
    }

    public function getAddress(){
        $list = db('home_address')->where('user_id', $this->id)->order('id asc')->select()->toArray();
        return success($list);
    }

    public function addAddress(){
        $param = $this->checkParam('name,mobile,address');
        $param['update_time'] = format_date(time());
        $param['user_id'] = $this->id;
        if(db('home_address')->insert($param)){
            return success("", "Added successfully");
        }else{
            return error("System error");
        }
    }

    public function editAddress(){
        $param = $this->checkParam('id,name,mobile,address');
        $param['update_time'] = format_date(time());
        if(db('home_address')->where('id',$param['id'])->update($param)){
            return success("", "Modified successfully");
        }else{
            return error("System error");
        }
    }

    public function delAddress(){
        $param = $this->checkParam('id');
        if(db('home_address')->delete($param['id'])){
            return success("", "Successfully");
        }else{
            return error("System error");
        }
    }


    /**
     *照片上传
     * @return false|string
     */
    public function imageUpload(){
        $path = ROOT_PATH . 'public' . DS . 'uploads' . DS . 'market';
        $file = request()->file('file');
        if($file){
            $info = $file->validate(['size'=>1024*1024*10,'ext'=>'jpg,jpeg,png'])->rule('uniqid')->move($path);
            if($info){
                $name = $this->thumbPicture($info->getSaveName());
                return success('market/'.$name);

            }else{
                return error($file->getError());
            }
        }
    }

    /**
     * 添加商品
     */
    public function addGoods(){
        $param = $this->checkParam('name');
        if(model('admin/Keyword')->checkKeyword($param['name'])){
            return error('Product name contains sensitive words');
        }
        if(model('admin/Keyword')->checkKeyword($param['desc'])){
            return error('Product description contains sensitive words');
        }
        $param['update_time'] = format_date(time());
        $param['create_time'] = format_date(time());
        $param['view'] = 0;
        $param['user_id'] = $this->id;
        if(db('home_goods')->insert($param)){
            return success("", "Successfully");
        }else{
            return error("System error");
        }
    }

    public function editGoods(){
        $param = $this->checkParam('name,id');
        if(model('admin/Keyword')->checkKeyword($param['name'])){
            return error('Product name contains sensitive words');
        }
        if(model('admin/Keyword')->checkKeyword($param['desc'])){
            return error('Product description contains sensitive words');
        }
        unset($param['classify_name']);
        unset($param['user_name']);
        $param['update_time'] = format_date(time());
        if(db('home_goods')->where('id',$param['id'])->update($param)){
            return success("", "Successfully");
        }else{
            return error("System error");
        }
    }

    public function addFavourite(){
        $param = $this->checkParam('id');
        $info = db('home_goods')->find($param['id']);
        if($info && $info['status'] == 1){
            if($info['user_id'] == $this->id){
                return error("You can't collect your own goods");
            }
            $data['goods_id'] = $param['id'];
            $data['user_id'] = $this->id;
            if(db('home_favourite')->where($data)->count()){
                return error("Please don't repeat the collection");
            }
            $data['create_time'] = format_date(time());
            db('home_favourite')->insert($data);
            return success("", 'Successfully');
        }
        return error("System error");
    }

    public function getFavourite(){
        $where['user_id'] = $this->id;
        if(isset($param['name']) && strlen($param['name'])){
            $name = trim($param['name']);
            $where['name'] = array("LIKE", "%$name%");
        }
        $list = db('home_favourite')->where($where)->order('id desc')->select()->toArray();
        foreach ($list as &$item){
            $item['info'] = db('home_goods')->field('id,name,price,status')->find($item['goods_id']);
        }
        return success($list);
    }

    public function delFavourite(){
        $param = $this->checkParam('id');
        if(db('home_favourite')->delete($param['id'])){
            return success("", "Successfully");
        }else{
            return error("System error");
        }
    }

    public function addComment(){
        $param = $this->checkParam('content,goods_id');
        $temp = db('home_goods')->where('id', $param['goods_id'])->value('user_id');
        if($temp == $this->id){
            return error("Please don't comment on your products");
        }
        $param['user_id'] = $this->id;
        $param['create_time'] = format_date(time());
        $param['update_time'] = format_date(time());
        if(db('home_comment')->insert($param)){
            $count = db('home_score')->where('user_id', $this->id)->where('task_id', 2)->where('create_day', format_date(time(), 'Y-m-d'))->count();
            if($count == 0){
                $count = db('home_comment')->where('user_id', $this->id)->where('create_time', 'between',get_today())->count();
                if($count >= 2){
                    db('home_user')->where('id',$this->id)->setInc('score',5);
                    $data['user_id'] = $this->id;
                    $data['desc'] = '+5';
                    $data['type'] = 'Daily task';
                    $data['create_time'] = format_date(time());
                    $data['create_day'] = format_date(time(), 'Y-m-d');
                    $data['task_id'] = 2;
                    db('home_score')->insert($data);
                }
            }
            return success("", "Successfully");
        }else{
            return error("System error");
        }

    }

    public function getCart(){
        $where['user_id'] = $this->id;
        if(isset($param['name']) && strlen($param['name'])){
            $name = trim($param['name']);
            $where['name'] = array("LIKE", "%$name%");
        }
        $list = db('home_cart')->where($where)->order('id desc')->select()->toArray();
        foreach ($list as &$item){
            $item['info'] = db('home_goods')->field('id,name,price,status')->find($item['goods_id']);
        }
        return success($list);
    }

    public function delCart(){
        $param = $this->checkParam('id');
        if(db('home_cart')->delete($param['id'])){
            return success("", "Successfully");
        }else{
            return error("System error");
        }
    }

    public function addCart(){
        $param = $this->checkParam('id');
        $info = db('home_goods')->find($param['id']);
        if($info && $info['status'] == 1){
            if($info['user_id'] == $this->id){
                return error("You can't add your own goods");
            }
            $data['goods_id'] = $param['id'];
            $data['user_id'] = $this->id;
            if(db('home_cart')->where($data)->count()){
                return error("Please do not repeat add");
            }
            $data['create_time'] = format_date(time());
            db('home_cart')->insert($data);
            return success("", 'Successfully');
        }
        return error("System error");
    }

    public function addReply(){
        $param = $this->checkParam('reply,id');
        $param['update_time'] =format_date(time());
        if(db('home_comment')->update($param)){
            return success("", "Successfully");
        }else{
            return error("System error");
        }
    }

    public function getMoney(){
        $info = db('home_user')->where('id', $this->id)->value('money');
        return success($info);
    }

    public function addMoney(){
        $param = $this->checkParam('money');
        if(db('home_user')->where('id', $this->id)->setInc('money',$param['money'])){
            return success("", "Successfully");
        }else{
            return error("System error");
        }
    }

    public function getOrderList(){
        $param = $this->checkParam('ids');
        $list = db('home_goods')->where('id','in',$param['ids'])->field('id,name,price,status')->order('id desc')->select()->toArray();
        return success($list);
    }

    public function addOrder(){
        $param = $this->checkParam('address,ids');
        if(strlen($param['address']) == 0){
            return error("Receiving address cannot be empty");
        }
        $allMoney = 0;
        foreach ($param['ids'] as $id){
            $info = db('home_goods')->find($id);
            if($info['user_id'] == $this->id){
                return error("You can't buy your own goods");
            }
            if($info['status'] !== 1){
                return error("Product status error");
            }
            $allMoney += $info['price'];
        }
        $my = db('home_user')->where('id', $this->id)->value('money');
        if($my<$allMoney){
            return error("Please recharge first");
        }
        Db::startTrans();
        try{
            foreach ($param['ids'] as $id){
                $info = db('home_goods')->find($id);
                $add = [
                    'goods_id'=>$info['id'],
                    'user_id'=>$this->id,
                    'order_id' => 'OD' . strtoupper(uniqid()),
                    'create_time'=>format_date(time()),
                    'owern_user_id'=>$info['user_id'],
                    'address'=>$param['address']
                ];
                db('home_order')->insert($add);
                db('home_goods')->where('id', $id)->update(['status'=>3]);
                db('home_cart')->where('goods_id', $id)->where('user_id', $this->id)->delete();
                db('home_favourite')->where('goods_id', $id)->where('user_id', $this->id)->delete();

                //长期任务 购买3件
                $count = db('home_score')->where('user_id', $this->id)->where('task_id', 11)->count();
                if($count == 0){
                    $count = db('home_order')->where('user_id', $this->id)->count();
                    if($count >=3){
                        db('home_user')->where('id',$this->id)->setInc('score',3);
                        $data['user_id'] = $this->id;
                        $data['desc'] = '+3';
                        $data['type'] = 'Long term tasks';
                        $data['create_time'] = format_date(time());
                        $data['create_day'] = format_date(time(), 'Y-m-d');
                        $data['task_id'] = 11;
                        db('home_score')->insert($data);
                    }
                }
                //短期任务 出售二手书
                if($info['classify_id'] == 89){
                    $count = db('home_score')->where('user_id', $info['user_id'])->where('task_id', 3)->where('create_time', 'between',get_today())->count();
                    if($count == 0){
                        db('home_user')->where('id', $info['user_id'])->setInc('score',10);
                        $data['user_id'] = $info['user_id'];
                        $data['desc'] = '+10';
                        $data['type'] = 'Daily task';
                        $data['create_time'] = format_date(time());
                        $data['create_day'] = format_date(time(), 'Y-m-d');
                        $data['task_id'] = 3;
                        db('home_score')->insert($data);
                    }
                }

                //短期任务 出售二手衣服
                if($info['classify_id'] == 84){
                    $count = db('home_score')->where('user_id', $info['user_id'])->where('task_id', 4)->where('create_time', 'between',get_today())->count();
                    if($count == 0){
                        db('home_user')->where('id', $info['user_id'])->setInc('score',5);
                        $data['user_id'] = $info['user_id'];
                        $data['desc'] = '+5';
                        $data['type'] = 'Daily task';
                        $data['create_time'] = format_date(time());
                        $data['create_day'] = format_date(time(), 'Y-m-d');
                        $data['task_id'] = 4;
                        db('home_score')->insert($data);
                    }
                }


            }
            db('home_user')->where('id', $this->id)->setDec('money',$allMoney);
            // 提交事务
            Db::commit();
            return success("",'Successfully');
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return error($e);
        }
    }

    public function getMyBug(){
        $list = db('home_order')->where('user_id', $this->id)->order('id desc')->select()->toArray();
        foreach ($list as &$item){
            $item['info'] = db('home_goods')->field('id,name,price,status')->find($item['goods_id']);
            $item['status_name'] = $item['info']['status'] == 3 ? 'Not shipped' : 'Shipped';
        }
        return success($list);
    }

    public function getMySell(){
        $statusStr = ["",'On sale', 'Removed', 'Not shipped', 'Shipped'];
        $list = db('home_goods')->where('user_id', $this->id)
            ->field('id,name,price,status')
            ->order('id desc')->select()->toArray();
        foreach ($list as &$item){
            $item['status_name'] = $statusStr[$item['status']];
        }
        return success($list);
    }

    public function statusGoods(){
        $param = $this->checkParam('id,status');
        if(db('home_goods')->where('id', $param['id'])->update(['status'=>$param['status']])){
            return success("", "Successfully");
        }else{
            return error("System error");
        }
    }

    public function getChatList(){
        $param = $this->checkParam('page');
        $where['pid'] =0;
        $res['info'] = db('home_user')->where('id', $this->id)->field('nickname,avatar')->find();
        $list = db('home_chat')->where($where)->page($param['page'], 20)

            ->order('create_time desc')
            ->select()->toArray();
        foreach ($list as &$item){
            $info = db('home_user')->where('id', $item['user_id'])->field('nickname,avatar')->find();
            $item['name'] = $info['nickname'];
            $item['avatar'] = $info['avatar'];
            $item['canDelete'] = 2;
            if($item['user_id'] == $this->id){
                $item['canDelete'] = 1;
            }
            $item['reply'] = db('home_chat')->where('pid', $item['id'])->count();
        }
        $res['list'] = $list;
        $res["total"] = db('home_chat')->where($where)->count();
        return success($res);
    }

    public function addChat(){
        $param = $this->checkParam('content');
        $param['user_id'] = $this->id;
        $param['create_time'] = format_date(time());
        if(db('home_chat')->insert($param)){
            return success("", "Successfully");
        }else{
            return error('System error');
        }
    }

    public function deleteChat()
    {
        $param = $this->checkParam('id');
        if (db('home_chat')->where('id|pid',$param['id'])->delete()) {
            return success("", "Successfully");
        } else {
            return error('System error');
        }
    }

    public function getChatDetail(){
        $param = $this->checkParam('page,id');
        $info = model('home/Chat')->where('id', $param['id'])->with('user')->find();
        $temp = db('home_user')->where('id', $this->id)->field('nickname,avatar')->find();
        $info['user_name'] = $temp['nickname'];
        $info['user_avatar'] = $temp['avatar'];
        $res['info'] = $info;

        $list = model('home/Chat')->with('user')->where('pid',$param['id'])->page($param['page'], 20)
            ->order('create_time desc')
            ->select()->toArray();
        foreach ($list as &$item){
            $item['canDelete'] = 2;
            if($item['user_id'] == $this->id){
                $item['canDelete'] = 1;
            }
        }
        $res['list'] = $list;
        $res["total"] = db('home_chat')->where('pid',$param['id'])->count();
        return success($res);
    }

    public function getScoreList(){
        $param = $this->checkParam('page');


        $list = db('home_score')->where('user_id',$this->id)->page($param['page'], 20)
            ->order('create_time desc')
            ->select()->toArray();

        $res['list'] = $list;
        $res["total"] = db('home_score')->where('user_id',$this->id)->count();
        return success($res);
    }


    public function getOrderDetail(){
        $param = $this->checkParam('id');
        $info = db('home_order')->where('goods_id', $param['id'])->find();
        $info['user'] = db('home_user')->where('id', $info['user_id'])->field('mobile,nickname')->find();
        return success($info);
    }

    public function getMyScore(){
        $res['score'] = db('home_user')->where('id', $this->id)->value('score');
        $res['long_score_count'] = db('home_order')->where('user_id', $this->id)->count();
        $res['long_score_count'] = $res['long_score_count'] > 3 ? 3 : $res['long_score_count'];
        $res['long_score_status'] = $res['long_score_count'] >= 3 ? 2 : 1;

        $day = format_date(time(), 'Y-m-d');
        $info = db('home_score_task')->where('user_id', $this->id)->where('day', $day)->find();
        if(empty($info)){
            $class_id = db('home_goods')->where('status', 1)->orderRaw('rand()')->field('classify_id')->find();
            if($class_id){
                $data['class_id'] =  $class_id['classify_id'];
                $data['user_id'] = $this->id;
                $data['day'] =$day;
                $data['status'] =1;
                db('home_score_task')->insert($data);

                $res['daily_score_desc'] = db('home_classify')->where('id', $class_id['classify_id'])->value('title');
            }else{
                $res['daily_score_desc'] = '';
            }
        }else{
            $res['daily_score_desc'] = db('home_classify')->where('id', $info['class_id'])->value('title');
        }
        $res['daily'] = db('home_score')->where('user_id', $this->id)->where('create_day', $day)->where('type', 'Daily task')->column('task_id');
        $res['long'] = db('home_score')->where('user_id', $this->id)->where('type', 'Long term tasks')->column('task_id');
        return success($res);
    }


    private function thumbPicture($name){
        try {
            $path = ROOT_PATH . 'public' . DS . 'uploads' . DS . 'market'. DS .$name;
            $image = new \com\picture\Image($path);
            $image->thumb(900,900,1)->save($path);
            return $name;
        } catch (\Exception $e) {
            return $name;
        }
    }
}
