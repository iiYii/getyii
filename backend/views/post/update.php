<?php

/* @var $this yii\web\View */
/* @var $model common\Models\Post */

$this->title = 'Update Post: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="post-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
