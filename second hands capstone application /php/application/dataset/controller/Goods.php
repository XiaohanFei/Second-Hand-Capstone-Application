<?php

namespace app\dataset\controller;

use app\common\controller\ApiCommon;

class Goods extends ApiCommon
{
    public function index(){
        $statusStr = ["",'On sale', 'Removed', 'Not shipped', 'Shipped'];
        $param = $this->checkParam('page,limit');
        $order = 'id desc';
        $where = [];
        if(isset($param['name']) && strlen($param['name'])){
            $name = trim($param['name']);
            $where['name'] = array("LIKE", "%$name%");
        }
        $list = db('home_goods')->where($where)->page($param['page'], $param['limit'])
            ->field('id,name,picture,classify_id,price,view,status,user_id')
            ->order($order)
            ->select()->toArray();

        foreach ($list as &$item){
            $item['status_name'] = $statusStr[$item['status']];
            $item['user'] = db('home_user')->where('id', $item['user_id'])->field('mobile,nickname')->find();
            $item['picture'] = explode(",", $item['picture']);
            $item['picture'] = $item['picture'][0];
            $temp = db('home_classify')->where('id', $item['classify_id'])->field('pid,title')->find();
            $item['classify_name'] = db('home_classify')->where('id', $temp['pid'])->value('title') . " >> " . $temp['title'];
        }
        $res['list'] = $list;
        $res["total"] = db('home_goods')->where($where)->count();
        return success($res);
    }

    public function delete(){
        $param = $this->param;
        if(db('home_goods')->where('id',$param['id'])->update(['status'=>2])){
            return success("", "Save succeeded");
        }else{
            return error("System Error");
        }
    }

    public function getClassify(){
        $list = model("dataset/Classify")->index();
        return success($list);
    }
    public function getGoodsDetail(){
        $param = $this->checkParam('id');
        db('home_goods')->where('id', $param['id'])->setInc('view');
        $info = db('home_goods')->find($param['id']);
        $info['picture'] = explode(",", $info['picture']);
        $temp = db('home_classify')->where('id', $info['classify_id'])->field('pid,title')->find();
        $info['classify_name'] = db('home_classify')->where('id', $temp['pid'])->value('title') . " >> " . $temp['title'];
        return success($info);
    }

    public function edit(){
        $param = $this->checkParam('name,id');
        unset($param['classify_name']);
        if(model('admin/Keyword')->checkKeyword($param['name'])){
            return error('Product name contains sensitive words');
        }
        if(model('admin/Keyword')->checkKeyword($param['desc'])){
            return error('Product description contains sensitive words');
        }
        $param['update_time'] = format_date(time());
        if(db('home_goods')->where('id',$param['id'])->update($param)){
            return success("", "Save succeeded");
        }else{
            return error("System Error");
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
