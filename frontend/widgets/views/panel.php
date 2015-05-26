<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/18 下午4:16
 * description:
 */
use yii\helpers\Html;

?>
<?php if ($model): ?>
    <div class="panel panel-default corner-radius">
        <div class="panel-heading text-center">
            <h3 class="panel-title"><?= $model['title']?></h3>
        </div>
        <div class="panel-body side-bar">
            <ul class="list">
                <?php foreach ($model['items'] as $key => $value) {
                    echo Html::tag('li', Html::a(Html::encode($key), $value));
                } ?>
            </ul>
        </div>
    </div>
<?php endif ?>

