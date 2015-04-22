<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = '活跃用户';
?>
<div id="about-us" class="panel panel-default container p0">
    <div class="panel-heading">
        <strong>TOP 100 活跃会员</strong>
        <div class="pull-right">目前已经有 <?= $count ?> 位会员加入了 Get Yii。</div>
    </div>

    <div class="panel-body row">
        <?php foreach ($model as $key => $value): ?>
            <div class="col-md-1 col-xs-2">
                <div class="text-center">
                    <p><a href="/people/<?= $value['username'] ?>">
                        <img class="img-responsive img-thumbnail img-circle" src="http://gravatar.com/avatar/<?= md5($value['email']) ?>?s=75" alt="" >
                    </a></p>
                    <h5><a href="/people/<?= $value['username'] ?>">
                        <?= $value['username'] ?>
                    </a></h5>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>