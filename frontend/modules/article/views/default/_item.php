<?php

use yii\helpers\Html;
use frontend\modules\article\models\Article;
use common\helpers\Formatter;
use kartik\icons\Icon;
Icon::map($this);
/* @var $this yii\web\View */
?>
<div class="media">

    <div class="media-left">
        <div class="tuijiian">
            <p><?=$model['like_count'] ?></p>

            <p>推荐</p>
        </div>
        <p><?=$model['view_count'] ?></p>

        <p>浏览</p>
    </div>
    <div class="media-body">

        <div class="media-heading ">
            <?= Html::a(Html::encode($model->title),
                ['/article/default/view', 'id' => $model->id], ['title' => $model->title]
            ); ?>

        </div>
        <div class="description"><?=$model['excerpt'] ?>
        </div>
        <div class="title-info">

            <?= Html::a(Html::img($model->user->userAvatar, ['class' => 'media-object']),
                ['/user/default/show', 'username' => $model->user['username']]
            ); ?>
            <?= Html::a($model->user['username'], ['/user/default/show', 'username' => $model->user['username']]).' • '.Html::tag('span', Yii::t('frontend', 'created_at {datetime}', [
            'datetime' => Formatter::relative($model->created_at) ])); ?>
        </div>
    </div>
</div>









