<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/1
 * Time: 下午1:43
 */

$this->title = '今日签到会员';
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="about-us" class="panel panel-default">
    <div class="panel-heading">
        <strong>今日签到会员)</strong>
        <div class="pull-right">今日签到：<font style="font-weight: bold; color: red;"><?= $dataProvider->getTotalCount() ?></font></div>
    </div>

    <div class="panel-body row">
        <?= \yii\widgets\ListView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "{items}",
            'itemView' => '_item',
            'itemOptions' => [
                'tag' => 'li',
                'class' => 'media col-lg-4 col-md-4',
                'style' => 'float: left; margin-bottom: 15px; font-size: 12px; margin-top: 0;'
            ],
            'options' => [
                'tag' => 'ul',
                'class' => 'media-list registration'
            ]
        ]) ?>
    </div>
</div>


