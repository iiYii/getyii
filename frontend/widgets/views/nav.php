<?php
/**
 * author     : forecho <caizh@snsshop.com>
 * createTime : 2015/4/23 17:23
 * description:
 */
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

NavBar::begin([
    // 'brandLabel' => Html::img('/images/logo.png'),
    'brandLabel' => 'Get√Yii',
    'brandUrl'   => Yii::$app->homeUrl,
    'options'    => [
        'class' => 'navbar-white',
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'nav navbar-nav'],
    'items'   => [
        ['label' => '社区', 'url' => ['/topic']],
        ['label' => 'Wiki', 'url' => ['/topic/default/index', 'node'=>'wiki']],
        ['label' => '新手入门', 'url' => ['/site/getstart']],
        ['label' => '会员', 'url' => ['/site/users']],
        ['label' => '关于', 'url' => ['/site/about']],
        //['label' => '招聘', 'url' => ['/site/getstart']],
    ],
]);
if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => '注册', 'url' => ['/site/signup']];
    $menuItems[] = ['label' => '登录', 'url' => ['/site/login']];
} else {
    // 撰写
    $menuItems[] = [
        'label'       => Html::tag('i', '', ['class' => 'fa fa-bell']) . Html::tag('span', $notifyCount ? $notifyCount : null),
        'url'         => ['/notification/index'],
        'linkOptions' => ['class' => $notifyCount ? 'new' : null],
        'options'     => ['class' => 'notification-count'],
    ];

    // 个人中心
    $menuItems[] = [
        'label' => Yii::$app->user->identity->username,
        'items' => [
            ['label' => '我的主页', 'url' => ['/user/default']],
            ['label' => '帐号设置', 'url' => ['/user/setting/profile']],
            ['label' => '退出', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']]
        ]
    ];
}

echo Nav::widget([
    'encodeLabels' => false,
    'options'      => ['class' => 'nav navbar-nav navbar-right'],
    'items'        => $menuItems,
]);
NavBar::end();
