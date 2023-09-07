<?php

namespace app\admin\controller;

use app\common\controller\ApiCommon;

class User extends ApiCommon
{

    protected $link = [
        'index' => ['add', 'edit', 'delete']
    ];

    protected $allow = ['getPerson', 'setPerson', 'setPassword', 'upload','getInfo'];


    /**
     * 获取用户信息
     */
    public function getInfo(){
        $menu = [];
        $router = [];
        $auth = [];
        $res = $this->model->field('realname,avatar')->find($this->id);

        $where = [];

        $list = model('admin/Menu') ->field('id,pid,title as name,component,path,icon,type,component_type')
            ->where($where)
            ->where('status',1)
            ->order("sort_index asc,id asc")
            ->select()
            ->toArray();

        foreach ($list as $item){
            if($item['type'] == 2){
                $auth[] = $item['component'];
            }else{
                $menu[] = $item;
                if($item['component_type'] == 1 && strlen($item['component']) >0 ){
                    $router[] = [
                        'component'=>$item['component'],
                        'path'=>$item['path']
                    ];
                }
            }
        }

        $res['menu'] = array_to_tree($menu,['pid']);
        $res['router'] = $router;
        $res['auth'] = $auth;

        return success($res);
    }

    /**
     * 删除用户同时删除权限
     * @return false|string|void
     */
    public function delete(){
        $param = $this->checkParam('ids');
        $ids = $param['ids'];

        if(count($ids) == 0){
            return error("Error");
        }

        foreach ($ids as $key=>$value){
            $ids[$key] = (int)$value;
            if((int)$value == 1){
                return error("Error");
            }
        }

        if($this->model->destroy($ids)){

            return success(count($ids),'Deleted successfully');
        }else{
            return error($this->model->getError());
        }
    }

    /**
     * 个人设置页面
     * @return false|string
     */
    public function getPerson()
    {
        $info = $this->model->field('realname,avatar,dept,role')->find($this->id)->toArray();
        if ($info) {
            $res['info'] = $info;

            return success($res);
        } else {
            return error("Error");
        }
    }


    /**
     * 设置个人信息
     */
    public function setPerson(){
        $result = $this->validate->scene('setPerson')->check($this->param);
        if (!$result) {
            return error($this->validate->getError());
        }
        $this->param['id'] = $this->id;
        if ($this->model->allowField(true)->isUpdate(true)->save($this->param, ['id' => $this->id])) {
            return success('', 'Saved successfully');
        } else {
            return error($this->model->getError());
        }
    }

    /**
     * 设置密码
     */
    public function setPassword()
    {
        $result = $this->validate->scene('setPassword')->check($this->param);
        if (!$result) {
            return error($this->validate->getError());
        }
        $password = $this->model->field('password')->find($this->id);
        if (user_md5($this->param['oldPass']) !== $password['password']) {
            return error("The old password is incorrect");
        }
        $this->param['id'] = $this->id;
        if ($this->model->allowField(true)->isUpdate(true)->save($this->param, ['id' => $this->id])) {
            return success('', 'Saved successfully');
        } else {
            return error($this->model->getError());
        }
    }

    public function upload(){
        $res = $this->uploadFile("avatar");
        if ($res['status']) {
            $name = $res['msg'];
            $path = ROOT_PATH . 'public' . DS . 'uploads' . DS . 'avatar' . DS . $name;
            try {
                $image = new \com\picture\Image($path);
                $image->open($path)->thumb(150, 150, 3)->save($path);
            } catch (\Exception $e) {
                return error("Error");
            }
            return success(["avatarPath" => 'avatar/' . $name]);
        } else {
            return error('Upload Error');
        }
    }

}