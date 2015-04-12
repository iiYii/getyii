<?php
use frontend\assets\AppAsset;
use frontend\assets\BowerAsset;
use frontend\widgets\Alert;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\widgets\NewestPost;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
BowerAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> - <?= \Yii::$app->setting->get('siteTitle') ?></title>
    <?php $this->head() ?>
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head>
<body>
<?php $this->beginBody() ?>
<header class="navbar navbar-inverse navbar-fixed-top wet-asphalt" role="banner">
    <div class="container">
        <?php
        NavBar::begin([
            // 'brandLabel' => Html::img('/images/logo.png'),
            'brandLabel' => 'Get√Yii',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-header',
            ],
        ]);
        $menuItems = [
            ['label' => '首页', 'url' => ['/site']],
            ['label' => '新手入门', 'url' => ['/site/getstart']],
            // ['label' => '手册', 'url' => ['/site/book'], 'linkOptions' =>['target' => '_banck']],
            // ['label' => 'Services', 'url' => ['/site/services']],
            // ['label' => 'Portfolio', 'url' => ['/site/portfolio']],
            ['label' => '博客', 'url' => ['/blog']],
            ['label' => '社区', 'url' => ['/topic']],
            // ['label' => 'FAQ', 'url' => ['/site/faq'], 'linkOptions' =>['target' => '_banck']],
            // ['label' => 'Contact', 'url' => ['/site/contact']],
        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => '注册', 'url' => ['/site/signup']];
            $menuItems[] = ['label' => '登录', 'url' => ['/site/login']];
        } else {
            // 撰写
            $menuItems[] = [
                'label' => '撰写',
                'items' => [
                    ['label' => '写教程', 'url' => ['/blog/create']],
                ]
            ];

            // 个人中心
            $menuItems[] = [
                'label' => Yii::$app->user->identity->username,
                'items' => [
                    ['label' => '我的主页', 'url' => ['/user/default']],
                    ['label' => '帐号设置', 'url' => ['/user/setting/profile']],
                    ['label' => '退出','url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']]
                ]
            ];
        }
        echo Nav::widget([
            'options' => ['class' => 'nav navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);
        NavBar::end();
        ?>
    </div>
</header>
<!--/header-->

<?php if (isset($this->params['breadcrumbs'])): ?>
    <section id="title" class="emerald">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h1><?= isset($this->title) ? $this->title : '' ?></h1>
                    <!-- <p>message</p> -->
                </div>
                <div class="col-sm-6">
                    <?= Breadcrumbs::widget([
                        'options' => ['class' => 'breadcrumb pull-right'],
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
                </div>
            </div>
        </div>
    </section><!--/#title-->
<?php endif ?>

<?= Alert::widget() ?>
<?= $content ?>

<section id="bottom" class="wet-asphalt">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <h4>关于我们</h4>

                <p>因为热爱 Yii，我们相聚在这里，我们会持续关注于 Yii 开发的项目。</p>

                <p>如果您有时间和兴趣请联系</br> QQ：314494687 </br> Mail：caizhenghai@gmail.com </br>申请加入我们的开发团队。</p>
            </div>
            <!--/.col-md-3-->

            <div class="col-md-3 col-sm-6">
                <h4>最新文章</h4>
                <?php $post = NewestPost::begin() ?>
                <?php foreach ($post->post as $key => $value): ?>
                    <div class="media">
                        <div class="media-body">
                            <?php switch ($value->type) {
                                case 'blog':
                                    echo Html::tag('span', Html::a($value->title, ['/blog/view', 'id' => $value->id]), ['class' => 'media-heading']);
                                    break;

                                default:
                                    echo Html::tag('span', Html::a($value->title, ['/topic/view', 'id' => $value->id]), ['class' => 'media-heading']);
                                    break;
                            } ?>
                            <?= Html::tag('small', Yii::$app->formatter->asRelativeTime($value->created_at), ['class' => 'muted']);?>
                        </div>
                    </div>
                <?php endforeach ?>
                <?php NewestPost::end() ?>
            </div>
            <!--/.col-md-3-->

            <div class="col-md-2 col-sm-6">
                <h4>友情链接</h4>

                <div>
                    <ul class="arrow">
                        <li><a href="http://www.yiichina.com/" target="_banck">YiiChina</a></li>
                        <li><a href="http://yincart.com/" target="_banck">YinCart</a></li>
                        <li><a href="http://www.yiibook.com/" target="_banck">YiiBook</a></li>
                        <li><a href="http://www.yiifans.com/" target="_banck">YiiFans</a></li>
                        <li><a href="http://www.yiichina.com/" target="_banck">YiiChina</a></li>
                        <li><a href="http://www.cmsboom.com/" target="_banck">DCMS</a></li>
                    </ul>
                </div>
            </div>
            <!--/.col-md-3-->

            <div class="col-md-3 col-sm-6">
                <h4>联系我们</h4>
                <address>
                    <strong>深圳.中国</strong><br>
                </address>
                <h4>QQ群</h4>
                    Yii2 中国交流群：343188481
                    <br>
                    Get√Yii 核心开发者群：321493381（本群只接受参与本站开发的 Yiier）
            </div>
            <!--/.col-md-3-->
        </div>
    </div>
</section>
<!--/#bottom-->

<footer id="footer" class="midnight-blue">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                &copy; 2015 <a target="_blank" href="http://www.getyii.com/">GetYii</a>.
                All Rights Reserved.
            </div>
            <div class="col-sm-6">
                <ul class="pull-right">
                    <?= Html::tag('li', Html::a('首页', ['/']));?>
                    <?= Html::tag('li', Html::a('关于', ['/site/about']));?>
                    <?= Html::tag('li', Html::a('FAQ', ['/site/faq']));?>
                    <?= Html::tag('li', Html::a('活跃用户', ['/site/users']));?>
                    <?= Html::tag('li', Html::a('贡献者', ['/site/contributors']));?>
                    <?= Html::tag('li', Html::a('广告投放', ['/']));?>
                    <?= Html::tag('li', Html::a('反馈', ['/topic/index', 'tag' => 'suggestion']));?>
                    <li><a href="https://github.com/iiYii/getyii" target="_blank">GitHub</a></li>
                    <li><a id="gototop" class="gototop" href="#"><i class="icon-chevron-up"></i></a></li>
                    <!--#gototop-->
                </ul>
            </div>
        </div>
    </div>
</footer>
<!--/#footer-->

<div style="display:none">
<?= \Yii::$app->setting->get('siteAnalytics'); ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>