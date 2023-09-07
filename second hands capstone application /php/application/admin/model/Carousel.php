<?php

namespace app\admin\model;

use think\Model;

class Carousel extends Model
{

    protected $table = 'admin_carousel';

    protected $insert = [
        'sort_index' => 9999
    ];



}