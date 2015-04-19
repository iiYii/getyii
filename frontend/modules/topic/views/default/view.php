<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\helpers\Markdown;
use yii\bootstrap\Nav;

/* @var $this yii\web\View */
/* @var $model common\Models\Post */

$this->title = $model->title;
// $this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-10 topic-view" contenteditable="false" style="">
    <div class="panel panel-default">
        <div class="panel-heading media clearfix">
            <div class="media-body">
                <?= Html::tag('h1', $model->title, ['class' => 'media-heading']); ?>
                <div class="info">
                    <?= Html::a('分享', ['/topic/node', 'id' => $model->post_meta_id]) ?>
                    ·
                    <?= Html::a($model->user['username'], ['/people', 'id' => $model->user['username']]) ?>
                    ·
                    于 <?= Html::tag('abbr', Yii::$app->formatter->asRelativeTime($model->created_at)) ?>发布
                    ·
                    最后由 <a data-name="lgn21st" href="/lgn21st">lgn21st</a> 于 <abbr class="timeago" title="2015-04-16T08:58:42+08:00">2 天前</abbr>回复
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
                echo Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-thumbs-o-up']) . ' ' . Html::tag('span', $model->like_count) . ' 个赞',
                    '#',
                    [
                        'data-do' => 'like',
                        'data-id' => $model->id,
                        'data-type' => 'topic',
                        'class' => ($model->like) ? 'active': ''
                    ]
                );
                echo Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-thumbs-o-down']) . ' 喝倒彩',
                    '#',
                    [
                        'data-do' => 'hate',
                        'data-id' => $model->id,
                        'data-type' => 'topic',
                        'class' => ($model->like) ? 'active': ''
                    ]
                );
                echo Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-eye']) . ' 关注',
                    '#',
                    [
                        'data-do' => 'follow',
                        'data-id' => $model->id,
                        'data-type' => 'topic',
                        'class' => ($model->like) ? 'active': ''
                    ]
                );
                echo Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-heart-o']) . ' 感谢',
                    '#',
                    [
                        'data-do' => 'thanks',
                        'data-id' => $model->id,
                        'data-type' => 'topic',
                        'class' => ($model->like) ? 'active': ''
                    ]
                );
                echo Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-bookmark']) . ' 收藏',
                    '#',
                    [
                        'data-do' => 'favorite',
                        'data-id' => $model->id,
                        'data-type' => 'topic',
                        'class' => ($model->like) ? 'active': ''
                    ]
                );
            ?>
            <?php if ($model->isCurrent()): ?>
                <span class="pull-right">
                    <?= Html::a(
                        Html::tag('i', '', ['class' => 'fa fa-pencil']) . ' 修改',
                        ['/topic/update', 'id' => $model->id]
                    ) ?>
                    <?= Html::a(
                        Html::tag('i', '', ['class' => 'fa fa-trash']) . ' 删除',
                        ['/topic/delete', 'id' => $model->id],
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

    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <?= Yii::t('app', 'Received {0} reply', $model->comment_count) ?>
        </div>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'list-group-item media'],
            'summary' => false,
            'itemView' => '_comment',
        ]) ?>
    </div>

    <?= $this->render('_commentView', ['model' => $comment, 'dataProvider' => $dataProvider]) ?>

</div>
<?= \frontend\widgets\TopicSidebar::widget(); ?>