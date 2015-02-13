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
        <a href="<?= Url::to(['blog/view', 'id' => $model->id]) ?>"><h3><?= $model->title ?></h3></a>
        <div class="entry-meta">
            <span><i class="fa fa-user"></i> <a href="#"><?= $model->user->username ?></a></span>
            <span><i class="fa fa-folder"></i> <a href="#"><?= $model->category->name ?></a></span>
            <span><i class="fa fa-calendar"></i> <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?></span>
            <span><i class="fa fa-eye"></i><?= Html::encode($model->view_count);?></span>
            <span><i class="fa fa-comment"></i>
                <?= Html::a(Html::encode($model->comment_count), ['/blog/view', 'id' => $model->id, '#'=>'comments']);?>
            </span>
        </div>
        <?php $content = explode('<!--more-->', $model->content) ?>
        <?= Markdown::process($content[0], 'gfm') ?>
        <a class="btn btn-default" href="<?= Url::to(['blog/view', 'id' => $model->id]) ?>">继续阅读 <i class="icon-angle-right"></i></a>
    </div>
</div><!--/.blog-item-->