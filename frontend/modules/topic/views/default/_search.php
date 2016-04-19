<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
?>
<div class="media">
    <div class="media-body">
        <div class="media-heading">
            <?= Html::a(Html::encode($model->title),
                ['/topic/default/view', 'id' => $model->topic_id], ['title' => $model->title]
            ); ?> <span class="title-info"><?= \common\helpers\Formatter::relative($model->updated_at)?></span>
        </div>
    </div>
</div>
