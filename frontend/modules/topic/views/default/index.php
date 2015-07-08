<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use frontend\widgets\TopicSidebar;

use kartik\icons\Icon;

Icon::map($this);

$this->title = '社区';
$sort = Yii::$app->request->getQueryParam('sort');
$tag = Yii::$app->request->getQueryParam('tag');
if ($node = Yii::$app->request->getQueryParam('node')) {
    $node = \common\models\PostMeta::find()->where(['alias' => $node])->one();
}
?>

<!--topic list start-->
<div class="col-md-9 topic">
    <div class="panel panel-default">
<<<<<<< HEAD
        <!--标题 start-->
        <div class="panel-heading clearfix">
            <h4>
            <?php if($tag): ?>
=======
        <?php if($node): ?>
        <div class="panel-heading clearfix">
            <?= Icon::show('cloud-upload') ?> <?= $node->name; ?>
            <?php if(!empty($node->description)): ?>
                <br/>
                <span style="color: #666666; font-size: 12px;"><?= $node->description; ?></span>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <div class="panel-heading clearfix">
            <?php if ($tag): ?>
>>>>>>> ormm/master
                <div class="pull-left">搜索标签：<?= $tag; ?>
                </div>
            <?php endif; ?>

<<<<<<< HEAD
            <div class="">
                <span class="">查看:</span>
                <?php foreach($sorts as $key => $name): ?>
                    <?= Html::a($name, \yii\helpers\Url::current(['sort' => $key]),['class' => ($sort == $key || ((empty($sort) && $key == 'newest')))?'active':'']) ?> *
=======
            <div class="filter pull-right">
                <span class="l">查看:</span>
                <?php foreach ($sorts as $key => $name): ?>
                    <?= Html::a($name, \yii\helpers\Url::current(['sort' => $key]), ['class' => ($sort == $key || ((empty($sort) && $key == 'newest'))) ? 'active' : '']) ?> \
>>>>>>> ormm/master
                <?php endforeach ?>
            </div>
            </h4>
        </div>
<<<<<<< HEAD
           <!--标题end-->
               <div class="panel-body">
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
=======

        <?php Pjax::begin(['scrollTo' => 0]); ?>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'list-group-item'],
            'summary' => false,
            'itemView' => '_item',
            'options' => ['class' => 'list-group'],
        ]) ?>
        <?php Pjax::end(); ?>

>>>>>>> ormm/master
    </div>
    <?= \frontend\widgets\Node::widget(); ?>
</div>
<!--topic list end-->

<?= TopicSidebar::widget([
    'node' => $node
]); ?>

