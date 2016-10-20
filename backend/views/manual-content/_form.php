<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\markdown\MarkdownEditor;

/* @var $this yii\web\View */
/* @var $model common\models\ManualContent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="manual-content-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'manual_id')->dropDownList(\common\models\Manual::getAll(),
        [
            'prompt' => Yii::t('app', 'Please Select'),
            'onchange' => '
            $.post( "'.Yii::$app->urlManager->createUrl('region/ajax-list-child?id=').'"+$(this).val(),function(data){
                $("select#manualcontent-parent_id").html(data);
            });
            ',
        ]
    ) ?>

    <?= $form->field($model, 'parent_id')->dropDownList(\common\models\ManualContent::getAll(),['prompt' => YIi::t('app','Please Select') ]) ?>


    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?=  MarkdownEditor::widget([
        'model' => $model,
        'attribute' => 'content',
    ]); ?>



    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'sort_order')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ 'Y' => 'Y', 'N' => 'N', 'H' => 'H', ], ['prompt' => '']) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
