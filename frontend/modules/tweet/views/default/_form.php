<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="list-group-item">

    <?php $form = ActiveForm::begin([
        'action' => '/tweet/default/create',
        'fieldConfig' => [
            'template' => "{input}\n{hint}\n{error}"
        ]
    ]); ?>

    <?= $form->field($model, 'content', [
        'selectors' => [
            'input' => '#md-input'
        ],
        ])->textarea([
            'placeholder' => '内容',
            'id' => 'md-input',
            'rows' => 5
        ]) ?>


    <div class="form-group">
        <?= Html::submitButton('发布', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>