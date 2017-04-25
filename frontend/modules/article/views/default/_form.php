<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;
use dosamigos\selectize\SelectizeTextInput;
use kartik\select2\Select2;
use yiier\editor\EditorMdWidget;

/* @var $this yii\web\View */
/* @var $model frontend\modules\article\models\Article */
/* @var $form yii\widgets\ActiveForm */
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
            'placeholder' => '文章标题'
        ]) ?>

        <?= $form->field($model, 'post_meta_id')->widget(Select2::classname(), [
            'data' => \common\models\PostMeta::articleCategory(),
            'options' => ['placeholder' => '请选择所在节点'],
            'pluginOptions' => [
                'allowClear' => true,
                'height' => '343%',
            ],
        ]);
        ?>

        <?= $form->field($model, 'excerpt')->textarea([
            'maxlength' => 255,
            'rows'=>3,
            'placeholder' => '文章摘要'
        ]) ?>

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

        <!--
        <div class="form-group" id="editor">
            <?php echo $form->field($model,'content')->widget('kucha\ueditor\UEditor',[
                'clientOptions' => [
                    //编辑区域大小
                    'initialFrameHeight' => '450',
                    //设置语言
                    'lang' =>'zh-cn', //中文为 zh-cn
                    //定制菜单
                    'toolbars' => [
                        [
                            'fullscreen', 'source', 'undo', 'redo', '|',
                            'fontsize','insertcode','simpleupload','link',
                            'bold', 'italic', 'horizontal','underline', 'fontborder', 'strikethrough', 'removeformat',
                            'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|',
                            'forecolor', 'backcolor', '|',
                            'lineheight', '|',
                            'indent', '|'
                        ],
                    ]
                    ]
            ]); ?>
        </div>
        -->


        <div class="form-group">
            <?= $form->field($model, 'cc')->checkbox() ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton(
                $model->isNewRecord ? '发布文章' : '修改文章',
                [
                    'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                ]
            ) ?>

        </div>


        <?php ActiveForm::end(); ?>

    </div>
<?php
\frontend\assets\AtJsAsset::register($this);
?>