<?php

use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\ListView;
use common\models\NavUrl;


$this->title = '网站导航';

?>

<style type="text/css">
    .nav-item {
        height: 35px;
    }
</style>
<div class="nav-index col-md-2">
    <div class="panel panel-default corner-radius pinned">
        <div class="panel-heading text-center">
            <h3 class="panel-title"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> 导航栏目</h3>
        </div>
        <div class="panel-body text-center" style="padding-top: 5px;">
            <div class="list-group ">
                <?php foreach($nav as $key => $item): ?>
                <a href="#<?php echo $item->alias; ?>" class="list-group-item"><?php echo $item->name; ?></a>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>


<div class="nav-index col-md-10">
    <?php foreach($nav as $key => $item): ?>
    <div class="panel panel-default corner-radius" id="<?php echo $item->alias; ?>">
        <div class="panel-heading text-left">
            <h3 class="panel-title"><?php echo $item->name; ?></h3>
        </div>
        <div class="panel-body text-left">
            <div class="row">
                <?php $NavUrl = NavUrl::find()->where(['nav_id' => $item->id ])->orderBy('order asc')->all(); ?>
                <?php if($NavUrl): ?>
                    <?php foreach($NavUrl as $sub_key => $sub_item): ?>
                        <div class="col-md-2 nav-item"><a href="<?php echo $sub_item->url; ?>" target="_blank" data-toggle="tooltip" data-placement="top"
                                                  title="<?php echo $sub_item->description; ?>"><?php echo $sub_item->title; ?></a></div>
                    <?php endforeach ?>
                <?php  endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach ?>
</div>

