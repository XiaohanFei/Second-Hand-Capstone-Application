<?php

namespace app\dataset\model;

use think\Model;

class Classify extends Model
{
    protected $table = 'home_classify';

    protected $insert = [
        'sort_index' => 9999
    ];


    public function index($param = false)
    {
        $list = $this
            ->field('update_time,sort_index', true)
            ->order("sort_index asc,id asc")
            ->select()
            ->toArray();

        $list = array_to_tree($list);
        return $list;
    }

}
