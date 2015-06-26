<?php
use frontend\assets\AppAsset;
use frontend\assets\BowerAsset;
use frontend\widgets\Alert;

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
    <meta name="keywords" content="<?= \Yii::$app->setting->get('siteKeyword') ?>" />
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">

    <?= \frontend\widgets\Nav::widget(); ?>

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
            <div class="col-sm-3">
                <dt> 技术采用 </dt>
                <dd> 由 <a href="https://github.com/forecho">forecho</a> 创建 项目地址: <a href="https://github.com/iiyii/getyii">getyii</a> </dd>
                <dd> <?= Yii::powered() ?> <?= Yii::getVersion() ?> </dd>
            </div>
            <div class="col-sm-3">
                <a href="http://www.qiniu.com/">
                    <img src="http://assets.qiniu.com/qiniu-transparent.png" alt="qiniu" width="240">
                </a>
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