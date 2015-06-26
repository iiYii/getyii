<?php
/**
 * author     : forecho <caizh@snsshop.com>
 * createTime : 2015/4/23 17:23
 * description:
 */
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

$module = Yii::$app->controller->module->id;
$action = Yii::$app->controller->action->id;
$tag = Yii::$app->request->getQueryParam('tag');
$topicActive = ($module == 'topic' && !$tag) ? true : false;
$topicTagsActive = $action == 'tags' || ($module == 'topic' && $tag) ? true : false;

NavBar::begin([
    'brandLabel' => Html::img('/images/logo.png'),
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-white br0',
    ],
]);
echo Nav::widget([
    'options' => [
        'class' => 'nav navbar-nav js-nav', 
        ],
    'items' => [
        ['label' => '社区', 'url' => ['/topic'], 'active' => $topicActive],
//        ['label' => 'Wiki', 'url' => ['/topic/default/index', 'node' => 'wiki']],
        ['label' => '标签云', 'url' => ['/site/tags'], 'active' => $topicTagsActive],
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
    
        // 个人中心
    $menuItems[] = [
        'label' => Html::img(Yii::$app->user->identity->getUserAvatar(28),['class' => 'img-circle img-responsive']),
        'url'     => ['/user/default'], 
        'linkOptions' => ['style' => 'padding-bottom:0']       
    ];
    
    // 撰写
    $menuItems[] = [
        'label' => Html::tag('i', '', ['class' => 'fa fa-bell']) . Html::tag('span', $notifyCount ? $notifyCount : null),
        'url' => ['/notification/index'],
        'linkOptions' => ['class' => $notifyCount ? 'new' : null],
        'options' => ['class' => 'notification-count'],
    ];
        
    $menuItems[] = [
      'label'     => '设置',
      'url'         => ['/user/setting/profile'],
      'options' => ['class' => ''],  
    ];
    
    $menuItems[] = [
      'label'             => '退出',
      'url'                => ['/site/logout'],
      'options'        => ['class' => ''],  
      'linkOptions' => ['data-method' => 'post'],
    ];
}

echo Nav::widget([
    'encodeLabels' => false,
    'options' => ['class' => 'nav navbar-nav navbar-right'],
    'items' => $menuItems,
    'activateParents' => true,
]);
NavBar::end();

?>

