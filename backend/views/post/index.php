<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Post;

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
            [
                'attribute' => 'id',
                'options' => ['width' => '10px'],
            ],
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
                'value' => function ($data) {
                    return $data->user['username'];
                },
            ],
//             'tags',
            [
                'attribute' => 'view_count',
                'options' => ['width' => '10px'],
            ],
            [
                'attribute' => 'comment_count',
                'options' => ['width' => '10px'],
            ],
//            [
//                'attribute' => 'favorite_count',
//                'options' => ['width' => '10px'],
//            ],
//            [
//                'attribute' => 'like_count',
//                'options' => ['width' => '10px'],
//            ],
//            [
//                'attribute' => 'hate_count',
//                'options' => ['width' => '10px'],
//            ],
            [
                'attribute' => 'order',
                'options' => ['width' => '10px'],
            ],
            [
                'class' => \common\grid\EnumColumn::className(),
                'attribute' => 'status',
                'filter' => Post::getStatuses(),
                'enum' => Post::getStatuses(),
            ],
            'updated_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
