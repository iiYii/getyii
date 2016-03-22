<?php
/**
 * @Author: forecho
 * @Date:   2015-01-29 23:23:12
 * @Last Modified by:   forecho
 * @Last Modified time: 2015-01-30 22:56:49
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Donate');
/** @var \frontend\modules\user\models\Donate $model */
?>

<section class="container">
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
                        'labelOptions' => ['class' => 'col-lg-3 control-label'],
                    ],
                ]); ?>

                <?php if ($model->qr_code): ?>
                    <div class="form-group">
                        <div class="col-lg-offset-3 col-lg-9">
                            <?= Html::img(Yii::$app->params['qrCodeUrl'] . $model->qr_code, ['class' => 'img']) ?>
                        </div>
                    </div>
                <?php endif ?>
                <?= $form->field($model, 'qr_code')->fileInput(); ?><br>

                <?= $form->field($model, 'status')->dropDownList(\frontend\modules\user\models\Donate::getStatuses()) ?>

                <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>

                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?><br>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section>
