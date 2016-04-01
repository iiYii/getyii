<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;
use dosamigos\selectize\SelectizeTextInput;
use kartik\select2\Select2;

\frontend\assets\AtJsAsset::register($this);
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

    <?= $form->field($model, 'post_meta_id')->widget(Select2::classname(), [
        'data' => \common\models\PostMeta::topicCategory(),
        'options' => ['placeholder' => '选择一个分类'],
        'pluginOptions' => [
            'allowClear' => true,
            'height' => '343%'
        ],
    ]);
    ?>

    <?= $this->render('@frontend/views/partials/markdwon_help') ?>

    <div class="opts pull-right">
    <span class="dropdown dropdown-small" id="editor-toolbar-insert-code">
        <a href="#editor-toolbar-insert-code" data-toggle="dropdown" title="插入代码" aria-expanded="false">
            <i class="fa fa-code"></i>
        </a>
        <ul class="dropdown-menu insert-codes" role="menu">
            <li><a data-lang="php" href="#">PHP</a></li>
            <li><a data-lang="html" href="#">HTML</a></li>
            <li><a data-lang="scss" href="#">CSS / SCSS</a></li>
            <li><a data-lang="js" href="#">JavaScript</a></li>
            <li><a data-lang="yml" href="#">YAML <i>(.yml)</i></a></li>
            <li><a data-lang="coffee" href="#">CoffeeScript</a></li>
            <li><a data-lang="conf" href="#">Nginx / Redis <i>(.conf)</i></a></li>
            <li><a data-lang="python" href="#">Python</a></li>
            <li><a data-lang="java" href="#">Java</a></li>
            <li><a data-lang="erlang" href="#">Erlang</a></li>
            <li><a data-lang="shell" href="#">Shell / Bash</a></li>
        </ul>
    </span>
<!--        <a id="topic-upload-image" rel="twipsy" title="" href="#" data-original-title="上传图片">-->
<!--            <i class="fa fa-fa fa-image"></i>-->
<!--        </a>-->
    </div>

    <div class="form-group" id="editor">
        <?= $form->field($model, 'content')->widget(
            'trntv\aceeditor\AceEditor',
            [
                'id' => 'markdown',
                'mode' => 'markdown',
                'containerOptions' => [
                    'style' => 'width: 100%; min-height: 350px'
                ],
                'theme' => 'github'
            ]
        ) ?>
    </div>

    <?= SelectizeTextInput::widget([
        'name' => 'Topic[tags]',
        'value' => $model->tags,
        'loadUrl' => ['/post-tag/index'],
        'clientOptions' => [
            'placeholder' => '标签（可选）',
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
        <?= $form->field($model, 'cc')->checkbox()  ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? '创建话题' : '修改话题',
            [
                'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            ]
        ) ?>

        <div class="pull-right">
            <?= Html::a('排版说明', ['/site/markdown'], ['target' => '_blank']) ?>
        </div>
    </div>

    <div id="md-preview" class="pt10">
        <?= HtmlPurifier::process(\yii\helpers\Markdown::process($model->content, 'gfm')) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>