<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/20 下午9:15
 * description:
 */

use yii\helpers\Html;

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Post Comment',
    ]) . ' ' . $model->post->title;
?>

<div class="col-md-9 topic-create" contenteditable="false" style="">

    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <?= Html::encode($this->title) ?>
        </div>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>

<?= \frontend\widgets\TopicSidebar::widget([

])?>