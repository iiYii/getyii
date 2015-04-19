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

<div class="avatar pull-left">
    <?php $img = "http://gravatar.com/avatar/" . md5($model->user['email']) . "?s=48"; ?>
    <?= Html::a(Html::img($img, ['class' => 'media-object avatar-48']),
        ['/user/default/show', 'username' => $model->user['username']]
    ); ?>
</div>

<div class="infos">

    <div class="media-heading meta">
        <?= Html::a($model->user['username'], ['/people', 'id' => $model->user['username']]) ?>
        <span> •  </span>
        <abbr class="timeago" title="<?= Yii::$app->formatter->asDatetime($model->created_at) ?>">
            <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?>
        </abbr>
        <span> •  </span>
        <?= Html::a('#1', '#reply1', ['class' => 'reply-floor']) ?>

        <span class="operate pull-right">
            <a title="喜欢" data-count="0" data-state="" data-type="Reply" data-id="255240" class="likeable " href="#"><i class="fa fa-heart-o"></i> <span>喜欢</span></a>
            <a class="edit fa fa-pencil" data-uid="3" title="修改回帖" href="/topics/25116/replies/255240/edit"></a>
            <a data-floor="14" data-login="lgn21st" title="回复此楼" class="btn-reply fa fa-mail-reply" href="#"></a>
        </span>

    </div>

    <div class="media-body markdown-reply content-body">
        <?= Markdown::process($model->comment, 'gfm') ?>
    </div>
</div>