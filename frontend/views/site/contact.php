<?php
use yii\helpers\Html;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
$this->title = '联系我们';
$content = '
## QQ群

- DBA中国交流群：101825261

## 个人联系

- QQ：279016421
- Mail：ruyi1024[#]vip.126.com

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