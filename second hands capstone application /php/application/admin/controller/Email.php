<?php

namespace app\admin\controller;

use app\common\controller\ApiCommon;

class Email extends ApiCommon
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


}