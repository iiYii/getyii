<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use frontend\widgets\PostRight;
use yii\helpers\Markdown;
use frontend\assets\PageDownAsset;

/* @var $this yii\web\View */
/* @var $model common\Models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
PageDownAsset::register($this);
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
                            <span><i class="fa fa-user"></i> <a href="#"><?= $model->user->username ?></a></span>
                            <span><i class="fa fa-folder"></i> <a href="#"><?= $model->category->name ?></a></span>
                            <span><i class="fa fa-calendar"></i> <?= date('Y-m-d H:i:s', $model->updated_at) ?></span>
                            <span><i class="fa fa-eye"></i><?= Html::encode($model->view_count);?></span>
                            <span><i class="fa fa-comment"></i>
                                <?= Html::a(Html::encode($model->comment_count), ['/post/view', 'id' => $model->id, '#'=>'comments']);?>
                            </span>
                        </div>
                        <p><?= Markdown::process($model->content, 'gfm') ?></p>

                        <hr>
                        <?php if ($tags = $model->tags): ?>
                            <div class="tags">
                                <i class="icon-tags"></i> Tags
                                <?php foreach (explode(',', $tags) as $key => $value){
                                    echo Html::a(Html::encode($value),
                                        ['/post/index', 'PostSearch[tags]' => $value],
                                        ['class' => 'btn btn-xs btn-primary']
                                    ), ' ';} ?>
                            </div>
                        <?php endif ?>

                        <p>&nbsp;</p>

                        <div class="text-center">
                            <?php if ($isCurrent): ?>
                                <?= Html::a('编辑',['/post/update', 'id' => $model->id], ['class' => 'btn btn-success']); ?>
                                <?= Html::a('删除',['/post/delete', 'id' => $model->id], [
                                    'class' => 'btn btn-default',
                                    'data' => [
                                        'confirm' => "您确认要删除文章「{$model->title}」吗？",
                                        'method' => 'post',
                                    ],
                                ]); ?>
                            <?php else: ?>
                                <button type="button" data-do="like" data-id="<?= $model->id ?>" data-type="post" class="btn btn-success <?= ($model->like) ? 'active': ''; ?>">
                                    <span class="num"><?= $model->like_count ?></span> 点赞
                                </button>
                                <button type="button" data-do="thanks" data-id="<?= $model->id ?>" data-type="post" class="btn btn-default <?= ($model->thanks) ? 'active': ''; ?>">
                                    感谢
                                </button>
                                <button type="button" data-do="favorite" data-id="<?= $model->id ?>" data-type="post" class="btn btn-default <?= ($model->favorite) ? 'active': ''; ?>">
                                    收藏
                                </button>
                                <button type="button" data-do="hate" data-id="<?= $model->id ?>" data-type="post" class="btn btn-default <?= ($model->hate) ? 'active': ''; ?>">
                                    <span class="num"><?= $model->hate_count ?></span> 喝倒彩
                                </button>
                            <?php endif ?>
                        </div>

                        <p>&nbsp;</p>

                        <div class="author well">
                            <div class="media">
                                <div class="pull-left">
                                    <img src="http://gravatar.com/avatar/<?= md5($model->user->email) ?>?s=75" alt="" class="avatar img-thumbnail" />
                                </div>
                                <div class="media-body">
                                    <div class="media-heading">
                                        <?= Html::tag('strong', $model->user->username), '，', $model->user->tagline ?>
                                    </div>
                                    <p><?= $model->userInfo->info ?></p>
                                </div>
                            </div>
                        </div><!--/.author-->

                        <?= $this->render('_commentView', ['model' => $comment, 'dataProvider' => $dataProvider]) ?>

                    </div>
                </div><!--/.blog-item-->
            </div>
        </div><!--/.col-md-8-->
    </div><!--/.row-->
</section><!--/#blog-->
<?php
if (!Yii::$app->user->getIsGuest()) {
    $apiUrl = Url::to(['api']);
    $script = <<<EOF
$('#wmd-input').one('focus', function(){
    var commentConverter = Markdown.getSanitizingConverter();
        commentEditor = new Markdown.Editor(commentConverter);
    commentEditor.run();
    $('#wmd-preview').removeClass('hide');
});

$(".comment-reply").on('click', function(e){
    e.preventDefault();
    var comment = $("#wmd-input").html(),
        username = "@" + $(this).attr("data-username") + " ";
    $("#wmd-input").html(comment + username);
});

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
}
