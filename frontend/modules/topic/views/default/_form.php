<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;
use dosamigos\selectize\SelectizeTextInput;
use kartik\select2\Select2;
use yiier\editor\EditorMdWidget;

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
            'options' => ['placeholder' => '请选择所在节点'],
            'pluginOptions' => [
                'allowClear' => true,
                'height' => '343%',
            ],
        ]);
        ?>

        <?= $this->render('@frontend/views/partials/markdwon_help') ?>

        <?= $form->field($model, 'content')->widget(EditorMdWidget::className(), [
                'options'=>[// html attributes
                    'id'=>'content'
                ],
                'clientOptions' => [
                    'height' => '640',
                    // 'previewTheme' => 'dark',
                    // 'editorTheme' => 'pastel-on-dark',
                    'markdown' => '',
                    'codeFold' => true,
                    'syncScrolling' => false,
                    'saveHTMLToTextarea' => true,    // 保存 HTML 到 Textarea
                    'searchReplace' => true,
                    // 'watch' => false, // 关闭实时预览
                    'htmlDecode' => 'style,script,iframe|on*',            // 开启 HTML 标签解析，为了安全性，默认不开启
                    'toolbar ' => false,             //关闭工具栏
                    'previewCodeHighlight' => false, // 关闭预览 HTML 的代码块高亮，默认开启
                    'emoji' => true,
                    'taskList' => true,
                    'tocm           ' => true,         // Using [TOCM]
                    'tex' => true,    // 开启科学公式TeX语言支持，默认关闭
                    'flowChart' => true,             // 开启流程图支持，默认关闭
                    'sequenceDiagram' => true,       // 开启时序/序列图支持，默认关闭,
                    // 'dialogLockScreen' => false,   // 设置弹出层对话框不锁屏，全局通用，默认为true
                    // 'dialogShowMask' => false,     // 设置弹出层对话框显示透明遮罩层，全局通用，默认为true
                    // 'dialogDraggable' => false,    // 设置弹出层对话框不可拖动，全局通用，默认为true
                    // 'dialogMaskOpacity' => 0.4,    // 设置透明遮罩层的透明度，全局通用，默认值为0.1
                    // 'dialogMaskBgColor' => '#000', // 设置透明遮罩层的背景颜色，全局通用，默认为#fff
                    'imageUpload' => true,
                    'imageFormats' => ['jpg', 'jpeg', 'gif', 'png', 'bmp'],
                    'imageUploadURL' => "/site/upload",
                ]
            ]
        ) ?>



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
            <?= $form->field($model, 'cc')->checkbox() ?>
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
<?php
\frontend\assets\AtJsAsset::register($this);
?>
