<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\bootstrap\Nav;
use frontend\widgets\TopicSidebar;

$this->title = '社区';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-10 topic">
    <div class="panel panel-default">
        <div class="panel-heading p0">
            <?php
                echo Nav::widget([
                    'options' => [
                        'class' => 'nav navbar-nav',
                    ],
                    'items' => [
                        ['label' => '社区',  'url' => false],
                    ]
                ]);
                echo Nav::widget([
                    'options' => [
                        'class' => 'nav navbar-nav navbar-right',
                    ],
                    'items' => [
                        ['label' => '热门主题',  'url' => ['/topic/index', 'tab' => 'hot']],
                        ['label' => '最新主题',  'url' => ['/topic/index', 'tab' => 'newest'], 'options' => ['class' => 'mr15']],
                    ]
                ])
            ?>
            <div class="clearfix"></div>
        </div>

        <?php Pjax::begin(); ?>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'list-group-item'],
            'summary' => false,
            'itemView' => '_post',
            'options' => ['class' => 'list-group'],
        ]) ?>
        <?php Pjax::end(); ?>
    </div>
</div>
<?= TopicSidebar::widget(); ?>