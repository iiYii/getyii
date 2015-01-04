<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="blog" class="container">
    <div class="post-index">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'post_meta_id',
                'user_id',
                'title',
                'author',
                // 'excerpt',
                // 'image',
                // 'content:ntext',
                // 'tags',
                // 'view_count',
                // 'comment_count',
                // 'favorite_count',
                // 'like_count',
                // 'hate_count',
                // 'status',
                // 'order',
                // 'created_at',
                // 'updated_at',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    </div>
</section>