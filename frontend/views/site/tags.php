<?php
use yii\helpers\Html;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
$this->title = '标签云';
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?= $this->title; ?>
    </div>
    <div class="panel-body tag-cloud">
        <?php foreach ($tags as $tag) {
            $i = (int)($tag->count / 3);
            echo Html::a($tag->name, ['/topic/default/index', 'tag' => $tag->name], ['class' => 'cloud-' . $i]);
        } ?>
    </div>
</div>