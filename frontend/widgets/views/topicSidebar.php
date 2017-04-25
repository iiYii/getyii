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

    <div class="<?= (request('id')) ? '' : null; ?>">
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




        <?php if ($node) {
            echo \frontend\widgets\Panel::widget([
                'title' => \Yii::t('app', 'Hot Node Articles'),
                'items' => $sameArticles,
            ]);
        }else{
            echo \frontend\widgets\Panel::widget([
                'title' => \Yii::t('app', 'Hot Articles'),
                'items' => $sameArticles,
            ]);
        }

        ?>

        <?php if ($node) {
            echo \frontend\widgets\Panel::widget([
                'title' => \Yii::t('app', 'Hot Node Topics'),
                'items' => $sameTopics,
            ]);
        }else{
            echo \frontend\widgets\Panel::widget([
                'title' => \Yii::t('app', 'Hot Topics'),
                'items' => $sameTopics,
            ]);
        }
        ?>


    </div>


</div>
<div class="clearfix"></div>
