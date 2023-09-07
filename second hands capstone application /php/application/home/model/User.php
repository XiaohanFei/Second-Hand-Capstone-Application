<?php

namespace app\home\model;

use think\Model;

class User extends Model
{

    protected $table = 'home_user';


    protected $insert = [
        'money' => 0,
        'avatar' => 'avatar/default.jpg'
    ];

    public function setPasswordAttr($value){
        return user_md5($value);
    }



    public function login($param){
        $userInfo = $this
            ->where('mobile|email', $param['username'])
            ->find();
        if (!$userInfo) {
            $this->error = 'Mobile/email does not exist';
            return false;
        }

        if (user_md5($param['password']) !== $userInfo['password']) {
            $this->error = 'Password error';
            return false;
        }


        $token = array(
            'id' => $userInfo['id']
        );
        $token = token_encrypt1(json_encode($token));

        return [
            'token'=>$token,
            'nickname'=>$userInfo['nickname']
        ];
    }

}