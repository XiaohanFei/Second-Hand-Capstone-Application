<?php

namespace app\home\controller;

use app\common\controller\Common;
use think\Request;
use think\Db;
use think\Cache;


class Base extends Common
{

    /**
     * 用户登录
     * @return \think\response\Json
     */
    public function login()
    {
        $param = $this->checkParam('username,password,verify');
        $captcha = new \com\verify\HonrayVerify(config('captcha'));
        if (!$captcha->check($param['verify'])) {
            return error("Verification code error");
        }

        $userModel = model('home/User');
        $data = $userModel->login($this->param);

        if ($data) {
            return success($data, 'Login successful');
        } else {
            return error($userModel->getError());
        }
    }


    public function register(){
        $param = $this->checkParam('mobile,email,verify,password,re_password');
        $verify = Cache::get($param['email']);
        if ($verify != $param['verify']) {
            return error("Mailbox verification code error");
        }
        if($param['re_password'] !== $param['password']){
            return error("Passwords are different");
        }
        if(db('home_user')->where('mobile',$param['mobile'])->count()){
            return error("Mobile already exists");
        }
        if(db('home_user')->where('email',$param['email'])->count()){
            return error("Email already exists");
        }

        $param['nickname'] = 'u_' . $param['mobile'];
        if(model('home/User')->allowField(true)->isUpdate(false)->save($param)){
            return success('','Register successful');
        }else{
            return error(model('home/User')->getError());
        }
    }

    public function getUserInfo(){
        $param = $this->checkParam('id');
        $info = db('home_user')->field('mobile,nickname,sdu_num,email,avatar')->find($param['id']);
        return success($info);
    }

    /**
     * 获取物品分类
     */
    public function getClassify(){
        $list = model("dataset/Classify")->index();
        return success($list);
    }

    public function getNocite(){
        $info = db('home_notice')->where('status', 1)->field('id,title')->order('id desc')->limit(5)->select()->toArray();
        return success($info);
    }

    public function getNoticeDetail(){
        $param = $this->checkParam('id');
        $info = db('home_notice')->find($param['id']);
        return success($info);
    }

    public function getGoods(){
        $param = $this->checkParam('page');
        $where['status'] = 1;
        $order = 'id desc';
        if($param['classify'] == -3){
            $order = 'view desc';
        }
        if($param['classify']>0){
            $where['classify_id'] = $param['classify'];
        }
        if(isset($param['name']) && strlen($param['name'])){
            $name = trim($param['name']);
            $where['name'] = array("LIKE", "%$name%");
        }
        $list = db('home_goods')->where($where)->page($param['page'], 20)
            ->field('id,name,picture,classify_id,price,view')
            ->order($order)
            ->select()->toArray();

        foreach ($list as &$item){
            $item['picture'] = explode(",", $item['picture']);
            $item['picture'] = $item['picture'][0];
            $temp = db('home_classify')->where('id', $item['classify_id'])->field('pid,title')->find();
            $item['classify_name'] = db('home_classify')->where('id', $temp['pid'])->value('title') . " >> " . $temp['title'];
        }
        $res['list'] = $list;
        $res["total"] = db('home_goods')->where($where)->count();
        return success($res);
    }

    public function getComment(){
        $param = $this->checkParam('page,id');
        $temp = db('home_goods')->where('id', $param['id'])->value('user_id');
        $thisId = 0;
        if($param['token']){
            $token = token_decrypt1($param['token']);
            if($token){
                $token = json_decode($token, true);
                $thisId = $token['id'];
            }
        }

        $where['goods_id'] = $param['id'];
        $list = db('home_comment')->where($where)->page($param['page'], 20)
            ->order('create_time desc')
            ->select()->toArray();

        foreach ($list as &$item){
            $info = db('home_user')->where('id', $item['user_id'])->field('nickname,avatar')->find();
            $item['name'] = $info['nickname'];
            $item['avatar'] = $info['avatar'];
            $item['canReplay'] = 2;
            if($thisId == $temp && strlen($item['reply']) == 0){
                $item['canReplay'] = 1;
            }
        }
        $res['list'] = $list;
        $res["total"] = db('home_comment')->where($where)->count();
        return success($res);
    }

    public function getGoodsDetail(){
        $param = $this->checkParam('id');
        db('home_goods')->where('id', $param['id'])->setInc('view');
        $info = db('home_goods')->find($param['id']);
        $info['picture'] = explode(",", $info['picture']);
        $temp = db('home_user')->where('id', $info['user_id'])->field('nickname,avatar')->find();
        $info['user_name'] = $temp['nickname'];
        $temp = db('home_classify')->where('id', $info['classify_id'])->field('pid,title')->find();
        $info['classify_name'] = db('home_classify')->where('id', $temp['pid'])->value('title') . " >> " . $temp['title'];
        return success($info);
    }

    public function addScore(){
        $param = $this->checkParam('id');
        if($param['token']){
            $token = token_decrypt1($param['token']);
            if($token){
                $token = json_decode($token, true);
                $where['user_id'] =  $token['id'];
                $where['day'] =  format_date(time(), 'Y-m-d');
                $where['class_id'] = $param['id'];
                $info = db('home_score_task')->where($where)->find();
                $count = db('home_score')->where('user_id', $token['id'])->where('task_id', 1)->where('create_day', format_date(time(), 'Y-m-d'))->count();
                if($info && $count == 0){
                    db('home_user')->where('id',$token['id'])->setInc('score',1);
                    $data['user_id'] = $token['id'];
                    $data['desc'] = '+1';
                    $data['type'] = 'Daily task';
                    $data['create_time'] = format_date(time());
                    $data['create_day'] = format_date(time(), 'Y-m-d');
                    $data['task_id'] = 1;
                    db('home_score')->insert($data);
                    return success('','Score obtained successfully');
                }
            }
        }
        return error('');

    }

    /**
     * miss路由
     * @return string
     */
    public function miss()
    {
        if (Request::instance()->isOptions()) {
            return '';
        } else {
            echo 'VUE接口';
        }
    }
}
