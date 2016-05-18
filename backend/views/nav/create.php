<?php

/* @var $this yii\web\View */
/* @var $model common\models\Nav */

$this->title = Yii::t('app', 'Create Nav');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Navs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nav-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
