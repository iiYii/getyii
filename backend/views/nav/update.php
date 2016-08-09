<?php

/* @var $this yii\web\View */
/* @var $model common\models\Nav */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Nav',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Navs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="nav-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
