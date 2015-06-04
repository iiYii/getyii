<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

?>

<div class="col s12 m4">
			<div class="card small">
              <div class="card-image">
                <a href="">
                  <img src="<?=Html::encode($model->image)?>">
                </a>
                <span class="card-title"><?=Html::encode($model->title)?></span>
              </div>
              <div class="card-content">
                <p><?=Html::encode($model->excerpt)?></p>
              </div>
              <div class="card-action">
                <a href="#">This is a link</a>
                <a href="#">This is a link</a>
              </div>
            </div>
</div>