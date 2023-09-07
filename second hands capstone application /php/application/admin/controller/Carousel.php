<?php

namespace app\admin\controller;

use app\common\controller\ApiCommon;

class Carousel extends ApiCommon
{
    protected $link = [
        'index' => ['edit','delete','add','handleSort','imageUpload']
    ];


    public function index(){

        $list = $this->model
            ->order("sort_index asc,id asc")
            ->select()
            ->toArray();

        $res['list'] = $list;
        return success($res);
    }

    public function imageUpload(){
        $path = ROOT_PATH . 'public' . DS . 'uploads' . DS . 'market';
        $file = request()->file('file');
        if($file){
            $info = $file->validate(['size'=>1024*1024*10,'ext'=>'jpg,jpeg,png'])->rule('uniqid')->move($path);
            if($info){
                return success('market/'.$info->getSaveName());

            }else{
                return error($file->getError());
            }
        }
    }


}