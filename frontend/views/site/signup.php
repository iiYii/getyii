<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\widgets\Connect;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = Yii::t('app', 'Sign up');

?>

<div class="row">
    <div class="col-md-4 col-sm-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading"><?= Html::encode($this->title) ?></div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'form-signup',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false
                ]); ?>
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Sign up'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="panel-footer">
                <?= Html::a(Yii::t('app', 'Login'), '/site/login') ?>
            </div>
        </div>
    </div>
</div>
