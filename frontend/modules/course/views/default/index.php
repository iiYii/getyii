<div class="Course-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>
</div>

<?php
    
    use yii\helpsers\Html;
    use yii\widgets\ListView;
    use yii\widgets\Pjax;
    
    
    $this->title = '课程';
    
?>

<div class="col-md-10">
    <div class="panel panel-default">
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