<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/18 下午4:16
 * description:
 */
use yii\helpers\Html;

$module = Yii::$app->controller->module->id;
$action = Yii::$app->controller->action->id;
$node = $config['node'];

/** @var array|\frontend\modules\user\models\Donate $donate */
?>
<div class="col-md-3 side-bar p0">

    <div class="<?= (request('id')) ? 'p-fixed' : null; ?>">
        <?php if (Yii::$app->user->isGuest): ?>
            <div class="panel panel-default corner-radius">
                <div class="panel-heading text-center">
                    <h3 class="panel-title"><?= Yii::t('app', 'Join Us') ?></h3>
                </div>
                <div class="panel-body text-center">
                    <span>欢迎来到DBACHINA，学习数据库专业知识，分享交流数据库相关话题、探索DBA职业生涯。从注册一个账号开始。</span>
                    <hr/>
                    <div class="btn-group">
                        <?= Html::a(
                            \Yii::t('app', 'Now Register'),
                            ['/signup'],
                            ['class' => 'btn btn-primary ']
                        ) ?>
                        <?= Html::a(
                            \Yii::t('app', 'Now Login'),
                            ['/login'],
                            ['class' => 'btn btn-danger', 'style' => ' margin-left:3px;']
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
                            ['class' => 'btn btn-primary btn-block']
                        ) ?>
                    </div>
                </div>
            </div>
        <?php endif ?>

        <?php if ($action=='index' || $action=='create' || $node): ?>
            <div class="panel panel-default corner-radius">
                <div class="panel-heading text-center">
                    <h3 class="panel-title"><?= \Yii::t('app', 'Tips and Tricks'); ?></h3>
                </div>
                <div class="panel-body">
                    <?= \yii\helpers\Markdown::process($tips, 'gfm'); ?>
                </div>
            </div>

        <?php endif ?>

        <?php if ($action=='index' || $action=='create') {
            echo \frontend\widgets\Panel::widget([
                'title' => \Yii::t('app', 'Recomended Resources'),
                'items' => $recommendResources,
            ]);
        } ?>

        <?php //echo $action; exit; ?>
        <?php if (!$config['node'] && !empty($links) && $module=='topic' && $action=='index'): ?>
            <div class="panel panel-default corner-radius">
                <div class="panel-heading text-center">
                    <h3 class="panel-title">合作伙伴</h3>
                </div>
                <div class="panel-body">
                    <?= Html::img(Yii::getAlias('@web/ads/qrcode_tunyun.jpg'), ['width' => 250]); ?>
                    <p>专注企业数据库创新服务和Oracle数据库干货分享</p>
                </div>
            </div>
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


        <?php if ($node) {
            echo \frontend\widgets\Panel::widget([
                'title' => \Yii::t('app', 'Same Node Topics'),
                'items' => $sameTopics,
            ]);
        } ?>


        <?php \frontend\widgets\Panel::widget([
            'title' => \Yii::t('app', 'Site Status'),
            'items' => [],
        ]) ?>


    </div>


</div>
<div class="clearfix"></div>
