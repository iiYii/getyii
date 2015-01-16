<?php

use yii\helpers\Html;
use yii\helpers\Url;
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

                        <div class="text-center">
                            <button type="button" data-do="like" data-id="<?= $model->id ?>" data-type="post" class="btn btn-success">
                                <span class="num"><?= $model->like_count ?></span> 点赞
                            </button>
                            <button type="button" data-do="thanks" data-id="<?= $model->id ?>" data-type="post" class="btn btn-default <?php if($model->thanks) echo 'active' ?>">
                                感谢
                            </button>
                            <button type="button" data-do="favorite" data-id="<?= $model->id ?>" data-type="post" class="btn btn-default <?php if($model->favorite) echo 'active' ?>">
                                收藏
                            </button>
                            <button type="button" data-do="hate" data-id="<?= $model->id ?>" data-type="post" class="btn btn-default">
                                <span class="num"><?= $model->hate_count ?></span> 喝倒彩
                            </button>
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
<?php
$apiUrl = Url::to(['api']);
$script = <<<EOF
//赞, 踩, 收藏
$(document).on('click', '[data-do]', function(e){
    var _this = $(this),
        _id = _this.data('id'),
        _do = _this.data('do'),
        _type = _this.data('type');
    if (_this.is('a')) e.preventDefault();
    $.post('{$apiUrl}', {id: _id, do: _do, type: _type}, function(result){
        if (result.type == 'success') {
            //修改记数
            var num = _this.find('.num'),
                numValue = parseInt(num.html()),
                active = _this.hasClass('active');
            _this.toggleClass('active');
            if (num.length) {
                num.html(numValue + (active ? -1 : 1));
            }
            if ($.inArray(_do, ['like', 'hate']) >= 0) {
                _this.siblings('[data-do=like],[data-do=hate]').each(function(){
                    var __this = $(this),
                        __do = __this.data('do'),
                        __id = __this.data('id');
                    if (__id == _id) { // 同一个话题或评论触发
                        __this.toggleClass('active', __do == _do);

                        var _num = __this.find('.num')
                            _numValue = parseInt(_num.html());
                        if (_num.length) {
                            _num.html(_numValue + (__do != _do ? (_numValue > 0 ? -1 : 0): 1));
                        }
                    }
                });
            }
        } else {
            alert(result.message);
        }
    });
});
EOF;
$this->registerJs($script);
