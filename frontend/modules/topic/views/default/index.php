<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use frontend\widgets\TopicSidebar;

$this->title = '社区';
$sort = Yii::$app->request->getQueryParam('sort');
if ($node = Yii::$app->request->getQueryParam('node')) {
    $node = \common\models\PostMeta::find()->where(['alias' => $node])->one();
}
/** @var array $sorts */
/** @var \common\models\PostMeta $node */
/** @var \common\models\PostMeta[] $nodes */
/** @var \yii\data\ActiveDataProvider $dataProvider */
?>
<div class="col-md-9 topic">
    <div class="panel panel-default">
        <div class="panel-heading clearfix tab">
            <?php if (request('node')): ?>
                <div class="node-header">
                    <div class="title">
                        <?= $node->name ?>
                        <span class="total">共有 <?= $dataProvider->getTotalCount() ?> 个讨论主题</span>
                    </div>
                    <div class="summary" id="node-summary">
                        <p><?= $node->description ?></p>
                    </div>
                </div>
            <?php else: ?>
                <span><?= Html::a('全部', ['/topic/default/index'], ['class' => request('tab') ? null : 'active']) ?></span>
                <?php foreach ((array)$nodes as $key => $value): ?>
                    <span><?= Html::a($value->name, ['/topic/default/index', 'tab' => $value->alias], ['class' => request('tab') == $value->alias ? 'active' : null]) ?></span>
                <?php endforeach ?>
            <?php endif ?>
        </div>
        <div class="panel-heading clearfix children">
            <div class="filter pull-right">
                <span class="l">排序:</span>
                <?php foreach ($sorts as $key => $name): ?>
                    <?= Html::a($name, Url::current(['sort' => $key]), ['class' => ($sort == $key || ((empty($sort) && $key == 'newest'))) ? 'active' : '']) ?> \
                <?php endforeach ?>
            </div>

            <?php if (request('tag')) {
                echo Html::tag('div', '搜索标签：' . htmlspecialchars(request('tag')), ['class' => 'pull-left']);
            } elseif (request('keyword')) {
                echo Html::tag('div', '搜索：' . htmlspecialchars(request('keyword')), ['class' => 'pull-left']);
            } elseif (request('tab')) {
                /** @var \common\models\PostMeta $node */
                if ($node = \yii\helpers\ArrayHelper::getValue($nodes, request('tab'))) {
                    foreach ($node->children as $item) {
                        $active = request('node') == $item->alias ? 'active' : null;
                        echo Html::a($item->name, ['/topic/default/index', 'node' => $item->alias], ['class' => "children-node " . $active]);
                    }
                }
            } ?>

        </div>


        <?php Pjax::begin([
            'scrollTo' => 0,
            'formSelector' => false,
            'linkSelector' => '.pagination a'
        ]); ?>
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

