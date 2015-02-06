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
<div class="media">
    <div class="pull-left">
        <img src="http://gravatar.com/avatar/<?= md5($model->user['email']) ?>?s=80" alt="" class="avatar img-circle" />
    </div>
    <div class="media-body">
        <div class="well">
            <div class="media-heading">
                <strong><?= $model->user['username'] ?></strong>&nbsp; <small><?= Yii::$app->formatter->asRelativeTime($model->created_at) ?></small>
                <a class="pull-right comment-reply" href="#" data-floor="" data-username="<?= $model->user['username'] ?>"><i class="icon-repeat"></i>回复</a>
            </div>
            <p><?= Markdown::process($model->comment, 'gfm') ?></p>
        </div>
    </div>
</div><!--/.media-->
<script>

</script>