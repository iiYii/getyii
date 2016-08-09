<?php
/**
 * author     : forecho <caizh@chexiu.cn>
 * createTime : 2016/4/19 14:44
 * description:
 */
use yii\helpers\Html;
/** @var \yii\base\Object $model */
/** @var \common\models\User $value */
?>

<?php foreach ($model as $key => $value): ?>
    <div class="col-xs-2" style="min-width: 100px;">
        <div class="media user-card">
            <div class="media-left">
                <?= Html::a(Html::img($value->userAvatar, ['class' => 'media-object']),
                    ['/user/default/show', 'username' => $value['username']],
                    ['title' => $value['username']]
                ); ?>
            </div>
            <div class="media-body">
                <div class="media-heading">
                    <?= Html::a(
                        \yii\helpers\StringHelper::byteSubstr($value['username'], 0, 10),
                        ['/user/default/show', 'username' => $value['username']],
                        ['title' => $value['username']]
                    ); ?>
                </div>
                <div class="">
                    积分：<?= $value->merit ? $value->merit->merit : 0 ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
