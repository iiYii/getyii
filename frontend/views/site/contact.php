<?php
use yii\helpers\Html;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
$this->title = '联系我们';
$content = '
## QQ群

- Yii2 中国交流群：343188481
- Get√Yii 核心开发者群：321493381（本群只接受参与本站开发的 Yiier）

## 个人联系

- QQ：314494687
- Mail：caizhenghai[#]gmail.com

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