<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

\frontend\assets\AtJsAsset::register($this);
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
        'placeholder' => t('app', 'Tweet Content'),
        'id' => 'md-input',
        'data-at-topic' => true,
        'rows' => 5
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('发布', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <div class="pull-right">
            <?= Html::a('排版说明', ['/site/markdown'], ['target' => '_blank']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>