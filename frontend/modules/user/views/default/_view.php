<?php
/**
 * @Author: forecho
 * @Date:   2015-01-29 23:26:54
 * @Last Modified by:   forecho
 * @Last Modified time: 2015-02-03 21:52:33
 */

use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\ActiveForm;

$this->title = '账号设置';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-9">
    </br>
    <?= Menu::widget([
        'options' => [
            'class' => 'nav nav-tabs nav-justified'
        ],
        'items' => [
            ['label' => '个人资料',  'url' => ['/user/default/index']],
            ['label' => '账号设置',  'url' => ['/user/setting/show']],
            ['label' => '账号设置',  'url' => ['/user/default/show?id=1']],
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

