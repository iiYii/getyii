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

$node = Yii::$app->request->getQueryParam('node');
$topicActive = ($module == 'topic' && !$tag && $node != 'jobs' ) ? true : false;
$topicTagsActive = $action == 'tags' || ($module == 'topic' && $tag) ? true : false;
$navActive = ($module == 'nav') ? true : false;

$jobsActive = ($node == 'jobs') ? true : false;

<<<<<<< HEAD
// NavBar::begin([
//     'brandLabel' => Html::img('/images/logo.png'),
//     'brandUrl' => Yii::$app->homeUrl,
//     'options' => [
//         'class' => 'navbar-white br0',
//     ],
// ]);
// echo Nav::widget([
//     'options' => [
//         'class' => 'nav navbar-nav js-nav', 
//         ],
//     'items' => [
//         ['label' => '社区', 'url' => ['/topic'], 'active' => $topicActive],
// //        ['label' => 'Wiki', 'url' => ['/topic/default/index', 'node' => 'wiki']],
//         ['label' => '标签云', 'url' => ['/site/tags'], 'active' => $topicTagsActive],
//         ['label' => '新手入门', 'url' => ['/site/getstart']],
//         ['label' => '会员', 'url' => ['/site/users']],
//         ['label' => '关于', 'url' => ['/site/about']],
//         //['label' => '招聘', 'url' => ['/site/getstart']],
//     ],
// ]);
// if (Yii::$app->user->isGuest) {
//     $menuItems[] = ['label' => '注册', 'url' => ['/site/signup']];
//     $menuItems[] = ['label' => '登录', 'url' => ['/site/login']];
// } else {
    
//         // 个人中心
//     $menuItems[] = [
//         'label' => Html::img(Yii::$app->user->identity->getUserAvatar(28),['class' => 'img-circle img-responsive']),
//         'url'     => ['/user/default'], 
//         'linkOptions' => ['style' => 'padding-bottom:0']       
//     ];
    
//     // 撰写
//     $menuItems[] = [
//         'label' => Html::tag('i', '', ['class' => 'fa fa-bell']) . Html::tag('span', $notifyCount ? $notifyCount : null),
//         'url' => ['/notification/index'],
//         'linkOptions' => ['class' => $notifyCount ? 'new' : null],
//         'options' => ['class' => 'notification-count'],
//     ];
        
//     $menuItems[] = [
//       'label'     => '设置',
//       'url'         => ['/user/setting/profile'],
//       'options' => ['class' => ''],  
//     ];
    
//     $menuItems[] = [
//       'label'             => '退出',
//       'url'                => ['/site/logout'],
//       'options'        => ['class' => ''],  
//       'linkOptions' => ['data-method' => 'post'],
//     ];
// }
=======
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
        ['label' => Icon::show('comment')  .'社区', 'url' => ['/topic'], 'active' => $topicActive],
        ['label' => Icon::show('envelope')  .'招聘', 'url' => ['/topic/default/index', 'node' =>'jobs'], 'active' => $jobsActive],
        ['label' => Icon::show('th')  .'标签', 'url' => ['/site/tags'], 'active' => $topicTagsActive],
        ['label' => Icon::show('signal')  .'新手入门', 'url' => ['/site/getstart']],
        ['label' => Icon::show('user')  .'会员', 'url' => ['/site/users']],
        ['label' => Icon::show('plane')  .'酷站', 'url' => ['/nav'], 'active' => $navActive],

    ],
    'encodeLabels' => false
]);
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
>>>>>>> ormm/master

// echo Nav::widget([
//     'encodeLabels' => false,
//     'options' => ['class' => 'nav navbar-nav navbar-right'],
//     'items' => $menuItems,
//     'activateParents' => true,
// ]);
// NavBar::end();

?>
<div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="../" class="navbar-brand">Bootswatch</a>
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes" aria-expanded="false">Themes <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <li><a href="../default/">Default</a></li>
                <li class="divider"></li>
                <li><a href="../cerulean/">Cerulean</a></li>
                <li><a href="../cosmo/">Cosmo</a></li>
                <li><a href="../cyborg/">Cyborg</a></li>
                <li><a href="../darkly/">Darkly</a></li>
                <li><a href="../flatly/">Flatly</a></li>
                <li><a href="../journal/">Journal</a></li>
                <li><a href="../lumen/">Lumen</a></li>
                <li><a href="../paper/">Paper</a></li>
                <li><a href="../readable/">Readable</a></li>
                <li><a href="../sandstone/">Sandstone</a></li>
                <li><a href="../simplex/">Simplex</a></li>
                <li><a href="../slate/">Slate</a></li>
                <li><a href="../spacelab/">Spacelab</a></li>
                <li><a href="../superhero/">Superhero</a></li>
                <li><a href="../united/">United</a></li>
                <li><a href="../yeti/">Yeti</a></li>
              </ul>
            </li>
            <li>
              <a href="../help/">Help</a>
            </li>
            <li>
              <a href="http://news.bootswatch.com">Blog</a>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="download" aria-expanded="false">Paper <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="download">
                <li><a href="http://jsfiddle.net/bootswatch/ndax7sh7/">Open Sandbox</a></li>
                <li class="divider"></li>
                <li><a href="./bootstrap.min.css">bootstrap.min.css</a></li>
                <li><a href="./bootstrap.css">bootstrap.css</a></li>
                <li class="divider"></li>
                <li><a href="./variables.less">variables.less</a></li>
                <li><a href="./bootswatch.less">bootswatch.less</a></li>
                <li class="divider"></li>
                <li><a href="./_variables.scss">_variables.scss</a></li>
                <li><a href="./_bootswatch.scss">_bootswatch.scss</a></li>
              </ul>
            </li>
          </ul>

          <ul class="nav navbar-nav navbar-right">
            <li><a href="http://builtwithbootstrap.com/" target="_blank">Built With Bootstrap</a></li>
            <li><a href="https://wrapbootstrap.com/?ref=bsw" target="_blank">WrapBootstrap</a></li>
          </ul>

        </div>
      </div>
    </div>
