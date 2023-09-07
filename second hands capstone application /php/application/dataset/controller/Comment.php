<?php

namespace app\dataset\controller;

use app\common\controller\ApiCommon;

class Comment extends ApiCommon
{
    public function index(){
        $param = $this->checkParam('page,limit');
        $where = [];
        $list = db('home_comment')->where($where)->page($param['page'], $param['limit'])
            ->order('update_time desc')
            ->select()->toArray();

        foreach ($list as &$item){
            $item['info'] = db('home_goods')->field('id,name,price,status')->find($item['goods_id']);
        }
        $res['list'] = $list;
        $res["total"] = db('home_comment')->where($where)->count();
        return success($res);
    }

    public function delete(){
        $param = $this->param;
        if(db('home_comment')->where('id',$param['id'])->delete()){
            return success("", "Deleted successfully");
        }else{
            return error("System Error");
        }
    }

}
