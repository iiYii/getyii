<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\RightLink */

$this->title = 'Create Right Link';
$this->params['breadcrumbs'][] = ['label' => 'Right Links', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="right-link-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>