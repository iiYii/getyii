<?php

use common\models\PostTag;
use conquer\select2\Select2Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yiier\editor\EditorMdWidget;

/** @var  $model \frontend\modules\topic\models\Topic */
$model->tags = $model->tags ? explode(',', $model->tags) : '';
?>
<div class="list-group-item">

    <?php $form = ActiveForm::begin([
        'options' => [
            'autocomplete' => 'off'
        ],
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

    <?= $form->field($model, 'post_meta_id')->widget(Select2Widget::classname(), [
        'items' => ['' => '选择一个分类'] + \common\models\PostMeta::topicCategory(),
    ]); ?>

    <?= $form->field($model, 'content')->widget(EditorMdWidget::className(), [
        'options' => ['id' => 'sss'],
        'clientOptions' => [
            'placeholder' => '鼓励分享和讨论不鼓励伸手提问党。真的想提问请在提问帖内附上你曾经为了解决问题付出的行动或者分享一段小知识。',
            'imageUpload' => true,
            'autoFocus' => false,
            'imageUploadURL' => Url::to(['/site/upload', 'field' => 'editormd-image-file']),
        ]
    ]) ?>

    <?= $form->field($model, 'tags')->widget(Select2Widget::classname(), [
        'options' => [
            'multiple' => true,
            'placeholder' => '标签（可选）'
        ],
        'settings' => ['width' => '100%'],
        'items' => ArrayHelper::map(PostTag::find()->orderBy('count')->asArray()->all(), 'name', 'name'),
    ]); ?>

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

    <?php ActiveForm::end(); ?>

</div>
<?php
\frontend\assets\AtJsAsset::register($this);
?>
