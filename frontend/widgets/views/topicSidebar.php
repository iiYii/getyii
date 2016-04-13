<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/18 下午4:16
 * description:
 */
use yii\helpers\Html;

$node = $config['node'];
/** @var array|\frontend\modules\user\models\Donate $donate */
?>
<div class="col-md-3 side-bar p0">

    <?php if (Yii::$app->user->isGuest): ?>
        <div class="panel panel-default corner-radius">
                <div class="panel-heading text-center">
                    <h3 class="panel-title"><?= Yii::t('app', 'Join Us') ?></h3>
                </div>
            <div class="panel-body text-center">
                <span>这里是一个分享、交流、探索数据库、职业生涯、生活趣事的地方。</span>
                <hr/>
                <div class="btn-group">
                    <?= Html::a(
                        \Yii::t('app', 'Now Register'),
                        ['/signup'],
                        ['class' => 'btn btn-info']
                    ) ?>
                    <?= Html::a(
                        \Yii::t('app', 'Now Login'),
                        ['/login'],
                        ['class' => 'btn btn-warning', 'style'=>' margin-left:3px;']
                    ) ?>
                </div>
            </div>
        </div>
    <?php endif ?>

    <?php if (!\Yii::$app->user->isGuest && $config['type'] != 'create'): ?>
        <div class="panel panel-default corner-radius">

            <?php if ($node): ?>
                <div class="panel-heading text-center">
                    <h3 class="panel-title"><?= $node->name ?></h3>
                </div>
            <?php endif ?>
            <?php if (!$node): ?>
                <div class="panel-heading text-center">
                    <h3 class="panel-title"><?= \Yii::t('app', 'Community') ?></h3>
                </div>
            <?php endif ?>

            <div class="panel-body text-center">
                <div class="btn-group">
                    <?= Html::a(
                        \Yii::t('app', 'New Topic'),
                        ['/topic/default/create', 'id' => 'id'],
                        ['class' => 'btn btn-success']
                    ) ?>
                </div>
            </div>
        </div>
    <?php endif ?>

    <?php if (!$config['node'] && !empty($links)): ?>
        <div class="panel panel-default corner-radius">
            <div class="panel-heading text-center">
                <h3 class="panel-title"><?= \Yii::t('app', 'Links') ?></h3>
            </div>
            <div class="panel-body text-center" style="padding-top: 5px;">
                <?php foreach ($links as $key => $value) {
                    echo Html::a(
                        Html::img($value->image),
                        $value->url,
                        ['class' => 'list-group-item', 'target' => '_blank', 'title' => $value->title]
                    );
                } ?>
            </div>
        </div>
    <?php endif ?>

    <?php if (!$node) {
        echo \frontend\widgets\Panel::widget([
            'title' => \Yii::t('app', 'Recomended Resources'),
            'items' => $recommendResources,
        ]);
    } ?>

    <?php if ($node && $donate): ?>
        <div class="panel panel-default corner-radius">
            <div class="panel-heading text-center">
                <h3 class="panel-title"><?= \Yii::t('app', 'Donate'); ?></h3>
            </div>
            <div class="panel-body donate">
                <?= Html::img(params('qrCodeUrl') . '/' . $donate->qr_code, ['class' => 'img']) ?>
                <p><?= $donate->description ?></p>
            </div>
        </div>
    <?php endif ?>

    <?php if ($node) {
        echo \frontend\widgets\Panel::widget([
            'title' => \Yii::t('app', 'Same Node Topics'),
            'items' => $sameTopics,
        ]);
    } ?>

    <div class="panel panel-default corner-radius">
        <div class="panel-heading text-center">
            <h3 class="panel-title"><?= \Yii::t('app', 'Tips and Tricks'); ?></h3>
        </div>
        <div class="panel-body">
            <?= \yii\helpers\Markdown::process($tips, 'gfm'); ?>
        </div>
    </div>

    <?php \frontend\widgets\Panel::widget([
        'title' => \Yii::t('app', 'Site Status'),
        'items' => [],
    ]) ?>


</div>
<div class="clearfix"></div>
