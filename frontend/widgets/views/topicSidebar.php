<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/18 下午4:16
 * description:
 */
use yii\helpers\Html;

?>
<div class="col-md-2 side-bar p0">

    <div class="panel panel-default corner-radius">

        <?php if ($config['node']): ?>
            <div class="panel-heading text-center">
                <h3 class="panel-title">{{{ $node->name }}}</h3>
            </div>
        <?php endif ?>

        <div class="panel-body text-center">
            <div class="btn-group">
                <?= Html::a(
                    \Yii::t('app', 'New Topic'),
                    ['/topic/default/create', 'id' => 'id'],
                    ['class' => 'btn btn-success']
                ) ?>
            </div>
        </div>
    </div>

    <?php if (!empty($links)): ?>
        <div class="panel panel-default corner-radius">
            <div class="panel-heading text-center">
                <h3 class="panel-title"><?= \Yii::t('app', 'Links')?></h3>
            </div>
            <div class="panel-body text-center" style="padding-top: 5px;">
                <?php foreach ($links as $key => $value) {
                    echo Html::a(
                        Html::img($value->cover),
                        $value->link,
                        ['target' => '_blank', 'title' => $value->title]
                    );
                } ?>
            </div>
        </div>
    <?php endif ?>

    <?= \frontend\widgets\Panel::widget([
        'title' => \Yii::t('app', 'Recomended Resources'),
        'items' => [],
    ])?>

    <?= \frontend\widgets\Panel::widget([
        'title' => \Yii::t('app', 'Same Node Topics'),
        'items' => [],
    ])?>

    <div class="panel panel-default corner-radius">
        <div class="panel-heading text-center">
            <h3 class="panel-title"><?= \Yii::t('app', 'Tips and Tricks');?></h3>
        </div>
        <div class="panel-body">
            {{ $siteTip->body }}
        </div>
    </div>

    <?= \frontend\widgets\Panel::widget([
        'title' => \Yii::t('app', 'Site Status'),
        'items' => [],
    ])?>


</div>
<div class="clearfix"></div>
