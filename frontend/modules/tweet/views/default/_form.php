<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

\frontend\assets\AtJsAsset::register($this);
?>
<div class="list-group-item">

    <?php $form = ActiveForm::begin([
        'action' => '/tweet/default/create',
        'fieldConfig' => [
            'template' => "{input}\n{hint}\n{error}"
        ]
    ]); ?>

    <?= $form->field($model, 'content', [
        'selectors' => [
            'input' => '#md-input'
        ],
        ])->textarea([
            'placeholder' => '在这里，您可以发表数据库、运维、开发等技术相关的最新快讯、心得技巧，也可以发表您在生活工作中的趣事、有趣段子，在发布时通过使用@功能将内容通知其他用户阅读。在这里，禁止发表违法国家政策和法律法规的言论，禁止发表毫无意义的内容和无聊话题。',
            'id' => 'md-input',
            'rows' => 5
        ]) ?>


    <div class="form-group">
        <?= Html::submitButton('发布', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <div class="pull-right">
            <?= Html::a('排版说明', ['/site/markdown'], ['target' => '_blank']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>