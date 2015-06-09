<?php
    
    use yii\helpsers\Html;
    use yii\widgets\ListView;
    use yii\widgets\Pjax;
    
    
    $this->title = '课程';
    
?>

<div class="container">
    <div class="row">
            <?php Pjax::begin();?>
            
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'list-group-item'],
                'summary' => false,
                'itemView' => '_item',
                'options' => ['class' => 'list-group'],
            ]);
            ?>
            
            <?php Pjax::end();?>
    </div>
</div>