<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\PostMeta;
use common\models\PostTag;
use yii\web\JsExpression;
use app\models\Product;

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

    <?= $this->render('@frontend/views/partials/markdwon_help') ?>

    <?= $form->field($model, 'content', [
        'selectors' => [
            'input' => '#md-input'
        ],
    ])->textarea([
        'placeholder' => '内容',
        'id' => 'md-input',
        'rows'        => 10
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建话题' : '修改话题', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <div id="md-preview"></div>

    <?php ActiveForm::end(); ?>

</div>