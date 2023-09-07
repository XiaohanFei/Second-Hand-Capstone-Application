<?php
return [
    //测试
    'test' => ['admin/base/test', ['method' => 'GET']],

    //登录接口
    '[admin/base]' => [
        'getConfigs' => ['admin/base/getConfigs', ['method' => 'GET']],
        'getVerify' => ['admin/base/getVerify', ['method' => 'GET']],
        'login' => ['admin/base/login', ['method' => 'POST']],
        'sendEmail' => ['admin/base/sendEmail', ['method' => 'POST']],
    ],

    //系统设置
    '[admin/setting]' => [
        'index' => ['admin/setting/index', ['method' => 'GET']],
        'edit' => ['admin/setting/edit', ['method' => 'POST']],
        'upload' => ['admin/setting/upload', ['method' => 'POST']],
    ],

    '[admin/email]' => [
        'index' => ['admin/email/index', ['method' => 'GET']],
        'edit' => ['admin/email/edit', ['method' => 'POST']],
    ],

    '[admin/keyword]' => [
        'index' => ['admin/keyword/index', ['method' => 'GET']],
        'edit' => ['admin/keyword/edit', ['method' => 'POST']],
    ],


    '[admin/carousel]' => [
        'index' => ['admin/carousel/index', ['method' => 'GET']],
        'add' => ['admin/carousel/add', ['method' => 'POST']],
        'edit' => ['admin/carousel/edit', ['method' => 'POST']],
        'handleSort' => ['admin/carousel/handleSort', ['method' => 'POST']],
        'delete' => ['admin/carousel/delete', ['method' => 'POST']],
        'imageUpload' => ['admin/carousel/imageUpload', ['method' => 'POST']],
    ],


    //用户接口
    '[admin/user]' => [
        //用户个人接口
        'getPerson' => ['admin/user/getPerson', ['method' => 'GET']],
        'getInfo' => ['admin/user/getInfo', ['method' => 'GET']],
        'upload' => ['admin/user/upload', ['method' => 'POST']],
        'setPerson' => ['admin/user/setPerson', ['method' => 'POST']],
        'setPassword' => ['admin/user/setPassword', ['method' => 'POST']],
        'index' => ['admin/user/index', ['method' => 'POST']],
        'add' => ['admin/user/add', ['method' => 'POST']],
        'edit' => ['admin/user/edit', ['method' => 'POST']],
        'delete' => ['admin/user/delete', ['method' => 'DELETE']],
    ],

    //菜单接口
    '[admin/menu]' => [
        'index' => ['admin/menu/index', ['method' => 'GET']],
        'add' => ['admin/menu/add', ['method' => 'POST']],
        'edit' => ['admin/menu/edit', ['method' => 'POST']],
        'getChilren' => ['admin/menu/getChilren', ['method' => 'POST']],
        'handleSort' => ['admin/menu/handleSort', ['method' => 'POST']],
        'delete' => ['admin/menu/delete', ['method' => 'POST']],
    ],


    '[dataset/goods]' => [
        'index' => ['dataset/goods/index', ['method' => 'POST']],
        'edit' => ['dataset/goods/edit', ['method' => 'POST']],
        'delete' => ['dataset/goods/delete', ['method' => 'POST']],
        'getClassify' => ['dataset/goods/getClassify', ['method' => 'POST']],
        'getGoodsDetail' => ['dataset/goods/getGoodsDetail', ['method' => 'POST']],
        'imageUpload' => ['dataset/goods/imageUpload', ['method' => 'POST']],
    ],

    '[dataset/order]' => [
        'index' => ['dataset/order/index', ['method' => 'POST']],
        'statistics' => ['dataset/order/statistics', ['method' => 'POST']]
    ],

    '[dataset/user]' => [
        'index' => ['dataset/user/index', ['method' => 'POST']]
    ],

    '[dataset/comment]' => [
        'index' => ['dataset/comment/index', ['method' => 'POST']],
        'edit' => ['dataset/comment/edit', ['method' => 'POST']],
        'delete' => ['dataset/comment/delete', ['method' => 'POST']],
    ],

    '[dataset/chat]' => [
        'index' => ['dataset/chat/index', ['method' => 'POST']],
        'delete' => ['dataset/chat/delete', ['method' => 'POST']],
    ],



    '[dataset/classify]' => [
        'index' => ['dataset/classify/index', ['method' => 'GET']],
        'add' => ['dataset/classify/add', ['method' => 'POST']],
        'edit' => ['dataset/classify/edit', ['method' => 'POST']],
        'handleSort' => ['dataset/classify/handleSort', ['method' => 'POST']],
        'delete' => ['dataset/classify/delete', ['method' => 'DELETE']],
    ],

    '[dataset/notice]' => [
        'index' => ['dataset/notice/index', ['method' => 'POST']],
        'add' => ['dataset/notice/add', ['method' => 'POST']],
        'edit' => ['dataset/notice/edit', ['method' => 'POST']],
        'delete' => ['dataset/notice/delete', ['method' => 'POST']],
    ],

    '[home/base]' => [
        'login' => ['home/base/login', ['method' => 'POST']],
        'register' => ['home/base/register', ['method' => 'POST']],
        'getClassify' => ['home/base/getClassify', ['method' => 'GET']],
        'getNocite' => ['home/base/getNocite', ['method' => 'GET']],
        'getGoods' => ['home/base/getGoods', ['method' => 'POST']],
        'getGoodsDetail' => ['home/base/getGoodsDetail', ['method' => 'POST']],
        'getComment' => ['home/base/getComment', ['method' => 'POST']],
        'getNoticeDetail' => ['home/base/getNoticeDetail', ['method' => 'POST']],
        'getUserInfo' => ['home/base/getUserInfo', ['method' => 'POST']],
        'addScore' => ['home/base/addScore', ['method' => 'POST']],
    ],

    '[home/home]' => [
        'getUserInfo' => ['home/home/getUserInfo', ['method' => 'GET']],
        'editUserInfo' => ['home/home/editUserInfo', ['method' => 'POST']],
        'editAddress' => ['home/home/editAddress', ['method' => 'POST']],
        'addAddress' => ['home/home/addAddress', ['method' => 'POST']],
        'getAddress' => ['home/home/getAddress', ['method' => 'POST']],
        'delAddress' => ['home/home/delAddress', ['method' => 'POST']],
        'imageUpload' => ['home/home/imageUpload', ['method' => 'POST']],
        'addGoods' => ['home/home/addGoods', ['method' => 'POST']],
        'addFavourite' => ['home/home/addFavourite', ['method' => 'POST']],
        'addCart' => ['home/home/addCart', ['method' => 'POST']],
        'getFavourite' => ['home/home/getFavourite', ['method' => 'POST']],
        'delFavourite' => ['home/home/delFavourite', ['method' => 'POST']],
        'addComment' => ['home/home/addComment', ['method' => 'POST']],
        'addReply' => ['home/home/addReply', ['method' => 'POST']],
        'getMoney' => ['home/home/getMoney', ['method' => 'POST']],
        'addMoney' => ['home/home/addMoney', ['method' => 'POST']],
        'getCart' => ['home/home/getCart', ['method' => 'POST']],
        'delCart' => ['home/home/delCart', ['method' => 'POST']],
        'getOrderList' => ['home/home/getOrderList', ['method' => 'POST']],
        'addOrder' => ['home/home/addOrder', ['method' => 'POST']],
        'getMyBug' => ['home/home/getMyBug', ['method' => 'POST']],
        'getMySell' => ['home/home/getMySell', ['method' => 'POST']],
        'statusGoods' => ['home/home/statusGoods', ['method' => 'POST']],
        'editGoods' => ['home/home/editGoods', ['method' => 'POST']],
        'upload' => ['home/home/upload', ['method' => 'POST']],
        'getChatList' => ['home/home/getChatList', ['method' => 'POST']],
        'addChat' => ['home/home/addChat', ['method' => 'POST']],
        'deleteChat' => ['home/home/deleteChat', ['method' => 'POST']],
        'getChatDetail' => ['home/home/getChatDetail', ['method' => 'POST']],
        'getOrderDetail' => ['home/home/getOrderDetail', ['method' => 'POST']],
        'getMyScore' => ['home/home/getMyScore', ['method' => 'POST']],
        'getScoreList' => ['home/home/getScoreList', ['method' => 'POST']],
    ],



    // MISS路由
    '__miss__' => 'admin/base/miss',
];
