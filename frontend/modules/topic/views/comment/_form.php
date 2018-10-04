<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/20 下午9:15
 * description:
 */

use common\widgets\JsBlock;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yiier\editor\EditorMdWidget;

\frontend\assets\AtJsAsset::register($this);
?>
<div class="list-group-item">

    <?php if (Yii::$app->user->isGuest): ?>
        <div style="padding:20px;" data-turbolinks-action="replace">
            需要 <a class="btn btn-primary" href="<?= Url::to(['/site/login']) ?>">登录</a> 后方可回复,
            如果你还没有账号请点击这里 <a class="btn btn-danger" href="<?= Url::to(['/site/signup']) ?>">注册</a>。
        </div>
    <?php else: ?>

    <?php $form = ActiveForm::begin([
        'action' => [
            $model->isNewRecord ? '/topic/comment/create' : '/topic/comment/update',
            'id' => Yii::$app->request->getQueryParam('id')],
        'fieldConfig' => [
            'template' => "{input}\n{hint}\n{error}"
        ]
    ]); ?>

    <?= $form->field($model, 'comment')->widget(EditorMdWidget::className(), [
        'clientOptions' => [	
            'height' => 200,	
            'imageUpload' => true,	
            'autoFocus' => false,
            'placeholder' => '请尽量让自己的回复能够对别人有帮助',	
            'imageUploadURL' => Url::to(['/site/upload', 'field' => 'editormd-image-file']),	
        ]	
    ]) ?>

        <div class="form-group">
            <?= Html::submitButton(
                $model->isNewRecord ? '创建回复' : '修改回复',
                [
                    'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                ]
            ) ?>

            <div class="pull-right">
                <?= Html::a('排版说明', ['/site/markdown'], ['target' => '_blank']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
    <?php JsBlock::begin(['pos' => \yii\web\View::POS_READY]) ?>
        <script>
            $(document).on('click', '.btn-reply', function (e) {
                e.preventDefault();
                var username = $(this).data('username');
                var floor = $(this).data('floor');
                var prefix = "@" + username + " #" + floor + "楼 ";
                editor.insertValue(prefix);
                editor.focus();
            });
        </script>
        <?php JsBlock::end() ?>
    <?php endif ?>
</div>
