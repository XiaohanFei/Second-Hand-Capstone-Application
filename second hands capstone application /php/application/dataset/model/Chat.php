<?php

namespace app\dataset\model;

use think\Model;

class Chat extends Model
{

    protected $table = 'home_chat';

    public function user()
    {
        return $this->hasOne('User', 'id', 'user_id')->bind('nickname,mobile');
    }

}