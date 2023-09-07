<?php

namespace app\admin\model;

use think\Model;


class Menu extends Model
{
    protected $table = 'admin_menu';

    protected $insert = [
        'sort_index' => 9999
    ];


    public function index($param = false)
    {
        $list = $this
            ->field('create_time,update_time,sort_index', true)
            ->order("sort_index asc,id asc")
            ->select()
            ->toArray();

        $list = array_column($list, null, 'id');
        foreach ($list as $key=>$item){
            if($item['type'] == 2){
                unset($list[$key]);
                $list[$item['pid']]['auth'][] = $item['title'];
            }
        }
        $list = array_values($list);
        $list = array_to_tree($list);
        return $list;
    }


}