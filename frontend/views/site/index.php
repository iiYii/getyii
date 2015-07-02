<?php
use yii\helpers\Html;
use kartik\icons\Icon;

Icon::map($this);

$this->title = \Yii::$app->setting->get('siteName');
?>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="text-center"><?= \Yii::t('app', 'site_intro') ?></div>
        </div>
    </div>



    <div class="panel panel-default list-panel">
        <div class="panel-heading">
            <h3 class="panel-title text-center">
                <?= \Yii::t('app', 'Excellent Topics') ?> &nbsp;
            </h3>
        </div>

        <div class="clearfix site-index-topic">
            <?php if ($topics) {
                foreach ($topics as $key => $vlaue) {
                    echo $this->render('_item', ['model' => $vlaue]);
                }
            } else {
                echo \Yii::t('app', 'Dont have any data Yet');
            } ?>
        </div>

        <div class="panel-footer text-right">
            <span class="index_count"><?= Icon::show('user'); ?><?= \Yii::t('app', 'Online Count') ?>
                ：<?= $statistics['online_count']; ?>
                &nbsp;<?= Icon::show('list'); ?><?= \Yii::t('app', 'Post Count') ?>：<?= $statistics['post_count']; ?>
                &nbsp;<?= Icon::show('share'); ?><?= \Yii::t('app', 'Comment Count') ?>
                ：<?= $statistics['comment_count']; ?></span><?= Html::a(\Yii::t('app', 'More Excellent Topics'), ['topic/default/index', 'sort' => 'excellent']) ?>
        </div>
    </div>

    <div class="panel panel-default list-panel">
        <div class="panel-heading">
            <h3 class="panel-title text-center">社区会员榜</h3>
        </div>

        <div class="panel-body row">
            <?php foreach ($users as $key => $value): ?>
                <div class="col-md-1 col-xs-2">
                    <div class="text-center">
                        <p>
                            <?= Html::a(Html::img($value->userAvatar, ['class' => 'img-responsive img-thumbnail']),
                                ['/user/default/show', 'username' => $value['username']]
                            ); ?>
                        </p>
                        <h5>
                            <?= Html::a($value['username'], ['/user/default/show', 'username' => $value['username']]) ?>
                        </h5>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>

<?= \frontend\widgets\Node::widget() ?>