<?php
/**
 * @Author: forecho
 * @Date:   2015-01-29 23:26:54
 * @Last Modified by:   forecho
 * @Last Modified time: 2015-02-04 21:53:45
 */

use yii\helpers\Html;
use yii\helpers\Markdown;
?>

<?php if ($this->context->action->id == 'show'): ?>
    <!-- 评论 -->
    <?= Html::a(
        $model->post->title,
        ["/{$model->post->type}/default/view", 'id' => $model->post->id],
        ['class' => 'list-group-item-heading']
    )?>
    <?=  Html::tag('em',Yii::$app->formatter->asRelativeTime($model->created_at)) ?>
    <p><?= Markdown::process($model->comment, 'gfm') ?></p>
<?php else: ?>
    <?php if ($this->context->action->id == 'favorite'): ?>
        <!--收藏-->
        <i class="fa fa-bookmark red"></i>
        <?= Html::a(
            $model->topic->title,
            ["/{$model->topic->type}/default/view", 'id' => $model->topic->id],
            ['class' => 'list-group-item-heading']
        )?>
        <?=  Html::tag('em',Yii::$app->formatter->asRelativeTime($model->topic->created_at)) ?>
        <p class="list-group-item-text title-info">
            <?= Html::a($model->topic->category->name, ["/{$model->topic->type}/default/index", 'node' => $model->topic->category->alias])?> •
            <span>
                <?= $model->topic->like_count ?> 个赞 • <?= $model->topic->comment_count ?> 条回复
            </span>
        </p>
    <?php else: ?>
        <!-- 文章 -->
        <?= Html::a(
            $model->title,
            ["/{$model->type}/default/view", 'id' => $model->id],
            ['class' => 'list-group-item-heading']
        )?>
        <?=  Html::tag('em',Yii::$app->formatter->asRelativeTime($model->created_at)) ?>
        <p class="list-group-item-text title-info">
            <?= Html::a($model->category->name, ["/{$model->type}/default/index", 'node' => $model->category->alias])?> •
            <span>
                <?= $model->like_count ?> 个赞 • <?= $model->comment_count ?> 条回复
            </span>
        </p>
    <?php endif ?>
<?php endif ?>