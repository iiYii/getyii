<?php
/**
 * @Author: forecho
 * @Date:   2015-01-29 23:01:08
 * @Last Modified by:   forecho
 * @Last Modified time: 2015-01-30 22:32:57
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserSettingForm */
/* @var $form ActiveForm */

$this->title = 'Users';
// $this->params['breadcrumbs'][] = $this->title;
?>
<section class="container user-index">
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'profile-form',
                    'options' => ['class' => 'form-horizontal'],
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
                        'labelOptions' => ['class' => 'col-lg-3 control-label'],
                    ],
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                    'validateOnBlur'         => false,
                ]); ?>

                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'info')->textarea(['rows' => 6]) ?>

                <?php // $form->field($model, 'website') ?>

                <?php // $form->field($model, 'location') ?>

                <?php // $form->field($model, 'gravatar_email')->hint(\yii\helpers\Html::a(Yii::t('user', 'Change your avatar at Gravatar.com'), 'http://gravatar.com')) ?>

                <?php // $form->field($model, 'bio')->textarea() ?>

                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?><br>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

</section>
