<?php
use yii\helpers\Html;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
$this->title = '时间线';
$content = '

**2016年3月26日**
- 社区上线积分系统和帖子阅读打赏功能功能

**2016年3月25日**
- 服务器配置升级，将为大家提供更加优质的访问体验

**2015年10月15日**
- 社区xunsearch全文搜索功能上线，搜索功能支持标题和内容的搜索

**2015年9月1日**
- 社区全面支持emoji表情，不管你用的是 iPhone 输入法自带的 emoji 还是 http://emoji.muan.co/ 这种方式，我们统统支持

**2015年8月1日**
- 网站数据库定时备份并发送到邮件功能上线

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
