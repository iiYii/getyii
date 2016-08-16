<?php

/* @var $this yii\web\View */
/* @var $model common\models\NavUrl */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Nav Url',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Nav Urls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="nav-url-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
