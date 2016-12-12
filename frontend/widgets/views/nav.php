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
//$topicActive = ($module == 'topic' && !$tag && $node != 'jobs') ? true : false;
$topicActive = ($module == 'topic' && !$tag && $node != 'jobs' && $node != 'dba-bar' ) ? true : false;
$tweetActive = ($module == 'tweet') ? true : false;
$topicTagsActive = $action == 'tags' || ($module == 'topic' && $tag) ? true : false;
$navActive = ($module == 'nav') ? true : false;
$jobsActive = ($node == 'jobs') ? true : false;
$lepusActive = ($node == 'lepus') ? true : false;
//add by ruyi
$dbabarActive = ($node == 'dba-bar') ? true : false;

NavBar::begin([
    // 'brandLabel' => Html::img('/images/logo.png'),
    'brandLabel' => 'DBA√China',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-white br0 navbar-fixed-top navbar',
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'nav navbar-nav'],
    'items' => [
        //['label' =>  Icon::show('th-large')  . '首页', 'url' => ['/site/index'] ],
        ['label' => Icon::show('comment-o') . '话题', 'url' => ['/topic'], 'active' => $topicActive],
        ['label' => Icon::show('file-word-o') . '文章', 'url' => ['/article'], 'active' => $topicActive],
        ['label' => Icon::show('envelope-o') . '招聘', 'url' => ['/topic/default/index', 'node' => 'jobs'], 'active' => $jobsActive],
        //['label' => Icon::show('github-alt') . 'Lepus', 'url' => ['/topic/default/index', 'node' => 'lepus'], 'active' => $lepusActive],
        ['label' => Icon::show('commenting-o') . '动弹', 'url' => ['/tweet'], 'active' => $tweetActive],
        //['label' => Icon::show('th') . '标签', 'url' => ['/site/tags'], 'active' => $topicTagsActive],
        //['label' => Icon::show('signal') . '新手入门', 'url' => ['/site/getstart']],
        //['label' => Icon::show('user') . '会员', 'url' => ['/site/users']],
        ['label' => Icon::show('link') . '站点', 'url' => ['/nav'], 'active' => $navActive],
        //['label' => Icon::show('folder-open')  .'手册', 'url' => ['/topic/default/view','id' =>'56' ]], //add by ruyi

    ],
    'encodeLabels' => false
]);
if (Yii::$app->params['setting']['xunsearch']) {
    echo '<form class="navbar-form navbar-left" role="search" action="/search" method="get">
                <div class="form-group">
                    <input type="text" value="' . $keyword . '" name="keyword" class="form-control search_input" id="navbar-search" placeholder="全文检索..." data-placement="bottom" data-content="请输入要搜索的关键词！">
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
?>

<div class="header_node">
    <div class="content">
    <div class="nav_home">
        <a href="/"><i class="layui-icon">&#xe609;</i>&nbsp;主页</a>
        <a href="">|</a>
    </div>
    <div class="nav_node">
        <?php foreach($my_nodes as $item): ?>
            <?= Html::a($item['name'], ['/topic/default/index', 'node' => $item['alias']],['class'=>'']) ?>
        <?php endforeach; ?>
    </div>
    </div>
</div>
