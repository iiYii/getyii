<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

?>

<div class="col s12 m4">
			<div class="card small">
              <div class="card-image">
                <?= Html::a(Html::img($model->image),
                                      ['/course/default/view', 'id' => $model->id],['title' =>$model->title]
                  );?>
              </div>
              <div class="card-content">
                <p><?=Html::encode($model->excerpt)?></p>
              </div>
              <div class="card-action">
                    <?= Html::a(Html::encode($model->title),
                                        ['/course/default/view', 'id' => $model->id],['title' =>$model->title]);?>
              </div>
            </div>
</div>