<?php
use yii\helpers\Html;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
$this->title = '关于';
$content = '
#### 这里是 DBA 中文社区

- 爱数据库，爱DBA
- 爱互联网，，爱最新最潮的技术
- 爱学习，爱沟通，也爱传播
- 我们不管你是谁，只要你喜欢数据库，喜欢分享
- 这里是 DataBase & DBA 的中国社区，作我们最好的交流和沟通的大本营


一直以来，DBA 在中国都没有一个专业的靠谱的社区，我们打算认真的把这个站做起来，改善中国 DBA 小伙伴交流的方式。我们是一个非营利组织，它旨在为中国的 DBA 和 数据库 爱好者提供一个自由，开放的交流平台。

enjoy database! enjoy dba!

#### 最后

- 感谢 [GetYii](https://github.com/iiyii/getyii) 的开源代码。

- 最后感激大家的支持 <(▰˘◡˘▰)>。
';
?>
<div class="container p0">
    <div class="panel panel-default">
        <div class="panel-heading">
            关于
        </div>
        <div class="panel-body">
            <?= Markdown::process($content, 'gfm') ?>
        </div>
    </div>
</div>