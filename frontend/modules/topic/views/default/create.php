<?php

/* @var $this yii\web\View */
/* @var $model common\Models\Post */

$this->title = '发布新话题';
// $this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-9 topic-create" contenteditable="false" style="">

    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <?= $this->title ?>
        </div>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>

<?= \frontend\widgets\TopicSidebar::widget([
    'type' => 'create'
])?>