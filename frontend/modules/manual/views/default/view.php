<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\ManualContent;
use kartik\markdown\Markdown;

$this->title = '手册文档';

?>


<!DOCTYPE html>
<!-- saved from url=(0047)https://getyii.com/doc-2.0/guide/intro-yii.html -->
<html lang="en-US">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="language" content="en">
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/manual.css" rel="stylesheet">
    <script src="/js/jquery.js"></script>
    <script src="/js/bootstrap.js"></script>
</head>
<body>

<div class="wrap">
    <nav id="w1097" class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#w1097-collapse"><span
                    class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span></button>
            <a class="navbar-brand" href="#">DBACHINA文档平台</a></div>
        <div id="w1097-collapse" class="collapse navbar-collapse">
            <ul id="w1098" class="navbar-nav nav">
                <?php $manual_all = \common\models\Manual::find()->where(['status'=>'Y'])->orderBy('sort_order asc')->all(); ?>
                <?php foreach($manual_all as $key => $item): ?>
                <li><a href="<?php echo Url::to(['/manual/default/view','manual_id'=>$item->id])?>"><?=$item->title; ?></a></li>
                <?php endforeach ?>
            </ul>
            <ul id="w1099" class="navbar-nav navbar-right pr15 nav">
                <li><a href="http://www.dba-china.com/" target="_blank">返回 DBACHINA 首页</a></li>
            </ul>
            <!--
            <div class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input id="searchbox" type="text" class="form-control" placeholder="Search">
                </div>
            </div>
            -->
        </div>
    </nav>
    <div id="search-resultbox" style="display: none;" class="modal-content">
        <ul id="search-results">
        </ul>
    </div>


    <div class="row">
        <div class="col-md-2">
            <div id="navigation" class="list-group">
                <?php foreach($model as $key => $item): ?>
                <a class="list-group-item <?php if($item->name==ManualContent::getParentNameById($manual_content->parent_id)) echo 'active'; ?>" href="/#nav-<?php echo $item->name; ?>"
                   data-toggle="collapse" data-parent="#navigation" aria-expanded="true"><?php echo $item->title; ?> <b class="caret"></b></a>
                    <div id="nav-<?php echo $item->name; ?>" class="submenu panel-collapse collapse <?php if($item->name==ManualContent::getParentNameById($manual_content->parent_id)) echo 'in'; ?>" aria-expanded="true">
                        <?php $sub = ManualContent::find()->where(['manual_id'=>$item->manual_id,'parent_id'=>$item->id,'status'=>'Y'])->orderBy('sort_order asc')->all(); ?>
                        <?php foreach($sub as $sub_key => $sub_item): ?>
                            <a class="list-group-item <?php if($sub_item->name==$manual_content->name) echo 'active'; ?>" href="<?=Url::to(['/manual/default/view','manual_id'=>$item->manual_id,'_id'=>$sub_item->id]) ?>">&nbsp;&nbsp;&nbsp;<?php echo $sub_item->title; ?></a>
                        <?php endforeach ?>
                    </div>
                <?php endforeach ?>



            </div>
        </div>
        <div class="col-md-9 guide-content" role="main">
            <h2><?=$manual_content->title ?></h2>

            <hr/>
           <?=Markdown::convert($manual_content->content); ?>
            <hr/>
            <div style="margin-top: 20px;"><blockquote>本章节创建日期:<?php echo date('Y-m-d',$manual_content->create_time); ?> 最后修订日期:<?php echo date('Y-m-d',$manual_content->update_time);?> 浏览次数:<?=$manual_content->view_count ?></blockquote></div>
        </div>
    </div>

    <div id="SOHUCS"></div>

</div>

<footer class="footer">
    <p class="pull-right">
        <small>Page generated on Fri, 20 Nov 2015 10:32:35 +0800</small>
    </p>
    Powered by <a href="http://www.yiiframework.com/" rel="external">Yii Framework</a>
</footer>
</body>
</html>