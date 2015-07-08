<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
?>
<div class="media">
    <?= Html::a(Html::tag('span', $model['comment_count'], ['class' => 'badge badge-reply-count']),
        ['/topic/default/view', 'id' => $model->id, '#' => 'comment' . $model['comment_count']], ['class' => 'pull-right']
    ); ?>

    <div class="media-left">
        <?= Html::a(Html::img($model->user->userAvatar, ['class' => 'media-object img-circle']),
            ['/user/default/show', 'username' => $model->user['username']]
        ); ?>
    </div>
    <div class="media-body">

        <div class="media-heading">
            <?= Html::a(Html::encode($model->title),
                ['/topic/default/view', 'id' => $model->id], ['title' => $model->title]
            ); ?>
            <?= ($model->status == 2) ? Html::tag('i', '', ['class' => 'fa fa-trophy excellent']) : null ?>
        </div>

        <div class="title-info">
            <?php
            if ($model->like_count) {
                echo Html::a(Html::tag('span', ' ' . $model->like_count . ' ', ['class' => 'fa fa-thumbs-o-up']),
                    ['/topic/default/view', 'id' => $model->id], ['class' => 'remove-padding-left']
                ), '';
            }
 
            echo Html::a(
                $model->category->name,
                ['/topic/default/index', 'node' => $model->category->alias],
                ['class' => 'node']
            ), '<i class="fa fa-user"></i>',
            Html::a(
                $model->user['username'],
                ['/user/default/show', 'username' => $model->user['username']]
<<<<<<< HEAD
            ), '<i class="fa fa-calendar"></i>',
            Html::tag('span', Yii::$app->formatter->asRelativeTime($model->created_at));
=======
            ), '•',
            Html::tag('span', Yii::$app->formatter->asRelativeTime($model->updated_at));
>>>>>>> ormm/master
            ?>
        </div>
    </div>
</div>
