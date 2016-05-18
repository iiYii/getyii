<?php

/* @var $this yii\web\View */
/* @var $model common\models\PostMeta */

$this->title = 'Update Post Meta: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Post Metas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="post-meta-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
