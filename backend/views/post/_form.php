<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\Models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'post_meta_id')->textInput(['maxlength' => 11]) ?>

    <?= $form->field($model, 'user_id')->textInput(['maxlength' => 11]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'excerpt')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'image')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tags')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'view_count')->textInput(['maxlength' => 11]) ?>

    <?= $form->field($model, 'comment_count')->textInput(['maxlength' => 11]) ?>

    <?= $form->field($model, 'favorite_count')->textInput(['maxlength' => 11]) ?>

    <?= $form->field($model, 'like_count')->textInput(['maxlength' => 11]) ?>

    <?= $form->field($model, 'hate_count')->textInput(['maxlength' => 11]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'order')->textInput(['maxlength' => 11]) ?>

    <?= $form->field($model, 'created_at')->textInput(['maxlength' => 11]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['maxlength' => 11]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
