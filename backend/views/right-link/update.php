<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rightlink */

$this->title = 'Update Rightlink: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Rightlinks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->rlid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rightlink-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
