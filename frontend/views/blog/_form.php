<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\PostMeta;
use dosamigos\selectize\SelectizeDropDownList;
use app\models\Product;

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
        'maxlength'   => 255,
        'placeholder' => '标题'
    ]) ?>

    <?= $form->field($model, 'post_meta_id')->dropDownList(
        PostMeta::blogCategory(),
        ['prompt' => '选择一个分类']
    ) ?>

    <?= $form->field($model, 'content')->textarea([
        'placeholder' => '内容',
        'rows'        => 10
    ]) ?>

    <?= SelectizeDropDownList::widget([
        'name'          => 'Post[tags]',
        // 'items' => ArrayHelper::map(PostTag::find()->all(), 'id', 'name'),
        'value'         => $model->tags,
        //'url' => ['/post-tag/index'],
        'clientOptions' => [
            'allowEmptyOption' => false,
            'delimiter'        => ',',
            'valueField'       => 'name',
            'labelField'       => 'name',
            'searchField'      => 'name',
            'maxItems'         => 5,
            'plugins'          => ['remove_button'],
            'persist'          => false,
            'create'           => true,
        ],
    ]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <div id="preview-box"></div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<<EOF
// hljs.initHighlightingOnLoad();
EOF;
$this->registerJs($script);

