<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blog';
$this->params['breadcrumbs'][] = $this->title;
?>

<section id="blog" class="container">
    <div class="row">
        <aside class="col-sm-4 col-sm-push-8">
            <div class="widget search">
                <?php $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
                    'fieldConfig' => [
                        'template' => "{input}\n{hint}"
                    ]
                ]); ?>
                    <div class="input-group">
                        <?= $form->field($searchModel, 'title')->textInput([
                            'class' => 'form-control',
                            'autocomplete' => 'off',
                            'placeholder' => 'Search'
                        ]) ?>
                        <span class="input-group-btn">
                            <?= Html::submitButton('<i class="icon-search"></i>', ['class' => 'btn btn-danger']) ?>
                        </span>
                    </div>
                <?php ActiveForm::end(); ?>
            </div><!--/.search-->

            <div class="widget ads">
                <div class="row">
                    <div class="col-xs-6">
                        <a href="#"><img class="img-responsive img-rounded" src="images/ads/ad1.png" alt=""></a>
                    </div>

                    <div class="col-xs-6">
                        <a href="#"><img class="img-responsive img-rounded" src="images/ads/ad2.png" alt=""></a>
                    </div>
                </div>
                <p> </p>
                <div class="row">
                    <div class="col-xs-6">
                        <a href="#"><img class="img-responsive img-rounded" src="images/ads/ad3.png" alt=""></a>
                    </div>

                    <div class="col-xs-6">
                        <a href="#"><img class="img-responsive img-rounded" src="images/ads/ad4.png" alt=""></a>
                    </div>
                </div>
            </div><!--/.ads-->

            <div class="widget categories">
                <h3>Blog Categories</h3>
                <div class="row">
                    <div class="col-sm-6">
                        <ul class="arrow">
                            <?php foreach ($category as $key => $value): ?>
                                <li><?= Html::a(Html::encode($value->name), ['/post/index', 'PostSearch[post_meta_id]' => $value->id]);?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                    <!-- <div class="col-sm-6">
                        <ul class="arrow">
                            <li><a href="#">Joomla</a></li>
                            <li><a href="#">Wordpress</a></li>
                            <li><a href="#">Drupal</a></li>
                            <li><a href="#">Magento</a></li>
                            <li><a href="#">Bootstrap</a></li>
                        </ul>
                    </div> -->
                </div>
            </div><!--/.categories-->
            <div class="widget tags">
                <h3>Tag Cloud</h3>
                <ul class="tag-cloud">
                    <?php foreach ($tags as $key => $value): ?>
                        <li><?= Html::a(
                            Html::encode($value->name),
                            ['/post/index', 'PostSearch[post_meta_id]' => $value->id],
                            ['class' => 'btn btn-xs btn-primary']
                        );?></li>
                    <?php endforeach ?>
                </ul>
            </div><!--/.tags-->
        </aside>
        <div class="col-sm-8 col-sm-pull-4">
            <div class="blog">
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
            </div>
        </div><!--/.col-md-8-->
    </div><!--/.row-->
</section><!--/#blog-->