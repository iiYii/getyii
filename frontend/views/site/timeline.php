<?php
use yii\helpers\Html;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
$this->title = '时间线';
$content = '
**2015年6月25日**
- 网站导航功能上线，请访问 http://www.dba-china.com/nav

**2015年5月25日**
- 为了更好的为广大用户服务,正式启用CDN服务cache.dba-china.com！

**2015年5月24日**
- 数据库官方手册频道上线，提供MySQL/Oracle/MongoDB等各大数据库官方手册在线查看和下载！

**2015年5月18日**
- DBA中国社区网站重新上线，全新改版只做数据库社区！

';
?>
<div class="container p0">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?= $this->title ?>
        </div>
        <div class="panel-body">
            <?= Markdown::process($content, 'gfm') ?>
        </div>
    </div>
</div>
