<?php

namespace app\admin\model;

use think\Model;

class Keyword extends Model
{

    protected $table = 'admin_keyword';

    public function checkKeyword($name){
        $info = $this->where('id', 1)->value('content');
        $info = explode('|', $info);
        foreach ($info as $item){
            $item = trim($item);
            if(strlen($item)>0){
                $item = strtolower($item);
                if(strpos(strtolower($name),$item) !== false){
                    return true;
                }
            }
        }
        return false;
    }

}