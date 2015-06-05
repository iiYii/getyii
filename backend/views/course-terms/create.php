<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CourseTerms */

$this->title = 'Create Course Terms';
$this->params['breadcrumbs'][] = ['label' => 'Course Terms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-terms-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
