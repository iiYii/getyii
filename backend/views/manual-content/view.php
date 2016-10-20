<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\markdown\Markdown;

/* @var $this yii\web\View */
/* @var $model common\models\ManualContent */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Manual Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manual-content-view">

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
            'parent_id',
            'manual_id',
            'title',
             ['label'=>'内容','value'=>Markdown::convert($model->content)],
            'name',
            'link',
            'sort_order',
            'view_count',
            'status',
            'create_time',
            'update_time',
        ],
    ]) ?>

</div>
