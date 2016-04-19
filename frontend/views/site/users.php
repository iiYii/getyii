<?php
/* @var $this yii\web\View */
/* @var \yii\base\Object $model */
$this->title = '活跃用户';
?>
<div id="about-us" class="panel panel-default">
    <div class="panel-heading">
        <strong>TOP 100 活跃会员</strong>
        <div class="pull-right">目前已经有 <?= $count ?> 位会员加入了 Get Yii</div>
    </div>

    <div class="panel-body row">
        <?= $this->render('/partials/users', ['model' => $model]); ?>
    </div>
</div>