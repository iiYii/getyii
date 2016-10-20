<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '手册文档';

?>

<div class="manual-default-index">
    <?php foreach($model as $key => $item): ?>
        <div class="panel panel-default corner-radius" id="">
            <div class="panel-heading text-left">
                <h3 class="panel-title"><a class="text" href="<?= Url::to(['/manual/default/view/', 'manual_id'=> $item->id])?>"><?php echo $item->title; ?></a></h3>
            </div>
        </div>
    <?php endforeach ?>
</div>
