<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\Models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'title',
            [
                'attribute' => 'category_name',
                'filter' => Html::activeTextInput($searchModel, 'category_name', ['class' => 'form-control']),
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->category['name'];
                },
            ],
            [
                'attribute' => 'username',
                'filter' => Html::activeTextInput($searchModel, 'username', ['class' => 'form-control']),
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->user['username'];
                },
            ],
            // 'excerpt',
            // 'image',
            // 'content:ntext',
//             'tags',
            // 'view_count',
            // 'comment_count',
             'favorite_count',
             'like_count',
             'hate_count',
             'status',
//             'order',
            // 'created_at',
             'updated_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
