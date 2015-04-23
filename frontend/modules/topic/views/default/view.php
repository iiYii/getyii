<?php

use yii\helpers\Html;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
/* @var $model common\Models\Post */

$this->title = $model->title;
?>

<div class="col-md-10 topic-view" contenteditable="false" style="">
    <div class="panel panel-default">
        <div class="panel-heading media clearfix">
            <div class="media-body">
                <?= Html::tag('h1', $model->title, ['class' => 'media-heading']); ?>
                <div class="info">
                    <?= Html::a('分享', ['/topic/node', 'id' => $model->post_meta_id]) ?>
                    ·
                    <?= Html::a($model->user['username'], ['/user/default/show', 'username' => $model->user['username']]) ?>
                    ·
                    于 <?= Html::tag('abbr', Yii::$app->formatter->asRelativeTime($model->created_at), ['title' => Yii::$app->formatter->asDatetime($model->created_at)]) ?>发布
                    ·
                    <?= $model->view_count ?> 次阅读
                </div>
            </div>
            <div class="avatar media-right">
                <?php $img = "http://gravatar.com/avatar/" . md5($model->user['email']) . "?s=48"; ?>
                <?= Html::a(Html::img($img, ['class' => 'media-object avatar-48']),
                    ['/user/default/show', 'username' => $model->user['username']]
                ); ?>
            </div>
        </div>
        <div class="panel-body article">
            <?= Markdown::process($model->content, 'gfm') ?>
        </div>
        <div class="panel-footer clearfix opts">
            <?php
                $like = Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-thumbs-o-up']) . ' ' . Html::tag('span', $model->like_count) . ' 个赞',
                    '#',
                    [
                        'data-do' => 'like',
                        'data-id' => $model->id,
                        'data-type' => 'topic',
                        'class' => ($model->like) ? 'active': ''
                    ]
                );
                $hate = Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-thumbs-o-down']) . ' 踩',
                    '#',
                    [
                        'data-do' => 'hate',
                        'data-id' => $model->id,
                        'data-type' => 'topic',
                        'class' => ($model->hate) ? 'active': ''
                    ]
                );
                $follow = Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-eye']) . ' 关注',
                    '#',
                    [
                        'data-do' => 'follow',
                        'data-id' => $model->id,
                        'data-type' => 'topic',
                        'class' => ($model->follow) ? 'active': ''
                    ]
                );
                $thanks = Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-heart-o']) . ' 感谢',
                    '#',
                    [
                        'data-do' => 'thanks',
                        'data-id' => $model->id,
                        'data-type' => 'topic',
                        'class' => ($model->thanks) ? 'active': ''
                    ]
                );
                $favorite = Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-bookmark']) . ' 收藏',
                    '#',
                    [
                        'data-do' => 'favorite',
                        'data-id' => $model->id,
                        'data-type' => 'topic',
                        'class' => ($model->favorite) ? 'active': ''
                    ]
                );
                if($model->isCurrent()){
                    echo Html::a(
                        Html::tag('i', '', ['class' => 'fa fa-thumbs-o-up']) . ' ' . Html::tag('span', $model->like_count) . ' 个赞',
                        'javascript:;'
                    );
                } else {
                    echo $like, $hate;
                    echo $thanks;
                }
                echo $follow;
                echo $favorite;
            ?>
            <?php if ($model->isCurrent()): ?>
                <span class="pull-right">
                    <?= Html::a(
                        Html::tag('i', '', ['class' => 'fa fa-pencil']) . ' 修改',
                        ['/topic/default/update', 'id' => $model->id]
                    ) ?>
                    <?= Html::a(
                        Html::tag('i', '', ['class' => 'fa fa-trash']) . ' 删除',
                        ['/topic/default/delete', 'id' => $model->id],
                        [
                            'data' => [
                                'confirm' => "您确认要删除文章「{$model->title}」吗？",
                                'method' => 'post',
                            ],
                        ]
                    ) ?>
                </span>
            <?php endif ?>

        </div>
    </div>

    <?= $this->render(
        '@frontend/modules/topic/views/comment/index',
        ['model' => $model, 'dataProvider' => $dataProvider]
    ) ?>

    <?= $this->render(
        '@frontend/modules/topic/views/comment/create',
        ['model' => $comment, 'post' => $model]
    ) ?>

</div>
<?= \frontend\widgets\TopicSidebar::widget(); ?>