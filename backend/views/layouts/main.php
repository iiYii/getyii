<?php
use backend\assets\AppAsset;
use backend\assets\BackendAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\widgets\Menu;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

BackendAsset::register($this);
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>
    <div id="wrapper">

        <?php
            NavBar::begin([
                'brandLabel' => Yii::$app->setting->get('siteName'),
                'brandUrl' => Yii::$app->homeUrl,
                'innerContainerOptions' => [
                    'class' => ''
                ],
                'options' => [
                    'class' => 'navbar-default navbar-fixed-top ',
                ],
            ]);

             echo Nav::widget([
                 'options' => ['class' => 'navbar-nav navbar-right', 'id' => 'navbar-main'],
                 'items' => [
                     ['label' => 'Home', 'url' => ['/site/index']],
                     ['label' => 'About', 'url' => ['/site/about']],
                     ['label' => 'Contact', 'url' => ['/site/contact']],
                     [
                         'label' => 'Products', 'url' => ['product/index'],
                         'items' => [
                             ['label' => 'New Arrivals', 'url' => ['product/index', 'tag' => 'new']],
                             ['label' => 'Most Popular', 'url' => ['product/index', 'tag' => 'popular']],
                     ]],
                     Yii::$app->user->isGuest ?
                         ['label' => 'Login', 'url' => ['/site/login']] :
                         ['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                             'url' => ['/site/logout'],
                             'linkOptions' => ['data-method' => 'post']],
                 ],
             ]);

        ?>

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <?php echo Menu::widget([
                        'options'=>['class'=>'nav', 'id'=>'side-menu'],
                        'submenuTemplate' => "\n<ul class='nav nav-second-level collapse'>\n{items}\n</ul>\n",
                        'items' => [
                            ['label' => '用户管理', 'url' => ['/user/index']],
                            ['label' => '文章管理', 'url' => ['/post/index']],
                            ['label' => '分类管理', 'url' => ['/post-meta']],
                            ['label' => '网站配置', 'url' => ['/setting/default']],
                            [
                                'label' => '网站导航', 'url' => '#',
                                'items' => [
                                    ['label' => '导航分类', 'url' => ['/nav/index']],
                                    ['label' => '导航链接', 'url' => ['/nav-url/index']],
                                ]
                            ],
                            [
                                'label' => '积分模块', 'url' => '#',
                                'items' => [
                                    ['label' => '积分模板', 'url' => ['/merit/merit-template']],
                                    ['label' => '会员积分', 'url' => ['/merit/merit']],
                                    ['label' => '积分日志', 'url' => ['/merit/merit-log']],
                                ]
                            ],
                            ['label' => '搜索日志', 'url' => ['/search-log/index']],
                            ['label' => '右边栏设置', 'url' => ['/right-link/index']],
                            ['label' => 'Login', 'url' => ['/site/login'], 'visible' => Yii::$app->user->isGuest],
                        ],
                    ]); ?>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->

        <?php NavBar::end(); ?>
        <div id="page-wrapper">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

