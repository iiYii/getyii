<?php

/* @var $this yii\web\View */
/* @var $model common\models\PostMeta */

$this->title = 'Create Post Meta';
$this->params['breadcrumbs'][] = ['label' => 'Post Metas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-meta-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
