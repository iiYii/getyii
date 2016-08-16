<?php
$this->title = '发布新动弹';
/** @var \frontend\modules\tweet\models\Tweet $model*/
/** @var \yii\data\ActiveDataProvider $dataProvider*/
?>
    <div class="col-md-9 tweet" contenteditable="false" style="">

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
                'eventOnRendered' => "function() {
                    emojify.run();
                    $('pre code').each(function (i, block) {
                        hljs.highlightBlock(block);
                    });
                }",
                'triggerOffset' => 5
            ]
        ]); ?>
    </div>

<?= \frontend\widgets\TopicSidebar::widget([
    'type' => 'create'
]) ?>
