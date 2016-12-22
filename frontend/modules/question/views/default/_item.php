<?php

use yii\helpers\Html;
use frontend\modules\topic\models\Topic;
use common\helpers\Formatter;
use kartik\icons\Icon;
Icon::map($this);
/* @var $this yii\web\View */
?>
<div class="media">


    <div class="media-left">
        <div class="answer">
            <p><?=$model['comment_count'] ?></p>

            <p>回答</p>
        </div>
        <div class="views">
            <p><?=$model['view_count'] ?></p>

            <p>浏览</p>
        </div>
    </div>
    <div class="media-body">

        <div class="media-heading">
            <?= Html::a(Html::encode($model->title),
                ['/question/default/view', 'id' => $model->id], ['title' => $model->title]
            ); ?>


        </div>

        <div class="title-info">
            <?php echo
            Html::a(Html::img($model->user->userAvatar, ['class' => 'media-object']),
                ['/user/default/show', 'username' => $model->user['username']]
            ).
            Html::a(
                $model->user['username'],
                ['/user/default/show', 'username' => $model->user['username']]
            ).

            Html::a(
                $model->category->name,
                ['/topic/default/index', 'node' => $model->category->alias],
                ['class' => 'node']
            ). ' • ';

            if ($model->last_comment_username) {
                echo Html::tag('span',
                    Yii::t('frontend', 'last_by') .
                    Html::a(
                        ' ' . $model->last_comment_username . ' ',
                        ['/user/default/show', 'username' => $model->last_comment_username]) .
                    Yii::t('frontend', 'reply_at {datetime}', [
                        'datetime' => Formatter::relative($model->last_comment_time)
                    ])
                );
            } else {
                echo Html::tag('span',
                    Yii::t('frontend', 'created_at {datetime}', [
                        'datetime' => Formatter::relative($model->created_at)
                    ])
                );
            }

            ?>
        </div>
    </div>
</div>
