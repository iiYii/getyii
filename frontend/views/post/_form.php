<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\PostMeta;
use frontend\assets\PageDownAsset;
use frontend\assets\SelectizeAsset;

/* @var $this yii\web\View */
/* @var $model common\Models\Post */
/* @var $form yii\widgets\ActiveForm */

PageDownAsset::register($this);
SelectizeAsset::register($this);
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

    <?= Html::textInput('tags', '', [
        'id' => 'topicTags',
        'maxlength' => 255,
        'placeholder' => '请点击选择标签',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <div id="wmd-preview" class="wmd-panel wmd-preview"></div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$tagSearchApiUrl = Url::to(['/post-tag/index', 'name' => '{name}']);
$script = <<<EOF
    var topicConverter = Markdown.getSanitizingConverter();
        topicEditor = new Markdown.Editor(topicConverter);
    topicEditor.run();
    $('#topicTags').selectize({
        valueField: 'name',
        labelField: 'name',
        searchField: 'name',
        plugins: ['remove_button'],
        maxItems: 5,
        persist: false,
        create: true,
        createFilter: function(value) {
            return !this.options.hasOwnProperty(value);
        },
        render: {
            option: function(item, escape) {
                return '<div>' +
                    (item.icon ? '<img srt="' + item.icon + '"/>' : '') +
                    '<strong>' + escape(item.name) + '</strong>' +
                '</div>';
            }
        },
        load: function(query, callback) {
            query = $.trim(query);
            if (!query.length) return callback();
            $.ajax({
                url: ('{$tagSearchApiUrl}').replace(encodeURIComponent('{name}'), encodeURIComponent(query)),
                type: 'GET',
                error: function() {
                    callback();
                },
                success: function(res) {
                    res.type == 'success' ? callback(res.message) : callback();
                }
            });
        },
    });
EOF;
$this->registerJs($script);