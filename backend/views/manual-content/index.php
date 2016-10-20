<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ManualContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manual Contents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manual-content-index">


    <p>
        <?= Html::a('Create Manual Content', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'parent_id',
            'title',
            'name',
            'sort_order',
            'view_count',
            'status',
            'create_time',
            'update_time',
            'manual_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
