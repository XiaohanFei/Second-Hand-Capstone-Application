<?php

namespace app\dataset\controller;

use app\common\controller\ApiCommon;

class Chat extends ApiCommon
{
    public function index(){
        $param = $this->checkParam('page,limit,pid');
        $where['pid'] = $param['pid'];
        $list = model('dataset/Chat')->where($where)->page($param['page'], $param['limit'])
            ->with('user')
            ->order('create_time desc')
            ->select()->toArray();

        $res['list'] = $list;
        $res["total"] = db('home_chat')->where($where)->count();
        return success($res);
    }

    public function delete(){
        $param = $this->param;
        if(db('home_chat')->where('id|pid',$param['id'])->delete()){
            return success("", "Deleted successfully");
        }else{
            return error("System Error");
        }
    }

}
