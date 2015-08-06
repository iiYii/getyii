<?php
$this->title = '发布新动弹';
?>
    <div class="col-md-10 topic-create" contenteditable="false" style="">

        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <?= $this->title ?>
            </div>

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
        <?= \yii\widgets\ListView::widget([
            'dataProvider' => $dataProvider,
            'id' => 'my-listview-id',
            'layout' => "<div class=\"items\">{items}</div>\n{pager}",
            'itemView' => '_item',
            'itemOptions' => ['class' => 'list-group-item'],
            'summary' => false,
            'options' => ['class' => 'list-group'],
            'pager' => [
                'class' => \nirvana\infinitescroll\InfiniteScrollPager::className(),
                'widgetId' => 'my-listview-id',
                'itemsCssClass' => 'items',
                'contentLoadedCallback' => 'afterAjaxListViewUpdate',
                'nextPageLabel' => 'Load more items',
                'linkOptions' => [
                    'class' => 'btn btn-lg btn-block',
                ],
                'pluginOptions' => [
                    'loading' => [
                        'msgText' => "<em>Loading next set of items...</em>",
                        'finishedMsg' => "<em>No more items to load</em>",
                    ],
                    'behavior' => \nirvana\infinitescroll\InfiniteScrollPager::BEHAVIOR_TWITTER,
                ],
            ],
        ]);
        ?>
    </div>

<?= \frontend\widgets\TopicSidebar::widget([
    'type' => 'create'
]) ?>