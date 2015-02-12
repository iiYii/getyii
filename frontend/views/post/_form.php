<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\PostMeta;
use common\models\PostTag;
use frontend\assets\PageDownAsset;
use dosamigos\selectize\Selectize;
use yii\web\JsExpression;
use app\models\Product;

PageDownAsset::register($this);
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
        'maxlength' => 255,
        'placeholder' => '标题'
    ]) ?>

    <?= $form->field($model, 'post_meta_id')->dropDownList(
        ArrayHelper::map(PostMeta::find()->all(), 'id', 'name'),
        ['prompt'=>'选择一个分类']
    ) ?>

    <div class="wmd-panel">
        <div id="wmd-button-bar"></div>
        <?= $form->field($model, 'content', [
            'selectors' => [
                'input' => '#wmd-input'
            ],
        ])->textarea([
                'id' => 'wmd-input',
                'class' => 'form-control input-lg wmd-input',
                'placeholder' => '内容',
                'rows' => 10
            ]) ?>
    </div>

    <?= Selectize::widget([
         'name' => 'Post[tags]',
         // 'items' => ArrayHelper::map(PostTag::find()->all(), 'id', 'name'),
         'value' => $model->tags,
         'url' => ['/post-tag/index'],
         'clientOptions' => [
            'allowEmptyOption' => false,
            'delimiter' => ',',
            'valueField' => 'name',
            'labelField' => 'name',
            'searchField' => 'name',
            'maxItems' => 5,
            'plugins' => ['remove_button'],
            'persist' => false,
            'create' => true,
         ],
     ]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <div id="wmd-preview" class="wmd-panel wmd-preview"></div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$script = <<<EOF
    var topicConverter = Markdown.getSanitizingConverter();
        topicEditor = new Markdown.Editor(topicConverter);
    topicEditor.run();
EOF;
$this->registerJs($script);