<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CourseTerms */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Course Terms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-terms-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'created_at',
            'updated_at',
            'excerpt',
            'parent_id',
            'count',
            'order',
        ],
    ]) ?>

</div>
