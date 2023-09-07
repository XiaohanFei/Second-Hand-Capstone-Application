<?php
namespace app\admin\validate;
use think\Validate;
class Menu extends Validate
{
    protected $rule = [
        'title'  =>  'require',
        'component' =>  'require',
        'id'=>'require|number',
        'pid'=>'require|different:id'
    ];

    protected $message = [
        'title.require'  =>  '菜单名称不能为空',
        'component.require'  =>  '菜单组件不能为空',
        'id.require'=>'ID不能为空',
        'id.number'=>'ID错误',
        'pid.require'=>'父级菜单选择错误',
        'pid.different'=>'父级菜单选择错误',

    ];

    public $scene = [
        'add'  =>  ['title','pid'],
        'edit'  =>  ['title','id','pid']
    ];
}