<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\PostMeta;
use common\models\PostTag;
use dosamigos\selectize\SelectizeTextInput;
use app\models\Product;

// Selectize::$theme ='dosamigos\selectize\SelectizeAsset';
?>
<div class="post-form">
    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => "{input}\n{hint}\n{error}"
        ]
    ]); ?>

    <?= $form->errorSummary($model, [
        'class' => 'alert alert-danger'
    ]) ?>

    <?= $form->field($model, 'title')->textInput([
        'maxlength'   => 255,
        'placeholder' => '标题'
    ]) ?>

    <?= $form->field($model, 'post_meta_id')->dropDownList(
        PostMeta::blogCategory(),
        ['prompt' => '选择一个分类']
    ) ?>

    <?= $this->render('/partials/markdwon_help') ?>

    <?= $form->field($model, 'content', [
        'selectors' => [
            'input' => '#md-input'
        ],
    ])->textarea([
        'placeholder' => '内容',
        'id' => 'md-input',
        'rows'        => 10
    ]) ?>

    <?= SelectizeTextInput::widget([
        'name'          => 'Post[tags]',
        'value'         => $model->tags,
        'loadUrl' => ['/post-tag/index'],
        'clientOptions' => [
            'allowEmptyOption' => false,
            'delimiter'        => ',',
            'valueField'       => 'name',
            'labelField'       => 'name',
            'searchField'      => 'name',
            'maxItems'         => 5,
            'plugins'          => ['remove_button'],
            'persist'          => false,
            'create'           => true,
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <div id="md-preview"></div>

    <?php ActiveForm::end(); ?>

</div>
