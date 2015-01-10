<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use frontend\widgets\PostRight;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blog';
$this->params['breadcrumbs'][] = $this->title;
?>

<section id="blog" class="container">
    <div class="row">

        <?= PostRight::widget(); ?>

        <div class="col-sm-8 col-sm-pull-4">
            <div class="blog">
                <?php Pjax::begin(); ?>
                <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemOptions' => ['class' => 'item'],
                    'summary' => false,
                    'itemView' => '_post',
                    'pager' => [
                        'options' => ['class'=>'pagination pagination-lg'],
                        'prevPageLabel' => '<i class="icon-angle-left"></i>',
                        'nextPageLabel' => '<i class="icon-angle-right"></i>',
                    ]
                ]) ?>
                <?php Pjax::end(); ?>
            </div>
        </div><!--/.col-md-8-->
    </div><!--/.row-->
</section><!--/#blog-->