<?php
namespace app\admin\validate;
use think\Validate;
class User extends Validate
{
    protected $rule = [
        'username'  =>  'require|min:2|unique:user',
        'password' =>  'require|min:2',
        'realname'=>'require',
        'dept'=>'require',
        'checkPass'=>'require|confirm:password'
    ];

    protected $message = [
        'username.require'  =>  '账号不能为空',
        'username.min' =>  '账号至少2个字符',
        'username.unique'=>'账号已经存在',
        'password.require'  =>  '账号不能为空',
        'password.min' =>  '账号至少2个字符',
        'realname.require' =>  '用户姓名不能为空',
        'dept.require' =>  '部门不能为空',
        'checkPass.require' =>  '请再次输入密码',
        'checkPass.confirm' =>  '两次输入密码不一致',
    ];

    public $scene = [
        'login'  =>  ['username'=>'require|min:2','password'],
        'add'  =>  ['username','realname','dept'],
        'edit'  =>  ['username','realname','dept'],
        'setPerson'  =>  ['realname'],
        'setPassword'  =>  ['password','checkPass'],
    ];
}