<?php

namespace app\dataset\controller;

use app\common\controller\ApiCommon;

class Notice extends ApiCommon
{

    public function index(){
        $param = $this->checkParam('page,limit');
        $order = 'id desc';
        $where = [];
        if(isset($param['name']) && strlen($param['name'])){
            $name = trim($param['name']);
            $where['title'] = array("LIKE", "%$name%");
        }
        $list = db('home_notice')->where($where)->page($param['page'], $param['limit'])
            ->order($order)
            ->select()->toArray();

        foreach ($list as &$item) {
            $item['status_name'] = $item['status'] == 1 ? 'Enable' : 'Disable';
        }

        $res['list'] = $list;
        $res["total"] = db('home_notice')->where($where)->count();
        return success($res);
    }

    public function edit(){
        $this->param['update_time'] = format_date(time());

        if($this->model->allowField(true)->isUpdate(true)->save($this->param,['id'=>$this->param['id']])){
            return success('','Edit succeeded');
        }else{
            return error($this->model->getError());
        }
    }
}
