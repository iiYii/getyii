<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\article\models\Article */

$this->title = '发布新文章';
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Articles'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-9 article-create">

    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <?= $this->title ?>
        </div>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>

<?= \frontend\widgets\TopicSidebar::widget([
    'type' => 'create'
])?>
