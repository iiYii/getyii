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
<div class="list-group-item">
    <?php if ($this->context->action->id == 'show'): ?>
        <!-- 评论 -->
        <?= Html::a(
            $model->post->title,
            ['/post/view', 'id' => $model->id],
            ['class' => 'list-group-item-heading']
        )?>
        <?=  Html::tag('em',Yii::$app->formatter->asRelativeTime($model->created_at)) ?>
        <p><?= Markdown::process($model->comment, 'gfm') ?></p>
    <?php else: ?>
        <?php if ($this->context->action->id == 'favorite'): ?>
            <i class="icon-bookmark"></i>
        <?php endif ?>
        <!-- 文章 -->
        <?= Html::a(
            $model->title,
            ['/post/view', 'id' => $model->id],
            ['class' => 'list-group-item-heading']
        )?>
        <?=  Html::tag('em',Yii::$app->formatter->asRelativeTime($model->created_at)) ?>
        <p class="list-group-item-text">
            <?= Html::a($model->category->name, ['/post/view', 'id' => $model->id])?>
            <span>
                <?= $model->like_count ?> 人喜欢 • <?= $model->comment_count ?> 条回复
            </span>
        </p>
    <?php endif ?>
</div>