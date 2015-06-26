<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\NavUrl */

$this->title = Yii::t('app', 'Create Nav Url');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Nav Urls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nav-url-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
