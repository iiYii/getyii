<?php
use frontend\assets\AppAsset;
use frontend\assets\BowerAsset;
use frontend\widgets\Alert;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

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
    <title><?= Html::encode($this->title) ?></title>
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
            ['label' => '首页', 'url' => ['/site/index']],
            // ['label' => 'About', 'url' => ['/site/about']],
            ['label' => '手册', 'url' => ['/site/book'], 'linkOptions' =>['target' => '_banck']],
            // ['label' => 'Services', 'url' => ['/site/services']],
            // ['label' => 'Portfolio', 'url' => ['/site/portfolio']],
            ['label' => '博客', 'url' => ['/post/index']],
            ['label' => 'FAQ', 'url' => ['/site/faq'], 'linkOptions' =>['target' => '_banck']],
            // ['label' => 'Contact', 'url' => ['/site/contact']],
        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => '注册', 'url' => ['/site/signup']];
            $menuItems[] = ['label' => '登录', 'url' => ['/site/login']];
        } else {
            // 个人中心
            $menuItems[] = [
                'label' => Yii::$app->user->identity->username,
                'items' => [
                    ['label' => '个人中心', 'url' => ['/user/default']],
                    ['label' => '设置', 'url' => ['/user/setting/profile']],
                    ['label' => '退出','url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']]
                ]
            ];
            // $menuItems[] = ['label' => Yii::$app->user->identity->username, 'url' => ['/user/default']];
            // $menuItems[] = ['label' => '设置', 'url' => ['/user/setting/profile']];
            // $menuItems[] = [
            //     'label' => '退出',
            //     'url' => ['/site/logout'],
            //     'linkOptions' => ['data-method' => 'post']
            // ];
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
                <h4>最新文章</h4>

                <div>
                    <div class="media">
                        <div class="pull-left">
                            <img src="/images/blog/thumb1.jpg" alt="">
                        </div>
                        <div class="media-body">
                            <span class="media-heading"><a href="#">Pellentesque habitant morbi tristique
                                    senectus</a></span>
                            <small class="muted">Posted 17 Aug 2013</small>
                        </div>
                    </div>
                    <div class="media">
                        <div class="pull-left">
                            <img src="/images/blog/thumb2.jpg" alt="">
                        </div>
                        <div class="media-body">
                            <span class="media-heading"><a href="#">Pellentesque habitant morbi tristique
                                    senectus</a></span>
                            <small class="muted">Posted 13 Sep 2013</small>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.col-md-3-->

            <div class="col-md-3 col-sm-6">
                <h4>联系我们</h4>
                <address>
                    <strong>深圳.中国</strong><br>
                </address>
                <h4>QQ群</h4>
                    321493381

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
                &copy; 2015 <a target="_blank" href="http://www.getyii.net/">GetYii</a>.
                All Rights Reserved.
            </div>
            <div class="col-sm-6">
                <ul class="pull-right">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Faq</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a id="gototop" class="gototop" href="#"><i class="icon-chevron-up"></i></a></li>
                    <!--#gototop-->
                </ul>
            </div>
        </div>
    </div>
</footer>
<!--/#footer-->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>