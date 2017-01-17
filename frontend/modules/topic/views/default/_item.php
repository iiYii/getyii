<?php

use yii\helpers\Html;
use frontend\modules\topic\models\Topic;
use common\helpers\Formatter;

/* @var $this yii\web\View */
/* @var  Topic $model */
?>
<div class="media">

    <div class="media-left">
        <?php //echo Html::a(Html::img($model->user->userAvatar, ['class' => 'media-object img-circle']),
        //            ['/user/default/show', 'username' => $model->user['username']]
        //        ); ?>
        <div class="numbers">
            <div class="like-num">
                <p><?= $model->like_count ?></p>
                <p class="china-intro">点赞</p>
            </div>
            <div class="read-num">
                <p><?= $model->view_count ?></p>
                <p class="china-intro">阅读</p>
            </div>
        </div>
    </div>
    <div class="media-body">
        <div class="media-heading">
            <?= Html::a(Html::encode($model->title),
                ['/topic/default/view', 'id' => $model->id], ['title' => $model->title]
            ); ?>
            <?= ($model->status == Topic::STATUS_EXCELLENT) ? Html::tag('i', '', ['class' => 'fa fa-trophy excellent']) : null ?>
        </div>

        <div class="title-info">
            <?php
            echo Html::a(
                $model->category->name,
                ['/topic/default/index', 'node' => $model->category->alias],
                ['class' => 'node']
            ), ' • ';
            if ($model->last_comment_username) {
                echo Html::tag('span',
                    Yii::t('frontend', 'last_by') .
                    Html::a(
                        ' ' . $model->last_comment_username . ' ',
                        ['/user/default/show', 'username' => $model->last_comment_username]) .
                    Yii::t('frontend', 'reply_at {datetime}', [
                        'datetime' => Formatter::relative($model->last_comment_time)
                    ])
                );
            } else {
                echo Html::a(
                    $model->user['username'],
                    ['/user/default/show', 'username' => $model->user['username']]
                ),
                Html::tag('span',
                    Yii::t('frontend', 'created_at {datetime}', [
                        'datetime' => Formatter::relative($model->created_at)
                    ])
                );
            }
            ?>
        </div>
    </div>
    <div class="media-right">
        <?= Html::a(Html::tag('span', $model['comment_count'], ['class' => 'badge badge-reply-count']),
            ['/topic/default/view', 'id' => $model->id, '#' => 'comment' . $model['comment_count']]
        ); ?>
    </div>

</div>
