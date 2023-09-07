<?php

namespace app\admin\model;

use think\Model;

class User extends Model
{

    protected $table = 'admin_user';


    protected $insert = [
        'status' => 1,
        'password' => '123456',
        'avatar' => 'avatar/default.jpg'
    ];


    public function setPasswordAttr($value){
        return user_md5($value);
    }

    public function index($param = false){
        if (!($param && $param['page'] && $param['limit'])) {
            return false;
        }
        $where = [];


        if (isset($param['name']) && strlen(trim($param['name'])) > 0) {
            $name = trim($param['name']);
            $where['realname|username'] = array("LIKE", "%$name%");
        }


        $list = $this
            ->order("dept asc,id asc")
            ->field("id,username,realname,status,dept,role")
            ->page($param['page'], $param['limit'])
            ->where($where)
            ->select()
            ->toArray();


        $res["list"] = $list;
        $res["total"] = $this->where($where)->count();
        return $res;
    }


    public function login($param){
        $userInfo = $this
            ->where('username', $param['username'])
            ->find();
        if (!$userInfo) {
            $this->error = 'Account does not exist';
            return false;
        }

        if ($userInfo['status'] !== 1) {
            $this->error = '账号被禁用，请联系管理员';
            return false;
        }

        if (user_md5($param['password']) !== $userInfo['password']) {
            $this->error = 'Password error';
            return false;
        }


        $tokenExpire = model('admin/Setting')->where('name', 'token_expire')->value('value');
        $token = array(
            'id' => $userInfo['id'],
            'expire' => time() + $tokenExpire,
            'dept'=>$userInfo['dept'],
            'role'=>$userInfo['role'],
        );
        $token = token_encrypt(json_encode($token));

        return $token;
    }

}