<?php
/**
 * @Author: forecho
 * @Date:   2015-01-29 23:26:54
 * @Last Modified by:   forecho
 * @Last Modified time: 2015-02-03 22:00:32
 */

use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\ActiveForm;

// $this->title = '账号设置';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-9">
    </br>
    <?= Menu::widget([
        'options' => [
            'class' => 'nav nav-tabs nav-justified'
        ],
        'items' => [
            ['label' => '最新评论',  'url' => ['/user/default/index']],
            ['label' => '最近主题',  'url' => ['/user/setting/show']],
            ['label' => '最新收藏',  'url' => ['/user/default/show?id=1']],
        ]
    ]) ?>

    <div class="list-group">
        <div class="list-group-item">
            <a href="">
                <h4 class="list-group-item-heading">List group item heading</h4>
            </a>
            <p class="list-group-item-text">...</p>
        </div>
       <div class="list-group-item">
            <a href="">
                <h4 class="list-group-item-heading">List group item heading</h4>
            </a>
            <p class="list-group-item-text">...</p>
        </div>
       <div class="list-group-item">
            <a href="">
                <h4 class="list-group-item-heading">List group item heading</h4>
            </a>
            <p class="list-group-item-text">...</p>
        </div>
       <div class="list-group-item">
            <a href="">
                <h4 class="list-group-item-heading">List group item heading</h4>
            </a>
            <p class="list-group-item-text">...</p>
        </div>
       <div class="list-group-item">
            <a href="">
                <h4 class="list-group-item-heading">List group item heading</h4>
            </a>
            <p class="list-group-item-text">...</p>
        </div>
       <div class="list-group-item">
            <a href="">
                <h4 class="list-group-item-heading">List group item heading</h4>
            </a>
            <p class="list-group-item-text">...</p>
        </div>
       <div class="list-group-item">
            <a href="">
                <h4 class="list-group-item-heading">List group item heading</h4>
            </a>
            <p class="list-group-item-text">...</p>
        </div>
       <div class="list-group-item">
            <a href="">
                <h4 class="list-group-item-heading">List group item heading</h4>
            </a>
            <p class="list-group-item-text">...</p>
        </div>
    </div>
</div>

