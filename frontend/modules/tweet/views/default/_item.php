<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
?>
<div class="media">

    <div class="media-left">
        <?= Html::a(Html::img($model->user->userAvatar, ['class' => 'media-object']),
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
            <?= Html::encode($model->content);
            Html::tag('span', Yii::$app->formatter->asRelativeTime($model->updated_at));
            ?>
        </div>
    </div>
</div>
