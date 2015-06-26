<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Nav */

$this->title = Yii::t('app', 'Create Nav');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Navs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nav-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
