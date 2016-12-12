<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use frontend\widgets\PostTypeTab;
use frontend\widgets\ArticleSidebar;

use kartik\icons\Icon;

Icon::map($this);


$node = Yii::$app->request->getQueryParam('node');
$tag = Yii::$app->request->getQueryParam('tag');
$sort = Yii::$app->request->getQueryParam('sort');
if ($node) {
    $node = \common\models\PostMeta::find()->where(['alias' => $node])->one();
    $seo_title = $node->name.' 文章教程';
}
else if($tag){
    $seo_title = $tag.' 文章标签';
}
else{
    $seo_title = "文章教程";
}
$this->title = $seo_title;

?>
<div class="col-md-9 article-list">
    <div class="panel panel-default">

        <?php if($node and !empty($node->description)): ?>
            <div class="panel-heading media clearfix">
                <h1><?= Icon::show('cloud-upload') ?> <?= $node->name; ?></h1>
                <br/>
                <span style="color: #666; line-height: 20px;"><?= $node->description; ?></span>
            </div>
        <?php endif; ?>

        <?php if($node): ?>
            <?= PostTypeTab::widget(['node' => $node]); ?>
        <?php endif; ?>

        <div class="panel-heading clearfix">
            <?php if ($tag): ?>
                <div class="pull-left">搜索标签：<?= $tag; ?>
                </div>
            <?php endif; ?>

            <div class="filter pull-right">
                <span class="l">查看:</span>
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
<?= ArticleSidebar::widget([
    'node' => $node
]); ?>

