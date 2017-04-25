<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/18 下午4:16
 * description:
 */
use yii\helpers\Html;

?>
<?php if ($model): ?>
    <div class="panel panel-default corner-radius side-bar">
        <div class="panel-heading text-center">
            <h3 class="panel-title"><?= $model['title']?></h3>
        </div>
        <div class="panel-body">
            <?php $num=1;
            foreach ($model['items'] as $key => $value) { ?>
            <div class="list">
                <div class="pull-left media-left">
                    <span class="sort sort-<?=$num; ?>"><?=$num; ?></span>
                </div>
                <div class="media-right">
                    <?=Html::a(Html::encode($key), $value)?>
                </div>
            </div>
            <?php
            $num = $num+1;
            } ?>
        </div>
    </div>
<?php endif ?>

