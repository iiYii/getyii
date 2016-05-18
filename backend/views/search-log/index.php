<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SearchLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Search Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="search-log-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'username',
                'filter' => Html::activeTextInput($searchModel, 'username', ['class' => 'form-control']),
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->user['username'];
                },
            ],
            'keyword',
            'created_at:datetime',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{delete}'],
        ],
    ]); ?>

</div>
