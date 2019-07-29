<?php
return [
    'adminEmail' => 'admin@example.com',
    'donateNode' => ['tricks'], // 开启打赏分类
    'loginNode' => ['jobs'], // 需要登录才能访问的分类
    'donateTag' => ['求打赏', '技巧库'], // 开启标签
    'postingIntervalLimit' => 3600, // 限制发帖间隔，单位秒。默认是 1 个小时
    'setting' => [
        'xunsearch' => false, // true 表示开启 GetYii xunsearch 搜索功能，默认不开启
    ],
];
