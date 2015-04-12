<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
?>
<div id="comments">
    <div id="comments-list">
        <h3><?= $dataProvider->count; ?> 条评论</h3>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'summary' => false,
            'itemView' => '_comment',
            'pager' => [
                'options' => ['class'=>'pagination pagination-lg'],
                'prevPageLabel' => '<i class="icon-angle-left"></i>',
                'nextPageLabel' => '<i class="icon-angle-right"></i>',
            ]
        ]) ?>

    </div><!--/#comments-list-->

    <div id="comment-form">
        <h3>我要评论 <?php if (Yii::$app->user->getIsGuest()): ?> <small class="text-warning">(需要登录)</small> <?php endif ?></h3>
        <?php $form = ActiveForm::begin([
            'fieldConfig' => [
                'template' => "{input}\n{hint}\n{error}"
            ]
        ]); ?>

        <?= $form->errorSummary($model, [
            'class' => 'alert alert-danger'
        ]) ?>

        <?= $this->render('/partials/markdwon_help') ?>

        <?= $form->field($model, 'comment', [
            'selectors' => [
                'input' => '#md-input'
            ],
        ])->textarea([
            'placeholder' => '内容',
            'disabled' => Yii::$app->user->getIsGuest(),
            'id' => 'md-input',
            'rows'        => 6
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton('提交评论', ['class' => 'btn btn-danger btn-lg']) ?>
        </div>

        <div id="md-preview"></div>

        <?php ActiveForm::end(); ?>

    </div><!--/#comment-form-->
</div><!--/#comments-->