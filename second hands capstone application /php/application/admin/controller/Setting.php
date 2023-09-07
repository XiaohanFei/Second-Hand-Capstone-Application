<?php

namespace app\admin\controller;

use app\common\controller\ApiCommon;

class Setting extends ApiCommon
{

    protected $link = [
        'index' => ['edit', 'upload']
    ];

    public function index()
    {
        $list = $this->model->column('name,value');
        foreach ($list as $key => $item) {
            if (is_numeric($item)) {
                $list[$key] = (int)$item;
            }
        }
        $res['list'] = $list;
        $res['isSuper'] = $list['super_user'] === $this->id;
        return success($res);
    }

    public function edit()
    {
        $data = [];
        foreach ($this->param as $key => $item) {
            $temp['id'] = $this->model->where('name', $key)->value('id');
            $temp['value'] = $item;
            $data[] = $temp;
        }
        if ($this->model->allowField(true)->isUpdate(true)->saveAll($data)) {
            return success('', 'Saved successfully');
        } else {
            return error($this->model->getError());
        }
    }

    public function upload()
    {
        $res = $this->uploadFile("logo");
        if ($res['status']) {
            $name = $res['msg'];
            $path = ROOT_PATH . 'public' . DS . 'uploads' . DS . 'logo' . DS . $name;
            try {
                $image = new \com\picture\Image($path);
                $image->open($path)->thumb(240, 240, 3)->save($path);
            } catch (\Exception $e) {
                return error("Error");
            }
            return success(["logoPath" => 'logo/' . $name]);
        } else {
            return error($res['msg']);
        }
    }

}