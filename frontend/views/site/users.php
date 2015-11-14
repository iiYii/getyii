<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = '活跃用户';
?>
<div id="about-us" class="panel panel-default">
    <div class="panel-heading">
        <strong>TOP 100 活跃会员</strong>
        <div class="pull-right">目前已经有 <?= $count ?> 位会员加入了 Get Yii</div>
    </div>

    <div class="panel-body row">
        <?php foreach ($model as $key => $value): ?>
            <div class="col-md-1 col-xs-2">
                <div class="text-center">
                    <p>
                        <?= Html::a(Html::img($value->userAvatar, ['class' => 'img-responsive img-thumbnail']),
                            ['/user/default/show', 'username' => $value['username']]
                        );?>
                    </p>
                    <h5>
                        <?= Html::a($value['username'], ['/user/default/show', 'username' => $value['username']]) ?>
                    </h5>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>