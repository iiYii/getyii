<?php
use yii\helpers\Html;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
$this->title = '关于';
$content = '
#### 这里是 Yii 中文社区

- 爱 PHP，爱 Yii
- 爱互联网，爱 Web 开发，爱最新最潮的技术
- 爱学习，爱沟通，也爱传播
- 我们不管你是谁，只要你喜欢 PHP，喜欢 Yii
- 这里是 PHP & Yii 的中国社区，作我们最好的交流和沟通的大本营


一直以来，Yii 在中国都没有一个靠谱的社区，我们几个打算认真的把这个站做起来，改善中国 Yiier 交流的方式。我们是一个非营利组织，它旨在为中国的 PHP 和 Yii 爱好者提供一个自由，开放的交流平台。

enjoy coding! enjoy yii!

#### 最后

- 感谢 [Ruby-China](https://github.com/ruby-china/ruby-china) 的开源代码。
- 感谢 [PHPHub](https://github.com/summerblue/phphub) 的开源代码。
- 感谢 [huajuan](https://github.com/callmez/huajuan) 的开源代码。
- 最后再感谢一下女朋友的支持 <(▰˘◡˘▰)>。
';
?>
<div class="panel panel-default">
    <div class="panel-heading">
        关于
    </div>
    <div class="panel-body">
        <?= Markdown::process($content, 'gfm') ?>
    </div>
</div>