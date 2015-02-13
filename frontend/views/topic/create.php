<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;

/* @var $this yii\web\View */
/* @var $model common\Models\Post */

$this->title = '新话题';
// $this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<section class="container">

	<div class="col-sm-12 list-nav" contenteditable="false" style="">
	    <nav class="navbar navbar-default">
	    <?= Nav::widget([
            'options' => [
                'class' => 'nav navbar-nav breadcrumb',
            ],
            'items' => [
                ['label' => '社区',  'url' => ['/topic']],
                Html::tag('li', Html::encode($this->title), ['class' => 'mt15']),
            ]
        ]) ?>
	    </nav>

	    <?= $this->render('_form', [
	        'model' => $model,
	    ]) ?>
	</div>

</section>