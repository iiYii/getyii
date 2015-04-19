<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\Markdown;
/* @var $this yii\web\View */
?>
<div class="media">
    <span class="badge fr mt15"><?= $model->comment_count ?></span>
    <div class="media-left">
        <?php $img = "http://gravatar.com/avatar/" . md5($model->user['email']) . "?s=48"; ?>
        <?= Html::a(Html::img($img, ['class' => 'media-object']),
            ['/user/default/show', 'username' => $model->user['username']]
        );?>
    </div>
    <div class="media-body">
        <a href="">
            <?= Html::tag('h3',
                Html::a($model->title, ['/topic/default/view', 'id' => $model->id]),
                ['class' => 'media-heading']
            );?>
            <?= Html::tag('strong', Html::tag('span', $model->user['username'])) ?> •
            <?= Html::tag('span', Yii::$app->formatter->asRelativeTime($model->created_at)) ?>
        </a>
    </div>
</div>
