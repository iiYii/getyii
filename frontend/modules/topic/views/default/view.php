<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
/* @var $model common\Models\Post */
/* @var $donate array|\frontend\modules\user\models\Donate */

$this->title = $model->title;

?>

    <div class="col-md-9 topic-view" contenteditable="false" style="">
        <div class="panel panel-default">
            <div class="panel-heading media clearfix">
                <div class="media-body">
                    <?= Html::tag('h1', Html::encode($model->title), ['class' => 'media-heading']); ?>
                    <div class="info">
                        <?= Html::a(
                            $model->category->name,
                            ['/topic/default/index', 'node' => $model->category->alias],
                            ['class' => 'node']
                        ) ?>
                        ·
                        <?= Html::a($model->user['username'], ['/user/default/show', 'username' => $model->user['username']]) ?>
                        ·
                        于 <?= Html::tag('abbr', Yii::$app->formatter->asRelativeTime($model->created_at), ['title' => Yii::$app->formatter->asDatetime($model->created_at)]) ?>
                        发布
                        ·
                        <?= $model->view_count ?> 次阅读
                    </div>
                </div>
                <div class="avatar media-right">
                    <?= Html::a(Html::img($model->user->userAvatar, ['class' => 'media-object avatar-48 img-circle']),
                        ['/user/default/show', 'username' => $model->user['username']]
                    ); ?>
                </div>
            </div>
            <div class="panel-body article">
                <?= HtmlPurifier::process(Markdown::process($model->content, 'gfm')) ?>

                <?php if ($donate): ?>
                    <hr/>
                    <div style="text-align: center; color: #666;">
                        <?= Html::button('打赏作者', ['class' => 'btn btn-danger', 'id' => 'donate-btn']) ?>
                        <p></p>
                        <p><?= $donate->description ?></p>
                        <div class="row" id="donate-qr-code">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="panel panel-default corner-radius mt15">
                                    <div class="panel-body donate">
                                        <?= Html::img(params('qrCodeUrl') . '/' . $donate->qr_code, ['class' => 'img']) ?>
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                        </div>
                    </div>
                <?php endif ?>

                <?php if ($model->status == 2): ?>
                    <div class="ribbon-excellent">
                        <i class="fa fa-trophy excellent"></i> 本帖已被设为精华帖！
                    </div>
                <?php endif ?>
            </div>
            <div class="panel-footer clearfix opts">
                <?php
                $like = Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-thumbs-o-up']) . ' ' . Html::tag('span', $model->like_count) . ' 个赞',
                    '#',
                    [
                        'data-do' => 'like',
                        'data-id' => $model->id,
                        'data-type' => $model->type,
                        'class' => ($model->like) ? 'active' : ''
                    ]
                );
                $hate = Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-thumbs-o-down']) . ' 踩',
                    '#',
                    [
                        'data-do' => 'hate',
                        'data-id' => $model->id,
                        'data-type' => $model->type,
                        'class' => ($model->hate) ? 'active' : ''
                    ]
                );
                $follow = Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-eye']) . ' 关注',
                    '#',
                    [
                        'data-do' => 'follow',
                        'data-id' => $model->id,
                        'data-type' => $model->type,
                        'class' => ($model->follow) ? 'active' : ''
                    ]
                );
                $thanks = Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-heart-o']) . ' 感谢',
                    '#',
                    [
                        'data-do' => 'thanks',
                        'data-id' => $model->id,
                        'data-type' => $model->type,
                        'class' => ($model->thanks) ? 'active' : ''
                    ]
                );
                $favorite = Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-bookmark']) . ' 收藏',
                    '#',
                    [
                        'data-do' => 'favorite',
                        'data-id' => $model->id,
                        'data-type' => $model->type,
                        'class' => ($model->favorite) ? 'active' : ''
                    ]
                );

                if ($model->isCurrent()) {
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

                if ($admin) {
                    $class = $model->status == 2 ? ['class' => 'active'] : null;
                    echo Html::a(
                        Html::tag('i', '', ['class' => 'fa fa-trophy']) . ' 加精',
                        ['/topic/default/excellent', 'id' => $model->id],
                        $class
                    );
                }
                ?>
                <?php if ($model->isCurrent() || \common\models\User::getThrones()): ?>
                    <span class="pull-right">
                    <?= Html::a(
                        Html::tag('i', '', ['class' => 'fa fa-pencil']) . ' 修改',
                        ['/topic/default/update', 'id' => $model->id]
                    ) ?>
                    <?php if ($model->comment_count == 0): ?>
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
                    <?php endif ?>
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
<?= \frontend\widgets\TopicSidebar::widget([
    'type' => 'view',
    'node' => $model->category,
    'tags' => $model->tags
]); ?>