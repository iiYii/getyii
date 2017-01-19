<?php

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use frontend\widgets\TopicSidebar;

$this->title = '社区';
$sort = Yii::$app->request->getQueryParam('sort');
if ($node = Yii::$app->request->getQueryParam('node')) {
    $node = \common\models\PostMeta::find()->where(['alias' => $node])->one();
}
/** @var  array $sorts */
?>
<div class="col-md-9 topic">
    <div class="panel panel-default">
        <?php if ($node): ?>
            <div class="panel-heading clearfix">
                <?= FA::i('cloud-upload') ?> <?= $node->name; ?>
                <?php if (!empty($node->description)): ?>
                    <br/>
                    <span style="color: #666666; font-size: 12px;"><?= $node->description; ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="panel-heading clearfix">
            <?php if (request('tag')): ?>
                <div class="pull-left">搜索标签：<?= request('tag'); ?></div>
            <?php endif; ?>
            <?php if (request('keyword')): ?>
                <div class="pull-left">搜索：<?= request('keyword'); ?></div>
            <?php endif; ?>

            <div class="filter pull-right">
                <span class="l">排序:</span>
                <?php foreach ($sorts as $key => $name): ?>
                    <?= Html::a($name, \yii\helpers\Url::current(['sort' => $key]), ['class' => ($sort == $key || ((empty($sort) && $key == 'newest'))) ? 'active' : '']) ?> \
                <?php endforeach ?>
            </div>

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

