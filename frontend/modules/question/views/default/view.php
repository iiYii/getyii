<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
/* @var $model common\Models\Post */

$this->title = $model->title;

\frontend\assets\AtJsAsset::register($this);

$node = \common\models\PostMeta::find()->where(['alias' => $model->category->alias])->one();

?>

<div class="col-md-9 question-view" contenteditable="false" style="">
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
                    于 <?= Html::tag('abbr', Yii::$app->formatter->asRelativeTime($model->created_at), ['title' => Yii::$app->formatter->asDatetime($model->created_at)]) ?>发布
                    ·
                    <?= $model->view_count ?> 次阅读
                </div>
            </div>
            <div class="avatar media-right">
                <?= Html::a(Html::img($model->user->userAvatar, ['class' => 'media-object avatar-48']),
                    ['/user/default/show', 'username' => $model->user['username']]
                ); ?>
            </div>
        </div>
        <div class="panel-body content-body">

            <?= HtmlPurifier::process(Markdown::process($model->content, 'gfm')) ?>

        </div>
        <div class="panel-footer clearfix opts">
            <?php

                $follow = Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-eye']) . ' 关注',
                    '#',
                    [
                        'data-do' => 'follow',
                        'data-id' => $model->id,
                        'data-type' => $model->type,
                        'class' => ($model->follow) ? 'active': ''
                    ]
                );

                $favorite = Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-star']) . ' 收藏',
                    '#',
                    [
                        'data-do' => 'favorite',
                        'data-id' => $model->id,
                        'data-type' => $model->type,
                        'class' => ($model->favorite) ? 'active': ''
                    ]
                );

                echo $follow;
                echo $favorite;

            ?>
            <?php if ($model->isCurrent() || \common\models\User::getThrones()): ?>
                <span class="pull-right">
                    <?= Html::a(
                        Html::tag('i', '', ['class' => 'fa fa-pencil']) . ' 修改',
                        ['/question/default/update', 'id' => $model->id]
                    ) ?>
              <?php if($model->comment_count == 0): ?>
                    <?= Html::a(
                        Html::tag('i', '', ['class' => 'fa fa-trash']) . ' 删除',
                        ['/question/default/delete', 'id' => $model->id],
                        [
                            'data' => [
                                'confirm' => "您确认要删除问题「{$model->title}」吗？",
                                'method' => 'post',
                            ],
                        ]
                    ) ?>
                    <?php endif?>
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
<?= \frontend\widgets\QuestionSidebar::widget([
    'type' => 'view',
    'node' => $model->category,
    'tags' => $model->tags
]); ?>

