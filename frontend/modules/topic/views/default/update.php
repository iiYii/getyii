<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\Models\Post */

$this->title =  Yii::t('app', 'Update Post: ') . ' ' . $model->title;
?>
<div class="col-md-9 topic-create" contenteditable="false" style="">

    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <?= Html::encode($this->title) ?>
        </div>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>

<?= \frontend\widgets\TopicSidebar::widget([
    'type' => 'create'
])?>