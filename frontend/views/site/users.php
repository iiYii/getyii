<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = '活跃用户';
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="about-us" class="container">
    <div class="gap"></div>
    <h1 class="center">TOP 100 活跃会员</h1>
    <p class="lead center">目前已经有 <?= $count ?> 位会员加入了 Get Yii。</p>
    <div class="gap"></div>

    <div id="meet-the-team" class="row">
        <?php foreach ($model as $key => $value): ?>
            <div class="col-md-1 col-xs-2">
                <div class="center">
                    <p><a href="/people/<?= $value['username'] ?>">
                        <img class="img-responsive img-thumbnail img-circle" src="http://gravatar.com/avatar/<?= md5($value['email']) ?>?s=75" alt="" >
                    </a></p>
                    <h5><a href="/people/<?= $value['username'] ?>">
                        <?= $value['username'] ?>
                    </a></h5>
                </div>
            </div>
        <?php endforeach ?>
    </div><!--/#meet-the-team-->
</section><!--/#about-us-->