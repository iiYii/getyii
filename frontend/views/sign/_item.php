<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/1
 * Time: 下午1:53
 */
use common\helpers\Html;
use yii\helpers\Url;
?>

<div class="media-left">
    <a href="<?= Url::to(['/user/default/show', 'username' => $model->user->username]) ?>" rel="author">
        <?= Html::a(Html::img($model->user->UserAvatar, ['class' => 'media-object']),
            ['/user/default/show', 'username' => $model->user->username],
            ['title' => $model->user->username]
        ); ?>
    </a>
</div>
<div class="media-body">
    <div class="media-heading">
        <a href="<?= Url::to(['/user/default/show', 'username' => $model->user->username]) ?>" rel="author"><?= $model->user->username ?></a>
        <em>NO. <i><?= $index + 1 ?></i></em>
    </div>
    <div class="media-content">
        签到时间：<i><?= Yii::$app->formatter->asTime($model->last_sign_at) ?></i><br />
        连续签到：<i><?= $model->continue_times ?></i>天
    </div>
</div>