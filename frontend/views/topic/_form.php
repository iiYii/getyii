<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\PostMeta;
use common\models\PostTag;
use frontend\assets\PageDownAsset;
use yii\web\JsExpression;
use app\models\Product;

PageDownAsset::register($this);
?>
<div class="list-group-item">

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
        PostMeta::topicCategory(),
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

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建话题' : '修改话题', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
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