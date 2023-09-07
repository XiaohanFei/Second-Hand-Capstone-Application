<?php

namespace app\dataset\controller;

use app\common\controller\ApiCommon;

class User extends ApiCommon
{
    public function index(){

        $param = $this->checkParam('page,limit');
        $order = 'id desc';
        $where = [];
        if(isset($param['name']) && strlen($param['name'])){
            $name = trim($param['name']);
            $where['mobile|sdu_num|nickname'] = array("LIKE", "%$name%");
        }
        $list = db('home_user')->where($where)->page($param['page'], $param['limit'])
            ->order($order)
            ->select()->toArray();


        $res['list'] = $list;
        $res["total"] = db('home_user')->where($where)->count();
        return success($res);
    }





}
