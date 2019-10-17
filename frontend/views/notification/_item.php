<?php
/**
 * author     : forecho <caizh@snsshop.com>
 * createTime : 2015/4/23 14:52
 * description:
 */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

?>
<?php if ($model->status && $model->post): ?>
    <div class="media-left">
        <?= Html::a(Html::img($model->fromUser->userAvatar, ['class' => 'media-object img-circle']),
            ['/user/default/show', 'username' => $model->fromUser['username']]
        ); ?>
    </div>
    <div class="media-body">
        <div class="media-heading">
            <?= Html::tag('span', Html::a($model->fromUser['username'],
                ['/user/default/show', 'username' => $model->fromUser['username']])); ?>
            <span class="info"><?= $model->getlable($model->type) ?>
                <?= Html::a(Html::encode($model->post->title), ['/topic/default/view', 'id' => $model->post_id],
                    ['title' => $model->post->title]); ?>
        <span class="date pull-right">
            <i class="fa fa-clock-o"></i>
            <?= Html::tag('abbr', Yii::$app->formatter->asRelativeTime($model->created_at),
                ['title' => Yii::$app->formatter->asDatetime($model->created_at)]) ?>
        </span>
        <?php if ($index < $notifyCount) {
            echo Html::tag('span', Yii::t('app', 'New'), ['class' => 'new label label-warning']);
        } ?>
        </div>
        <div class="summary markdown">
            <?= HtmlPurifier::process(\yii\helpers\Markdown::process($model->data, 'gfm')) ?>
        </div>
    </div>

<?php else: ?>
    <div class="media-body">
        <?= Yii::t('app', 'Data Deleted'); ?>
    </div>
<?php endif ?>

<div class="media-right opts">
    <?= Html::a(
        Html::tag('i', '', ['class' => 'fa fa-trash']),
        ['/notification/delete', 'id' => $model->id],
        [
            'data' => [
                'method' => 'post',
            ],
        ]
    ) ?>
</div>
