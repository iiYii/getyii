<?php
/**
 * @Author: forecho
 * @Date:   2015-01-29 23:23:12
 * @Last Modified by:   forecho
 * @Last Modified time: 2015-01-30 22:56:49
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use bupy7\cropbox\Cropbox;

$this->title = Yii::t('app', 'Avatar');
?>

<section class="container" xmlns="http://www.w3.org/1999/html">
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
                    'id'          => 'account-form',
                    'options'     => ['enctype' => 'multipart/form-data'],
                ]); ?>
                <?= Html::img($model->user->getUserAvatar(200)); ?>
                <?= Html::img($model->user->getUserAvatar(50)); ?>
                <?= Html::img($model->user->getUserAvatar(24)); ?>
                <br>
                <br>
                <?= $form->field($model, 'avatar')->fileInput(); ?>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('yii', 'Update'), ['class' => 'btn btn-success']) ?><br>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section>
