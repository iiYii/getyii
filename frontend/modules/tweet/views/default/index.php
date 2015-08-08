<?php
$this->title = '发布新动弹';
?>
    <div class="col-md-10 tweet" contenteditable="false" style="">

        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <?= $this->title ?>
                <span class="pull-right fade-info" id="remaining">500</span>
            </div>

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
        <?= \yii\widgets\ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_item',
            'itemOptions' => ['class' => 'list-group-item item'],
            'summary' => false,
//            'options' => ['class' => ''],
            'pager' => [
                'class' => \kop\y2sp\ScrollPager::className(),
                'triggerOffset' => 5
            ]
        ]); ?>
    </div>

<?= \frontend\widgets\TopicSidebar::widget([
    'type' => 'create'
]) ?>