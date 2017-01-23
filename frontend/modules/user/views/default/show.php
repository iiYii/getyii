<?php

use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\ListView;
use common\models\User;
use yii\helpers\Url;

$this->title = Html::encode($user->username);
// $this->params['breadcrumbs'][] = $this->title;
$username = Yii::$app->getRequest()->getQueryParam('username');
/** @var User $user*/
?>
<section class="container user-default-index">

    <div class="col-sm-3">
        <!--left col-->
        <div class="panel panel-default thumbnail center">
            <div class="panel-body">
                <div class="media">
                    <div class="media-left media-middle">
                        <?= Html::img($user->getUserAvatar(100), ['class' => 'media-object']);?>
                    </div>
                    <div class="media-body">
                        <h2 class="mt5"><?= Html::tag('strong', Html::encode($user->username)) ?></h2>
                        <p>第 <?= $user->id ?> 位会员</p>
                        <div class="pull-left">
                            <span class="label label-<?= User::getRole($user->role)['color']?> role"><?= User::getRole($user->role)['name']?></span>
                        </div>
                    </div>
                </div>

                <div class="follow-info row">
                    <div class="col-sm-4 followers" data-login="rei">
                        <a class="counter" href="<?= Url::to(['/user/default/point', 'username'=> $username])?>">
                            <?= $user->merit ? $user->merit->merit : 0 ?>
                        </a>
                        <a class="text" href="<?= Url::to(['/user/default/point', 'username'=> $username])?>">积分</a>
                    </div>
                    <div class="col-sm-4 following">
                        <a class="counter" href="#"><?= $user->userInfo->like_count ?></a>
                        <a class="text" href="#">赞</a>
                    </div>
                    <div class="col-sm-4 stars">
                        <a class="counter" href="#"><?= $user->userInfo->thanks_count ?></a>
                        <a class="text" href="#">感谢</a>
                    </div>
                </div>
                <!-- <button type="button" class="btn btn-success">Book me!</button> -->
                <!-- <button type="button" class="btn btn-info">Send me a message</button> -->
                <!-- <br> -->
            </div>


        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-user"></i>个人信息</div>
            <ul class="list-group">
                <li class="list-group-item text-right">
                    <span class="pull-left"><strong class="">加入于</strong></span>
                    <?= Yii::$app->formatter->asDateTime($user->userInfo->created_at) ?>
                </li>
                <?php if ($user->userInfo->location): ?>
                    <li class="list-group-item text-right">
                        <span class="pull-left"><strong class="">城市</strong></span>
                        <?= Html::encode($user->userInfo->location) ?>
                    </li>
                <?php endif ?>
                <?php if ($user->userInfo->company): ?>
                    <li class="list-group-item text-right">
                        <span class="pull-left"><strong class="">公司</strong></span>
                        <?= Html::encode($user->userInfo->company) ?>
                    </li>
                <?php endif ?>
                <?php if ($user->userInfo->github): ?>
                    <li class="list-group-item text-right">
                        <span class="pull-left"><strong class="">GitHub</strong></span>
                        <?= Html::a(Html::encode($user->userInfo->github), Html::encode($user->userInfo->github)) ?>
                    </li>
                <?php endif ?>
                <li class="list-group-item text-right">
                    <span class="pull-left"><strong class="">最后登录时间</strong></span>
                    <?= Yii::$app->formatter->asRelativeTime($user->userInfo->last_login_time) ?>
                </li>
                <?php if ($user->tagline): ?>
                    <li class="list-group-item text-right">
                        <span class="pull-left"><strong class="">签名</strong></span>
                        <?= Html::encode($user->tagline) ?>
                    </li>
                <?php endif ?>
            </ul>
        </div>

        <?php if ($user->userInfo->info): ?>
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-user"></i>个人简介</div>
                <div class="panel-body">
                    <?= Html::encode($user->userInfo->info) ?>
                </div>
            </div>
        <?php endif ?>

        <?php if ($user->userInfo->website): ?>
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-link"></i>个人网站</div>
                <div class="panel-body">
                    <?php if (\yii\helpers\Url::isRelative($user->userInfo->website)) {
                        $user->userInfo->website ='http://' . $user->userInfo->website;
                    }
                    echo Html::a(Html::encode($user->userInfo->website), Html::encode($user->userInfo->website)) ?>
                </div>
            </div>
        <?php endif ?>

        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-dashboard"></i>个人成就</div>
            <ul class="list-group">
                <li class="list-group-item text-right">
                    <span class="pull-left"><strong class="">发表文章次数</strong></span>
                    <?= $user->userInfo->post_count ?>
                </li>
                <li class="list-group-item text-right">
                    <span class="pull-left"><strong class="">发布回复次数</strong></span>
                    <?= $user->userInfo->comment_count ?>
                </li>
                <li class="list-group-item text-right">
                    <span class="pull-left"><strong class="">个人主页浏览次数</strong></span>
                    <?= $user->userInfo->view_count ?>
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
    <div class="col-sm-9 list-nav mb20" contenteditable="false" style="">
        <nav class="navbar navbar-default">
        <?= Menu::widget([
            'options' => [
                'class' => 'nav navbar-nav',
            ],
            'items' => [
                ['label' => '最新回复',  'url' => ['/user/default/show', 'username'=> $username]],
                ['label' => '最新主题',  'url' => ['/user/default/post', 'username'=> $username]],
                ['label' => '最新收藏',  'url' => ['/user/default/favorite', 'username'=> $username]],
                ['label' => '最新赞过主题',  'url' => ['/user/default/like', 'username'=> $username]],
                ['label' => '积分动态',  'url' => ['/user/default/point', 'username'=> $username]],
            ]
        ]) ?>
        </nav>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'list-group-item'],
            'summary' => false,
            'itemView' => '_view',
            'options' => ['class' => 'list-group'],
        ]) ?>
    </div>
</section>