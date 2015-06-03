<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Notifications');
?>
<div class="container p0 notification-index">
    <div class="panel panel-default">
        <div class="panel-heading">
                <?= Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-trash']) . ' 清空',
                    '/notification/clear',
                    [
                        'data' => [
                            'disable-with' => "清空中...",
                            'method' => 'post',
                        ],
                        'class' => 'btn btn-danger'
                    ]
                ) ?>
            <?= Html::tag('h4', $this->title, ['class' => 'pull-right']) ?>
        </div>
        <?php Pjax::begin(); ?>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'media notification'],
            'summary' => false,
            'itemView' => '_item',
            'options' => ['class' => 'panel-body'],
            'viewParams' => ['notifyCount' => $notifyCount]
        ]) ?>
        <?php Pjax::end(); ?>
    </div>
</div>