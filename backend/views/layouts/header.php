<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->setting->get('siteName') . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li>
                    <?= Html::a(
                        'Logout (' . Yii::$app->user->identity->username . ')',
                        ['/site/logout'],
                        ['data-method' => 'post', 'class' => 'btn btn-flat']
                    ) ?>
                </li>
            </ul>
        </div>
    </nav>
</header>
