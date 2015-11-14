<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

$this->title = '找回密码';
?>

<div class="row">
    <div class="col-md-4 col-sm-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading"><?= Html::encode($this->title) ?></div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
                <?= $form->field($model, 'email') ?>
                <div class="form-group">
                    <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
