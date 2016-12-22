<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;
use dosamigos\selectize\SelectizeTextInput;
use kartik\select2\Select2;

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
            'placeholder' => '请准确的描述你遇到的问题，以问号结束。'
        ]) ?>

        <?= $form->field($model, 'post_meta_id')->widget(Select2::classname(), [
            'data' => \common\models\PostMeta::topicCategory(),
            'options' => ['placeholder' => '请选择问题所在节点'],
            'pluginOptions' => [
                'allowClear' => true,
                'height' => '343%',
            ],
        ]);
        ?>
        <h3>问题补充说明(选填：如果标题已经清晰的说明问题的话，可以留空)</h3>
        <hr/>
        <div class="form-group" id="editor">
            <?php echo $form->field($model,'content')->widget('kucha\ueditor\UEditor',[
                'clientOptions' => [
                    //编辑区域大小
                    'initialFrameHeight' => '300',
                    //设置语言
                    'lang' =>'zh-cn', //中文为 zh-cn
                    //定制菜单
                    'toolbars' => [
                        [
                            'source', 'insertcode','simpleupload','strikethrough',
                            'bold', 'italic',  'removeformat', 'blockquote', 'pasteplain',

                        ],
                    ]
                ]
            ]); ?>
        </div>

        <?= SelectizeTextInput::widget([
            'name' => 'Question[tags]',
            'value' => $model->tags,
            'loadUrl' => ['/post-tag/index'],
            'clientOptions' => [
                'placeholder' => '问题标签（可选）',
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


        <div class="form-group mt15">
            <?= Html::submitButton(
                $model->isNewRecord ? '提交问题' : '修改问题',
                [
                    'class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-danger',
                ]
            ) ?>

        </div>


        <?php ActiveForm::end(); ?>

    </div>
<?php
\frontend\assets\AtJsAsset::register($this);
?>
