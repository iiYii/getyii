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
                    <span>这里是一个分享、交流、探索数据库、职业生涯、生活趣事的地方。</span>
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
                            \Yii::t('app', 'New Article'),
                            ['/article/default/create', 'id' => 'id'],
                            ['class' => 'btn btn-primary btn-block']
                        ) ?>
                    </div>
                </div>
            </div>
        <?php endif ?>


        <?php if ($node) {
            echo \frontend\widgets\Panel::widget([
                'title' => \Yii::t('app', 'Same Node Articles'),
                'items' => $sameArticles,
            ]);
        } ?>


        <?php \frontend\widgets\Panel::widget([
            'title' => \Yii::t('app', 'Site Status'),
            'items' => [],
        ]) ?>


    </div>


</div>
<div class="clearfix"></div>
