<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<div class="panel panel-default">
    <div class="panel-heading clearfix">
        添加评论 <?php if (Yii::$app->user->getIsGuest()): ?> <small class="text-warning">(需要登录)</small> <?php endif ?>
    </div>

    <div class="panel-body">
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
    </div>
</div>
