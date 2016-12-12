<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;
use dosamigos\selectize\SelectizeTextInput;
use kartik\select2\Select2;

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