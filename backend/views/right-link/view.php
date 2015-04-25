<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Rightlink */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Rightlinks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rightlink-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->rlid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->rlid], [
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
            'rlid',
            'title',
            'url:url',
            'image',
            'content',
            'class',
            'created_user',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
