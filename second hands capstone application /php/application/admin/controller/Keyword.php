<?php

namespace app\admin\controller;

use app\common\controller\ApiCommon;

class Keyword extends ApiCommon
{

    protected $link = [
        'index' => ['edit', 'upload']
    ];

    public function index()
    {
        $list = $this->model->where('id', 1)->value('content');
        $res['list'] = $list;
        return success($res);
    }

    public function edit()
    {
        $content = $this->param['content'];
        if(strlen($content)>0){
            $content = explode("|", $content);
            foreach ($content as &$item){
                $item = trim($item);
            }
            $content = implode(" | ", $content);
        }
        if ($this->model->allowField(true)->isUpdate(true)->save(['content'=>$content,'id'=>1])) {
            return success($content, 'Saved successfully');
        } else {
            return error($this->model->getError());
        }
    }


}