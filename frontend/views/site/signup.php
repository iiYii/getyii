<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Signup';
<<<<<<< HEAD
<<<<<<< HEAD
?>
<section class="container site-signup">
=======
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
>>>>>>> 3271a67... 首页添加OK
=======
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
>>>>>>> fbb4942... first commit
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
<<<<<<< HEAD
<<<<<<< HEAD
</section>
=======
</div>
>>>>>>> 3271a67... 首页添加OK
=======
</div>
>>>>>>> fbb4942... first commit
