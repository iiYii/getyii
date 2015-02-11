<?php

use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\ListView;

// $this->title = Html::encode($user->username);
// $this->params['breadcrumbs'][] = $this->title;
$username = Yii::$app->getRequest()->getQueryParam('username');
?>
<section class="container user-default-index">

    <div class="col-sm-3">
        <!--left col-->
        <div class="panel panel-default thumbnail center">
            <br>
            <img src="http://gravatar.com/avatar/<?= md5($user->email) ?>?s=200" alt="用户头像" title="用户头像" class="img-circle img-responsive" />
            <h1 class=""><?= Html::tag('strong', $user->username) ?></h1>
            <p><?= $user->tagline ?></p>
            <!-- <button type="button" class="btn btn-success">Book me!</button> -->
            <!-- <button type="button" class="btn btn-info">Send me a message</button> -->
            <!-- <br> -->
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-user"></i>个人信息</div>
            <ul class="list-group">
                <li class="list-group-item text-right">
                    <span class="pull-left"><strong class="">排位</strong></span>
                    <?= $user->id ?>
                </li>
                <li class="list-group-item text-right">
                    <span class="pull-left"><strong class="">加入于</strong></span>
                    <?= Yii::$app->formatter->asDateTime($user->userInfo->created_at) ?>
                </li>
                <li class="list-group-item text-right">
                    <span class="pull-left"><strong class="">城市</strong></span>
                    <?= Html::encode($user->userInfo->location) ?>
                </li>
                <li class="list-group-item text-right">
                    <span class="pull-left"><strong class="">公司</strong></span>
                    <?= $user->userInfo->company ?>
                </li>
                <li class="list-group-item text-right">
                    <span class="pull-left"><strong class="">GitHub</strong></span>
                    <?= Html::a(Html::encode($user->userInfo->github), Html::encode($user->userInfo->github)) ?>
                </li>
                <li class="list-group-item text-right">
                    <span class="pull-left"><strong class="">最后登录时间</strong></span>
                    <?= Yii::$app->formatter->asRelativeTime($user->userInfo->last_login_time) ?>
                </li>
            </ul>
        </div>


        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-user"></i>个人简介</div>
            <div class="panel-body">
                <?= $user->userInfo->info ?>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-link"></i>个人网站</div>
            <div class="panel-body">
                <?= Html::a(Html::encode($user->userInfo->website), Html::encode($user->userInfo->website)) ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-dashboard"></i>个人统计</div>
            <ul class="list-group">
                <li class="list-group-item text-right">
                    <span class="pull-left"><strong class="">被感谢</strong></span> 125
                </li>
                <li class="list-group-item text-right">
                    <span class="pull-left"><strong class="">被赞同</strong></span> 13
                </li>
                <li class="list-group-item text-right">
                    <span class="pull-left"><strong class="">发表文章</strong></span> 37
                </li>
                <li class="list-group-item text-right">
                    <span class="pull-left"><strong class="">发布评论</strong></span> 78
                </li>
            </ul>
        </div>
        <!-- <div class="panel panel-default">
            <div class="panel-heading">社交网络</div>
            <div class="panel-body">
                <i class="fa fa-facebook fa-2x"></i>
                <i class="fa fa-github fa-2x"></i>
                <i class="fa fa-twitter fa-2x"></i>
                <i class="fa fa-pinterest fa-2x"></i>
                <i class="fa fa-google-plus fa-2x"></i>
            </div>
        </div> -->
    </div>
    <!--/col-3-->
    <div class="col-sm-9" contenteditable="false" style="">
        <nav class="navbar navbar-default">
        <?= Menu::widget([
            'options' => [
                'class' => 'nav navbar-nav',
            ],
            'items' => [
                ['label' => '最新评论',  'url' => ['/user/default/show', 'username'=> $username]],
                ['label' => '最新主题',  'url' => ['/user/default/post', 'username'=> $username]],
                ['label' => '最新收藏',  'url' => ['/user/default/favorite', 'username'=> $username]],
            ]
        ]) ?>
        </nav>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'list-group-item'],
            'summary' => false,
            'itemView' => '_view',
            'options' => ['class' => 'list-group'],
            'pager' => [
                'options' => ['class'=>'pagination pagination-lg'],
                'prevPageLabel' => '<i class="icon-angle-left"></i>',
                'nextPageLabel' => '<i class="icon-angle-right"></i>',
            ]
        ]) ?>
    </div>
</section>