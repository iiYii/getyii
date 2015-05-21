<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/20 下午9:15
 * description:
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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

    <?= $this->render('@frontend/views/partials/markdwon_help') ?>

    <?= $form->field($model, 'comment', [
        'selectors' => [
            'input' => '#md-input'
        ],
    ])->textarea([
        'placeholder' => '内容',
        'id' => 'md-input',
        'disabled' => Yii::$app->user->getIsGuest(),
        'rows'        => 6
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? '创建评论' : '修改评论',
            [
                'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            ]
        ) ?>
    </div>

    <div id="md-preview"></div>

    <?php ActiveForm::end(); ?>

</div>