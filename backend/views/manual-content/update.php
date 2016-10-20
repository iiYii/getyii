<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ManualContent */

$this->title = 'Update Manual Content: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Manual Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="manual-content-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
