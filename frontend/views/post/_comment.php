<?php
/**
 * @Author: forecho
 * @Date:   2015-01-29 23:26:54
 * @Last Modified by:   forecho
 * @Last Modified time: 2015-02-04 21:53:45
 */

use yii\helpers\Html;
?>

<div class="media">
    <div class="pull-left">
        <img src="http://gravatar.com/avatar/<?= md5($model->user['email']) ?>?s=80" alt="" class="avatar img-circle" />
    </div>
    <div class="media-body">
        <div class="well">
            <div class="media-heading">
                <strong>John Doe</strong>&nbsp; <small>27 Aug 2013</small>
                <a class="pull-right" href="#"><i class="icon-repeat"></i> Reply</a>
            </div>
            <p><?= $model->comment ?></p>
        </div>
    </div>
</div><!--/.media-->