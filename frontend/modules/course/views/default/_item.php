<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

print_r($model);
?>

<div class="col s6">
			<div class="card small">
              <div class="card-image">
                <img src="<?=Html::encode($model->image)?>">
                <span class="card-title"><?=Html::encode($model->title)?></span>
              </div>
              <div class="card-content">
                <p><?=Html::encode($model->title)?></p>
              </div>
              <div class="card-action">
                <a href="#">This is a link</a>
                <a href="#">This is a link</a>
              </div>
            </div>
</div>