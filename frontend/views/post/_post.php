<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\Markdown;
/* @var $this yii\web\View */
?>
<div class="blog-item">
    <?php if ($model->image) {
        echo Html::img($model->image, ['class' => 'img-responsive img-blog', 'width' => '100%']);
    } ?>
    <div class="blog-content">
        <a href="<?= Url::to(['post/view', 'id' => $model->id]) ?>"><h3><?= $model->title ?></h3></a>
        <div class="entry-meta">
            <span><i class="icon-user"></i> <a href="#"><?= $model->user->username ?></a></span>
            <span><i class="icon-folder-close"></i> <a href="#"><?= $model->category->name ?></a></span>
            <span><i class="icon-calendar"></i> <?= date('Y-m-d H:i:s', $model->updated_at) ?></span>
            <span><i class="icon-comment"></i>
                <?= Html::a(Html::encode($model->comment_count), ['/post/view', 'id' => $model->id, '#'=>'comments']);?>
            </span>
        </div>
        <?php $content = explode('<!--more-->', $model->content) ?>
        <?= Markdown::process($content[0], 'gfm') ?>
        <a class="btn btn-default" href="<?= Url::to(['post/view', 'id' => $model->id]) ?>">Read More <i class="icon-angle-right"></i></a>
    </div>
</div><!--/.blog-item-->