<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\helpers\Markdown;
use yii\bootstrap\Nav;

/* @var $this yii\web\View */
/* @var $model common\Models\Post */

$this->title = $model->title;
// $this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-sm-10 topic-view" contenteditable="false" style="">
    <div class="panel panel-default">
        <div class="panel-heading media clearfix">
            <div class="media-body">
                <?= Html::tag('h1', $model->title, ['class' => 'media-heading']); ?>
                <div class="info">
                    <?= Html::a('分享', ['/topic/node', 'id' => $model->post_meta_id]) ?>
                    ·
                    <?= Html::a($model->user['username'], ['/people', 'id' => $model->user['username']]) ?>
                    ·
                    于 <?= Html::tag('abbr', Yii::$app->formatter->asRelativeTime($model->created_at)) ?>发布
                    ·
                    最后由 <a data-name="lgn21st" href="/lgn21st">lgn21st</a> 于 <abbr class="timeago" title="2015-04-16T08:58:42+08:00">2 天前</abbr>回复
                    ·
                    <?= $model->view_count ?> 次阅读
                </div>
            </div>
            <div class="avatar media-right">
                <?php $img = "http://gravatar.com/avatar/" . md5($model->user['email']) . "?s=48"; ?>
                <?= Html::a(Html::img($img, ['class' => 'media-object avatar-48']),
                    ['/user/default/show', 'username' => $model->user['username']]
                ); ?>
            </div>
        </div>
        <div class="panel-body article">
            <?= Markdown::process($model->content, 'gfm') ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <?= Yii::t('app', 'Received {0} reply', $model->comment_count) ?>
        </div>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'list-group-item media'],
            'summary' => false,
            'itemView' => '_comment',
        ]) ?>
    </div>

    <?= $this->render('_commentView', ['model' => $comment, 'dataProvider' => $dataProvider]) ?>

</div>
<?= \frontend\widgets\TopicSidebar::widget(); ?>
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
