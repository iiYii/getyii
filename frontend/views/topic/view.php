<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use frontend\widgets\PostRight;
use yii\helpers\Markdown;
use yii\bootstrap\Nav;
use frontend\assets\PageDownAsset;

/* @var $this yii\web\View */
/* @var $model common\Models\Post */

$this->title = $model->title;
// $this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
PageDownAsset::register($this);
?>

<section class="container">
    <div class="col-sm-12 list-nav" contenteditable="false" style="">
        <nav class="navbar navbar-default">
        <?= Nav::widget([
            'options' => [
                'class' => 'nav navbar-nav breadcrumb',
            ],
            'items' => [
                ['label' => '社区',  'url' => ['/topic']],
                Html::tag('li', Html::encode($this->title), ['class' => 'mt15']),
            ]
        ]) ?>
        </nav>
        <div class="list-group-item">
            <?= Markdown::process($model->content, 'gfm') ?>
        </div>
        <div class="list-group-item">
            <?= $this->render('_commentView', ['model' => $comment, 'dataProvider' => $dataProvider]) ?>
        </div>

    </div>
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
