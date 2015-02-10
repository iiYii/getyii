<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\widgets\Connect;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login';
?>
<section class="container site-login">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'password', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2']])->passwordInput()->label('密码' . ' (' . Html::a('忘记密码？', ['site/request-password-reset'], ['tabindex' => '5']) . ')') ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <?= Connect::widget([
        'baseAuthUrl' => ['/user/security/auth']
    ]) ?>
</section>
