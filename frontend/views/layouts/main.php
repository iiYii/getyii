<?php
use frontend\assets\AppAsset;
use frontend\assets\BowerAsset;
use frontend\widgets\Alert;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;
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
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        // 'brandLabel' => Html::img('/images/logo.png'),
        'brandLabel' => 'Get√Yii',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-white',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'nav navbar-nav'],
        'items' => [
            ['label' => '社区', 'url' => ['/topic']],
            ['label' => 'Wiki', 'url' => ['/site/getstart']],
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
            'label' => '',
            'url' => ['/site/getstart'],
            'linkOptions' => ['class' => 'fa fa-bell'],
            'options' => ['class' => 'notification-count']
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

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-2">
                <dt>网站信息</dt>
                <dd> <a href="<?= Url::to(['/site/about']) ?>">关于我们</a> </dd>
                <dd> <a href="<?= Url::to(['/site/contributors']) ?>">贡献者</a> </dd>
            </div>
            <div class="col-sm-2">
                <dt>相关合作</dt>
                <dd> <a href="<?= Url::to(['/site/contact']) ?>">联系我们</a> </dd>
            </div>
            <div class="col-sm-2">
                <dt>关注我们</dt>
                <dd> <a href="<?= Url::to(['/site/timeline']) ?>">时间线</a> </dd>
            </div>
            <div class="col-sm-6">
                <dt> 技术采用 </dt>
                <dd> 由 <a href="https://github.com/forecho">forecho</a> 创建 项目地址: <a href="https://github.com/iiyii/getyii">getyii</a> </dd>
                <dd> <?= Yii::powered() ?> <?= Yii::getVersion() ?> </dd>
            </div>
        </div>
    </div>
</footer>

<div style="display:none">
<?= \Yii::$app->setting->get('siteAnalytics'); ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>