<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\widgets\PostRight;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
/* @var $model common\Models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<section id="blog" class="container">
    <div class="row">
        <?= PostRight::widget(); ?>

        <div class="col-sm-8 col-sm-pull-4">
            <div class="blog">
                <div class="blog-item">
                    <?php if ($model->image) {
                        echo Html::img($model->image, ['class' => 'img-responsive img-blog', 'width' => '100%']);
                    } ?>
                    <div class="blog-content">
                        <h3><?= $model->title ?></h3>
                        <div class="entry-meta">
                            <span><i class="icon-user"></i> <a href="#"><?= $model->user->username ?></a></span>
                            <span><i class="icon-folder-close"></i> <a href="#"><?= $model->category->name ?></a></span>
                            <span><i class="icon-calendar"></i> <?= date('Y-m-d H:i:s', $model->updated_at) ?></span>
                            <span><i class="icon-comment"></i>
                                <?= Html::a(Html::encode($model->comment_count), ['/post/view', 'id' => $model->id, '#'=>'comments']);?>
                            </span>
                        </div>
                        <p><?= Markdown::process($model->content, 'gfm') ?></p>

                        <hr>

                        <div class="tags">
                            <i class="icon-tags"></i> Tags
                            <?php foreach (explode(',', $model->tags) as $key => $value){
                                echo Html::a(
                                        Html::encode($value),
                                        ['/post/index', 'PostSearch[tags]' => $value],
                                        ['class' => 'btn btn-xs btn-primary']
                                    ), ' ';
                            } ?>
                        </div>

                        <p>&nbsp;</p>

                        <div class="author well">
                            <div class="media">
                                <div class="pull-left">
                                    <img class="avatar img-thumbnail" src="images/blog/avatar.jpg" alt="">
                                </div>
                                <div class="media-body">
                                    <div class="media-heading">
                                        <strong><?= $model->user->username ?></strong>
                                    </div>
                                    <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper.</p>
                                </div>
                            </div>
                        </div><!--/.author-->

                    </div>
                </div><!--/.blog-item-->
            </div>
        </div><!--/.col-md-8-->
    </div><!--/.row-->
</section><!--/#blog-->