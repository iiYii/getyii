<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Rightlink */

$this->title = 'Create Rightlink';
$this->params['breadcrumbs'][] = ['label' => 'Rightlinks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rightlink-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
