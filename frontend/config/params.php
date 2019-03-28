<?php
return [
    'adminEmail' => 'admin@example.com',
    'donateNode' => ['tricks'], // 开启打赏分类
    'loginNode' => ['jobs'], // 需要登录才能访问的分类
    'donateTag' => ['求打赏', '技巧库'], // 开启标签
    'newUserPostLimit' => 0, // 防止 spam，可限制新注册用户多少秒之后才能发帖，默认0代表不限制，单位是秒
    'setting' => [
        'xunsearch' => false, // true 表示开启 GetYii xunsearch 搜索功能，默认不开启
    ],
];
