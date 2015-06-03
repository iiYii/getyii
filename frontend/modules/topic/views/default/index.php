<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use frontend\widgets\TopicSidebar;

$this->title = '社区';
$sort = Yii::$app->request->getQueryParam('sort');
$tag = Yii::$app->request->getQueryParam('tag');
if ($node = Yii::$app->request->getQueryParam('node')){
    $node = \common\models\PostMeta::find()->where(['alias' => $node])->one();
}
?>
<div class="col-md-10 topic">
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <?php if($tag): ?>
                <div class="pull-left">搜索标签：<?= $tag; ?>
                </div>
            <?php endif; ?>

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
    <?= \frontend\widgets\Node::widget(); ?>
</div>
<?= TopicSidebar::widget([
    'node' => $node
]); ?>

