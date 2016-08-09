<?php
use yii\helpers\Html;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
$this->title = '时间线';
$content = '
**2015年5月1日**
- 网站重新上线，全新改版只做社区！
- 原来的版本命名为[V1](https://github.com/iiyii/getyii/tree/v1)，可能不会再更新，没有通知系统。

**2015年4月15日**
- 解决几个BUG

**2015年4月12日**
- 更换 MarkDown 在线编辑器。
- 添加统计功能

**2015年3月2日**
- 在 [yiichina](http://www.yiichina.com/topic/5685) 上发帖推广

**2015年2月14日**
- 吸引到第一位开发者－[kevin](http://www.getyii.com/member/kevin) 注册账号

**2015年2月06日**
- 上线测试

';
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?= $this->title ?>
    </div>
    <div class="panel-body">
        <?= Markdown::process($content, 'gfm') ?>
    </div>
</div>