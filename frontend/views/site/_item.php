<?php

use yii\helpers\Html;
?>
<li class="list-group-item media col-sm-6 mt0">

    <?= Html::a(Html::tag('span', $model['comment_count'], ['class' => 'badge badge-reply-count']),
        ['/topics/view', 'id' => $model->id], ['class' => 'pull-right']
    );?>

    <div class="avatar pull-left">
        <?php $img = "http://gravatar.com/avatar/" . md5($model->user['email']) . "?s=48"; ?>
        <?= Html::a(Html::img($img, ['class' => 'media-object']),
            ['/user/default/show', 'username' => $model->user['username']]
        );?>
    </div>

    <div class="infos">

        <div class="media-heading">
            <?= Html::a($model->title,
                ['/topics/view', 'id' => $model->id], ['title' => $model->title]
            ); ?>
        </div>
        <div class="media-body meta">
            <?php
            echo Html::a(Html::tag('span', $model->like_count, ['class' => 'fa fa-thumbs-o-up']),
                ['/topics/view', 'id' => $model->id], ['class' => 'remove-padding-left']
            ),
            Html::tag('span', '•'),
            Html::a($model->category->name, ['/user/default/show', 'username' => $model->user['username']]);

            if ($model->comment_count) {
                echo Html::tag('span', '•'),
                Html::a($model->user['username'], ['/user/default/show', 'username' => $model->user['username']]),
                Html::tag('span', '•'),
                Yii::$app->formatter->asRelativeTime($model->created_at);
            } ?>
        </div>

    </div>

</li>