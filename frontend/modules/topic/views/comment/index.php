<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/20 下午9:16
 * description:
 */
?>
<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <?= \Yii::t('app', 'Received {0} reply', $model->comment_count) ?>
    </div>

    <?= \yii\widgets\ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'list-group-item media mt0'],
        'summary' => false,
        'itemView' => '_item',
    ]) ?>
</div>