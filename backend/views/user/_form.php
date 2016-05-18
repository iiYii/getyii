<?php

use common\models\User;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'role')->widget(Select2::classname(), [
        'data' => User::getRoleList(),
        'options' => ['placeholder' => '选择一个权限',  'hideSearch' => true,],
    ]);
    ?>

    <?= $form->field($model, 'status')->widget(Select2::classname(), [
        'data' => User::getStatusList(),
        'options' => ['placeholder' => '选择一个状态',  'hideSearch' => true,],
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
