<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CourseTerms */

$this->title = 'Update Course Terms: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Course Terms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="course-terms-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
