<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use frontend\widgets\TopicSidebar;

$this->title = '社区';
$sort = Yii::$app->request->getQueryParam('sort');
?>
<div class="col-md-10 topic">
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <div class="filter pull-right">
                <span class="l">查看:</span>
                <?php foreach($sorts as $key => $name): ?>
                    <?= Html::a($name, \yii\helpers\Url::current(['sort' => $key]),['class' => ($sort == $key || ((empty($sort) && $key == 'newest')))?'active':'']) ?> \
                <?php endforeach ?>
            </div>

        </div>

        <?php Pjax::begin(); ?>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'list-group-item'],
            'summary' => false,
            'itemView' => '_item',
            'options' => ['class' => 'list-group'],
        ]) ?>
        <?php Pjax::end(); ?>

    </div>
</div>
<?= TopicSidebar::widget(); ?>