<?php

use common\models\User;
use conquer\select2\Select2Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'role')->widget(Select2Widget::classname(), [
        'items' => ['' => '选择一个权限'] + User::getRoleList(),
    ]); ?>

    <?= $form->field($model, 'status')->widget(Select2Widget::classname(), [
        'items' => ['' => '选择一个状态'] + User::getStatusList(),
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
