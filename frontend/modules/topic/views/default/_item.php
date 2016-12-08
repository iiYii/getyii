<?php

use yii\helpers\Html;
use frontend\modules\topic\models\Topic;
use common\helpers\Formatter;

/* @var $this yii\web\View */
?>
<div class="media">
    <?php if($model['comment_count']==0){ $class="badge badge-reply-count" ;}else{$class="badge badge-reply-count-new"; } ?>
    <?= Html::a(Html::tag('span', $model['comment_count'],['class' => $class ]),
        ['/topic/default/view', 'id' => $model->id, '#' => 'comment' . $model['comment_count']], ['class' => 'pull-right']
    ); ?>

    <div class="media-left">
        <?= Html::a(Html::img($model->user->userAvatar, ['class' => 'media-object']),
            ['/user/default/show', 'username' => $model->user['username']]
        ); ?>
    </div>
    <div class="media-body">

        <div class="media-heading <?= ($model->recommend == Topic::RECOMMEND_ACTIVE) ?  "recommend" : null ?> ">
            <?= ($model->top == Topic::TOP_ACTIVE) ? Html::tag('span', '置顶', ['class' => 'badge badge-top']) : null ?>
            <?= ($model->recommend == Topic::RECOMMEND_ACTIVE) ? Html::tag('span', '推荐', ['class' => 'badge badge-recommend']) : null ?>
            <?= ($model->status == Topic::STATUS_EXCELLENT) ? Html::tag('span', '精华', ['class' => 'badge badge-excellent']) : null ?>
            <?= Html::a(Html::encode($model->title),
                ['/topic/default/view', 'id' => $model->id], ['title' => $model->title]
            ); ?>

        </div>

        <div class="title-info">
            <?php
            if ($model->like_count) {
                echo Html::a(Html::tag('span', ' ' . $model->like_count . ' ', ['class' => 'fa fa-thumbs-o-up']),
                    ['/topic/default/view', 'id' => $model->id], ['class' => 'remove-padding-left']
                ), ' • ';
            }
            echo Html::a(
                $model->category->name,
                ['/topic/default/index', 'node' => $model->category->alias],
                ['class' => 'node']
            ), ' • ',
            Html::a(
                $model->user['username'],
                ['/user/default/show', 'username' => $model->user['username']]
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
                echo Html::tag('span',
                    Yii::t('frontend', 'created_at {datetime}', [
                        'datetime' => Formatter::relative($model->created_at)
                    ])
                );
            }
            ?>
        </div>
    </div>
</div>
