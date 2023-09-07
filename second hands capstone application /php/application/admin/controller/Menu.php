<?php

namespace app\admin\controller;

use app\common\controller\ApiCommon;

class Menu extends ApiCommon
{
    protected $link = [
        'index' => ['add', 'edit', 'delete', 'handleSort','getChilren']
    ];

    //前置操作
    protected $beforeActionList = [
        'getPath'  =>  ['only'=>'add,edit'],
    ];

    public function getChilren(){
        $param = $this->checkParam('pid');
        $list = $this->model
            ->where('type',2)
            ->where('pid',$param['pid'])
            ->field('create_time,update_time,sort_index', true)
            ->order("id asc")
            ->select()
            ->toArray();
        return success($list);
    }

    //前置操作 自动获取path路径
    protected function getPath(){
        if($this->param['component_type'] == 1){
            if($this->param['type'] == 1){
                $this->param['path'] = strtolower($this->param['component']);
                $this->param['path'] = str_replace('/', '_', $this->param['path']);
            }else{
                $this->param['component'] = strtolower($this->param['component']);
            }
        }
    }

}