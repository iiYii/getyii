<?php

/* @var $this yii\web\View */
/* @var $model common\models\RightLink */

$this->title = 'Create Right Link';
$this->params['breadcrumbs'][] = ['label' => 'Right Links', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="right-link-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>