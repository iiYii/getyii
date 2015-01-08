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
                            <span><i class="icon-user"></i> <a href="#"><?= $model->title ?></a></span>
                            <span><i class="icon-folder-close"></i> <a href="#">Bootstrap</a></span>
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
                                    );
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
                                        <strong>John Doe</strong>
                                    </div>
                                    <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper.</p>
                                </div>
                            </div>
                        </div><!--/.author-->

                        <div id="comments">
                            <div id="comments-list">
                                <h3>3 Comments</h3>
                                <div class="media">
                                    <div class="pull-left">
                                        <img class="avatar img-circle" src="images/blog/avatar1.png" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="well">
                                            <div class="media-heading">
                                                <strong>John Doe</strong>&nbsp; <small>27 Aug 2013</small>
                                                <a class="pull-right" href="#"><i class="icon-repeat"></i> Reply</a>
                                            </div>
                                            <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
                                        </div>
                                        <div class="media">
                                            <div class="pull-left">
                                                <img class="avatar img-circle" src="images/blog/avatar3.png" alt="">
                                            </div>
                                            <div class="media-body">
                                                <div class="well">
                                                    <div class="media-heading">
                                                        <strong>John Doe</strong>&nbsp; <small>27 Aug 2013</small>
                                                        <a class="pull-right" href="#"><i class="icon-repeat"></i> Reply</a>
                                                    </div>
                                                    <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante.</p>
                                                </div>
                                            </div>
                                        </div><!--/.media-->
                                    </div>
                                </div><!--/.media-->
                                <div class="media">
                                    <div class="pull-left">
                                        <img class="avatar img-circle" src="images/blog/avatar2.png" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="well">
                                            <div class="media-heading">
                                                <strong>John Doe</strong>&nbsp; <small>27 Aug 2013</small>
                                                <a class="pull-right" href="#"><i class="icon-repeat"></i> Reply</a>
                                            </div>
                                            <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
                                        </div>
                                    </div>
                                </div><!--/.media-->
                            </div><!--/#comments-list-->

                            <div id="comment-form">
                                <h3>Leave a comment</h3>
                                <form class="form-horizontal" role="form">
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" placeholder="Name">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="email" class="form-control" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <textarea rows="8" class="form-control" placeholder="Comment"></textarea>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-danger btn-lg">Submit Comment</button>
                                </form>
                            </div><!--/#comment-form-->
                        </div><!--/#comments-->
                    </div>
                </div><!--/.blog-item-->
            </div>
        </div><!--/.col-md-8-->
    </div><!--/.row-->
</section><!--/#blog-->


<section id="blog" class="container">
    <div class="post-view">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'post_meta_id',
                'user_id',
                'title',
                'author',
                'excerpt',
                'image',
                'content:ntext',
                'tags',
                'view_count',
                'comment_count',
                'favorite_count',
                'like_count',
                'hate_count',
                'status',
                'order',
                'created_at',
                'updated_at',
            ],
        ]) ?>

    </div>
</section>