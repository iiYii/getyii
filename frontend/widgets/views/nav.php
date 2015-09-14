<?php
/**
 * author     : forecho <caizh@snsshop.com>
 * createTime : 2015/4/23 17:23
 * description:
 */
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use common\models\PostMeta;
use kartik\icons\Icon;

Icon::map($this);

$module = Yii::$app->controller->module->id;
$action = Yii::$app->controller->action->id;
$tag = Yii::$app->request->getQueryParam('tag');
$keyword = Yii::$app->request->getQueryParam('keyword');

$node = Yii::$app->request->getQueryParam('node');
$topicActive = ($module == 'topic' && !$tag && $node != 'jobs') ? true : false;
$tweetActive = ($module == 'tweet') ? true : false;
$topicTagsActive = $action == 'tags' || ($module == 'topic' && $tag) ? true : false;
$navActive = ($module == 'nav') ? true : false;

$jobsActive = ($node == 'jobs') ? true : false;

NavBar::begin([
    // 'brandLabel' => Html::img('/images/logo.png'),
    'brandLabel' => 'Get√Yii',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-white br0',
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'nav navbar-nav '],
    'items' => [
//        ['label' =>  Icon::show('th-large')  . '首页', 'url' => ['/site/index'] ],
        ['label' => Icon::show('comment') . '社区', 'url' => ['/topic'], 'active' => $topicActive],
//        ['label' => Icon::show('envelope') . '招聘', 'url' => ['/topic/default/index', 'node' => 'jobs'], 'active' => $jobsActive],
        ['label' => Icon::show('commenting') . '动弹', 'url' => ['/tweet'], 'active' => $tweetActive],
        ['label' => Icon::show('th') . '标签', 'url' => ['/site/tags'], 'active' => $topicTagsActive],
        ['label' => Icon::show('signal') . '新手入门', 'url' => ['/site/getstart']],
        ['label' => Icon::show('user') . '会员', 'url' => ['/site/users']],
        ['label' => Icon::show('plane') . '酷站', 'url' => ['/nav'], 'active' => $navActive],

    ],
    'encodeLabels' => false
]);
if (Yii::$app->params['setting']['xunsearch']) {
    echo '<form class="navbar-form navbar-left" role="search" action="/search" method="get">
                <div class="form-group">
                    <input type="text" value="' . $keyword . '" name="keyword" class="form-control search_input" id="navbar-search" placeholder="搜索..." data-placement="bottom" data-content="请输入要搜索的关键词！">
                </div>
            </form>';
}


if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => '注册', 'url' => ['/site/signup']];
    $menuItems[] = ['label' => '登录', 'url' => ['/site/login']];
} else {
    // 撰写
    $menuItems[] = [
        'label' => Html::tag('i', '', ['class' => 'fa fa-bell']) . Html::tag('span', $notifyCount ? $notifyCount : null),
        'url' => ['/notification/index'],
        'linkOptions' => ['class' => $notifyCount ? 'new' : null],
        'options' => ['class' => 'notification-count'],
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
    'options' => ['class' => 'nav navbar-nav navbar-right'],
    'items' => $menuItems,
    'activateParents' => true,
]);
NavBar::end();
