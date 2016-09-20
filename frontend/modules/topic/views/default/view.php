<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
/* @var $model common\Models\Post */

$this->title = $model->title;

\frontend\assets\AtJsAsset::register($this);

$node = \common\models\PostMeta::find()->where(['alias' => $model->category->alias])->one();
$bg_color = !empty($node['bg_color']) ? $node['bg_color'] : '#f0f0f0';

?>

<div class="col-md-9 topic-view" contenteditable="false" style="">
    <div class="panel panel-default">
        <div class="panel-heading media clearfix">
            <div class="media-body">
                <?= Html::tag('h1', Html::encode($model->title), ['class' => 'media-heading']); ?>
                <div class="info">
                    <?= Html::a(
                        $model->category->name,
                        ['/topic/default/index', 'node' => $model->category->alias],
                        ['class' => 'node']
                    ) ?>
                    ·
                    <?= Html::a($model->user['username'], ['/user/default/show', 'username' => $model->user['username']]) ?>
                    ·
                    于 <?= Html::tag('abbr', Yii::$app->formatter->asRelativeTime($model->created_at), ['title' => Yii::$app->formatter->asDatetime($model->created_at)]) ?>发布
                    ·
                    <?= $model->view_count ?> 次阅读
                </div>
            </div>
            <div class="avatar media-right">
                <?= Html::a(Html::img($model->user->userAvatar, ['class' => 'media-object avatar-48']),
                    ['/user/default/show', 'username' => $model->user['username']]
                ); ?>
            </div>
        </div>
        <div class="panel-body article">

            <?= HtmlPurifier::process(Markdown::process($model->content, 'gfm')) ?>
            <div class="bdsharebuttonbox" style="float: right"><div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
                <script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script></div>
            <div style="clear: both"></div>

            <hr/>
            <?php //echo \frontend\widgets\Ad::widget(['key'=>'bd_pic_640_60']); ?>

            <?php if($donate): ?>
            <div style="text-align: center; color: #666;">
                <p>如果这篇文章对您有帮助，不妨微信小额赞助我一下，让我有动力继续写出高质量的帖子。</p>
                <?= Html::Button('打赏作者', ['class' =>'btn btn-danger','id'=>'donate-btn']) ?>
                <div class="row" id="donate-qrode">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                <div class="panel panel-default corner-radius mt15">
                    <div class="panel-body donate">
                        <?= Html::img(params('qrCodeUrl') . '/' . $donate->qr_code, ['class' => 'img']) ?>
                        <p><?= $donate->description ?></p>
                    </div>
                </div>
                    <div class="col-md-3"></div>
                </div>
                </div>
            </div>
            <?php endif ?>

            <?php if ($model->status == 2): ?>
                <div class="ribbon-excellent">
                    <i class="fa fa-trophy excellent"></i> 本帖已被设为精华帖！
                </div>
            <?php endif ?>
            <?php if ($model->recommend == 1): ?>
                <div class="ribbon-excellent">
                    <i class="fa fa-plane excellent"></i> 本帖已被设为推荐帖！
                </div>
            <?php endif ?>
            <?php if ($model->top == 1): ?>
                <div class="ribbon-top">
                    <i class="fa fa-arrow-up excellent"></i> 本帖已被设为置顶帖！
                </div>
            <?php endif ?>

        </div>
        <div class="panel-footer clearfix opts">
            <?php
                $like = Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-thumbs-o-up']) . ' ' . Html::tag('span', $model->like_count) . ' 个赞',
                    '#',
                    [
                        'data-do' => 'like',
                        'data-id' => $model->id,
                        'data-type' => $model->type,
                        'class' => ($model->like) ? 'active': ''
                    ]
                );
                $hate = Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-thumbs-o-down']) . ' 踩',
                    '#',
                    [
                        'data-do' => 'hate',
                        'data-id' => $model->id,
                        'data-type' => $model->type,
                        'class' => ($model->hate) ? 'active': ''
                    ]
                );
                $follow = Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-eye']) . ' 关注',
                    '#',
                    [
                        'data-do' => 'follow',
                        'data-id' => $model->id,
                        'data-type' => $model->type,
                        'class' => ($model->follow) ? 'active': ''
                    ]
                );
                $thanks = Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-heart-o']) . ' 感谢',
                    '#',
                    [
                        'data-do' => 'thanks',
                        'data-id' => $model->id,
                        'data-type' => $model->type,
                        'class' => ($model->thanks) ? 'active': ''
                    ]
                );
                $favorite = Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-star']) . ' 收藏',
                    '#',
                    [
                        'data-do' => 'favorite',
                        'data-id' => $model->id,
                        'data-type' => $model->type,
                        'class' => ($model->favorite) ? 'active': ''
                    ]
                );

                if($model->isCurrent()){
                    echo Html::a(
                        Html::tag('i', '', ['class' => 'fa fa-thumbs-o-up']) . ' ' . Html::tag('span', $model->like_count) . ' 个赞',
                        'javascript:;'
                    );
                } else {
                    echo $like, $hate;
                    echo $thanks;
                }
                echo $follow;
                echo $favorite;

                if ($admin) {
                    $class = $model->status == 2 ? ['class' => 'active'] : null;
                    echo Html::a(
                        Html::tag('i', '', ['class' => 'fa fa-trophy']) . ' 精华',
                        ['/topic/default/excellent', 'id' => $model->id],
                        $class
                    );

                    $class = $model->recommend == 1 ? ['class' => 'active'] : null;
                    echo Html::a(
                        Html::tag('i', '', ['class' => 'fa fa-plane']) . '推荐',
                        ['/topic/default/recommend', 'id' => $model->id],
                        $class
                    );

                    $class = $model->top == 1 ? ['class' => 'active'] : null;
                    echo Html::a(
                        Html::tag('i', '', ['class' => 'fa fa-arrow-up']) . ' 置顶',
                        ['/topic/default/top', 'id' => $model->id],
                        $class
                    );

                }
            ?>
            <?php if ($model->isCurrent() || \common\models\User::getThrones()): ?>
                <span class="pull-right">
                    <?= Html::a(
                        Html::tag('i', '', ['class' => 'fa fa-pencil']) . ' 修改',
                        ['/topic/default/update', 'id' => $model->id]
                    ) ?>
              <?php if($model->comment_count == 0): ?>
                    <?= Html::a(
                        Html::tag('i', '', ['class' => 'fa fa-trash']) . ' 删除',
                        ['/topic/default/delete', 'id' => $model->id],
                        [
                            'data' => [
                                'confirm' => "您确认要删除主题「{$model->title}」吗？",
                                'method' => 'post',
                            ],
                        ]
                    ) ?>
                    <?php endif?>
                </span>
            <?php endif ?>



        </div>
    </div>


    <?= $this->render(
        '@frontend/modules/topic/views/comment/index',
        ['model' => $model, 'dataProvider' => $dataProvider]
    ) ?>


    <?= $this->render(
        '@frontend/modules/topic/views/comment/create',
        ['model' => $comment, 'post' => $model]
    ) ?>

</div>
<?= \frontend\widgets\TopicSidebar::widget([
    'type' => 'view',
    'node' => $model->category,
    'tags' => $model->tags
]); ?>

<script type="text/javascript">
    document.getElementById('wrap').style.backgroundColor="<?= $bg_color ?>";
</script>
