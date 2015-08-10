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
        <div class="fade-info">
            <?= Html::a(
                $model->user['username'],
                ['/user/default/show', 'username' => $model->user['username']]
            ), '•',
            Html::tag('span', \common\helpers\Formatter::relative($model->updated_at));
            ?>
        </div>

        <div class="media-heading">
            <?= \yii\helpers\HtmlPurifier::process(\yii\helpers\Markdown::process($model->content, 'gfm')) ?>
        </div>

        <div class="title-info pull-right">
            <?php if ($model->isCurrent()) {
                echo Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-thumbs-o-up']) . ' ' . Html::tag('span', $model->like_count . ' '),
                    'javascript:;'
                );
                if ($model->comment_count == 0) {
                    echo Html::a(
                        Html::tag('i', '', ['class' => 'fa fa-trash']) . ' 删除',
                        ['/tweet/default/delete', 'id' => $model->id],
                        [
                            'data' => [
                                'confirm' => "您确认要删除吗？",
                                'method' => 'post',
                            ],
                        ]
                    );
                }
            } else {
                echo Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-thumbs-o-up']) . ' ' . Html::tag('span', $model->like_count . ' '),
                    '#',
                    [
                        'data-do' => 'like',
                        'data-id' => $model->id,
                        'data-type' => $model->type,
                        'class' => ($model->like) ? 'active' : ''
                    ]
                );
            } ?>

        </div>
    </div>
</div>
