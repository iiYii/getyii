<?php

use frontend\assets\AppAsset;
use frontend\assets\BowerAsset;
use frontend\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

//use frontend\assets\EmojifyAsset;


/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
BowerAsset::register($this);

rmrevin\yii\fontawesome\AssetBundle::register($this);
\frontend\assets\EditorAsset::register($this);
//$emojify = EmojifyAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> - <?= \Yii::$app->setting->get('siteTitle') ?></title>
    <meta name="keywords" content="<?= \Yii::$app->setting->get('siteKeyword') ?>"/>
    <script type="text/javascript" src="https://cdn.wwads.cn/js/makemoney.js" async></script>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">

    <?= \frontend\widgets\Nav::widget(); ?>

    <div class="container">
        <div class="row">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="row">
            <dl class="col-sm-2">
                <dt>网站信息</dt>
                <dd><a href="<?= Url::to(['/site/users']) ?>">活跃会员</a></dd>
                <dd><a href="<?= Url::to(['/site/contributors']) ?>">贡献者</a></dd>
            </dl>
            <dl class="col-sm-2">
                <dt>相关合作</dt>
                <dd><a href="<?= Url::to(['/site/contact']) ?>">联系我们</a></dd>
            </dl>
            <dl class="col-sm-2">
                <dt>关注我们</dt>
                <dd><a href="<?= Url::to(['/site/about']) ?>">关于我们</a></dd>
                <dd><a href="<?= Url::to(['/site/timeline']) ?>">时间线</a></dd>
            </dl>
            <dl class="col-sm-3">
                <dt> 技术采用</dt>
                <dd class="fs12">
                    由 <a href="https://github.com/forecho">forecho</a> 创建 项目地址: <a
                            href="https://github.com/iiyii/getyii">GetYii</a>
                    <br/>
                    <?= Yii::powered() ?> <?= Yii::getVersion() ?>
                    <br/>
                    &copy; <?= \Yii::$app->setting->get('siteName') ?> <?= date('Y') ?>
                    &nbsp;•&nbsp; <?= floor(Yii::getLogger()->getElapsedTime() * 1000) . ' ms'; ?>
                </dd>
            </dl>
            <div class="col-sm-3">
                <p>赞助本站，你的LOGO将出现在这里</p>
            </div>
        </div>
    </div>
</footer>

<div class="btn-group-vertical" id="floatButton">
    <button type="button" class="btn btn-default" id="goTop" title="去顶部"><span
                class="glyphicon glyphicon-arrow-up"></span></button>
    <button type="button" class="btn btn-default" id="refresh" title="刷新"><span
                class="glyphicon glyphicon-repeat"></span></button>
    <button type="button" class="btn btn-default" id="pageQrcode" title="本页二维码"><span
                class="glyphicon glyphicon-qrcode"></span>
        <img class="qrcode" width="130" height="130"
             src="<?= Url::to(['/site/qr', 'text' => Yii::$app->request->absoluteUrl]) ?>"/>
    </button>
    <button type="button" class="btn btn-default" id="goBottom" title="去底部"><span
                class="glyphicon glyphicon-arrow-down"></span></button>
</div>

<div style="display:none">
    <?= \Yii::$app->setting->get('siteAnalytics'); ?>
</div>

<?php
//$this->registerJs(
//    'Config = {emojiBaseUrl: "' . $emojify->baseUrl . '"};',
//    \yii\web\View::POS_HEAD
//);
?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
