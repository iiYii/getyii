<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap\Nav;
use frontend\widgets\PostRight;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $this->title = 'Blog';
// $this->params['breadcrumbs'][] = $this->title;
?>

<section id="topic" class="container">

    <div class="col-sm-12 list-nav" contenteditable="false" style="">
        <nav class="navbar navbar-default">
        <?= Nav::widget([
            'options' => [
                'class' => 'nav navbar-nav',
            ],
            'items' => [
                ['label' => '社区',  'url' => false],
            ]
        ]) ?>
        <?= Nav::widget([
            'options' => [
                'class' => 'nav navbar-nav navbar-right',
            ],
            'items' => [
                [
                    'label' => '全部话题',
                    'items' => [
                        ['label' => '我的主页', 'url' => ['/user/default']],
                        ['label' => '帐号设置', 'url' => ['/user/setting/profile']],
                        ['label' => '退出','url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']]
                    ]
                ],
                ['label' => '最新主题',  'url' => ['/topic/index', 'tab' => 'newest']],
                ['label' => '热门主题',  'url' => ['/topic/index', 'tab' => 'hot']],
                ['label' => '+ 新话题',  'url' => ['/topic/create'], 'options' => ['class' => 'mr15', 'id' => 'new-topic']],
            ]
        ]) ?>
        </nav>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'list-group-item'],
            'summary' => false,
            'itemView' => '_post',
            'options' => ['class' => 'list-group'],
            'pager' => [
                'options' => ['class'=>'pagination pagination-lg'],
                'prevPageLabel' => '<i class="icon-angle-left"></i>',
                'nextPageLabel' => '<i class="icon-angle-right"></i>',
            ]
        ]) ?>
    </div>
</section><!--/#blog-->