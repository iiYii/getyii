<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ManualContent */

$this->title = 'Create Manual Content';
$this->params['breadcrumbs'][] = ['label' => 'Manual Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manual-content-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
