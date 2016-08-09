<?php

/* @var $this yii\web\View */
/* @var $model common\models\RightLink */

$this->title = 'Update Right Link: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Right Links', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="right-link-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>