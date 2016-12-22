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
                        <?php
                        if($node) {
                            echo Html::a(
                                \Yii::t('app', 'New Question'),
                                ['/question/default/create', 'id' => 'id', 'meta_id' => $node->id],
                                ['class' => 'btn btn-primary btn-block']
                            );
                        }else{
                            echo Html::a(
                                \Yii::t('app', 'New Question'),
                                ['/question/default/create', 'id' => 'id'],
                                ['class' => 'btn btn-primary btn-block']
                            );
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php endif ?>

        <?php if ($action=='create'): ?>
            <div class="panel panel-default corner-radius">
                <div class="panel-heading text-center">
                    <h3 class="panel-title">提问须知</h3>
                </div>
                <div class="panel-body">
                    <h3>1.先搜索，再提问</h3>
                    你提问前有在 Google、百度或者我们的 搜索栏 先行搜索过吗？使用搜索（引擎），能更快地帮你找到答案。即使没找到，在看了相关或者类似的问题之后，你的提问会更准确。
                    <h3>2.尽量清楚、详细地描述问题</h3>
                    标题 清晰明了，内容 包含必要的操作环境、截图和代码、期望结果与实际结果;善用 编辑器 排版你的问题，提高可读性;准确地使用多个标签标记你的问题。
                    <h3>3.保持求知欲</h3>
                    或许最后得到的答案并不是你最想要的，但深思熟虑过的问题依旧可能会让你有其他方面的收获。每个人的成长都是一步步来的，所以，Keep an open mind。
                </div>
            </div>

        <?php endif ?>



    </div>


</div>
<div class="clearfix"></div>
