<?php
use yii\helpers\Html;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
$this->title = 'Yii 新手入门';
// $this->params['breadcrumbs'][] = $this->title;
$content = '
## Yii 新手入门

### Yii 入门

- [Yii Framework 官网](http://www.yiiframework.com/)
- [Yii2-中文化组织](https://github.com/yii2-chinesization)
- [Composer 中文文档](https://github.com/5-say/composer-doc-cn)

#### Yii1

- [Yii1 权威指南中文版](http://www.yiiframework.com/doc/guide/1.1/zh_cn/index)
- [Yii1 Api 英文版](http://www.yiiframework.com/doc/api/)
- [Yii1 Demos](http://www.eha.ee/labs/yiiplay/index.php/et)
- [Yii1 Demos](http://demo.bsourcecode.com/yiiframework/)
- [Yii1-extension Demo](http://www.eha.ee/labs/yiiplay/index.php/et)

#### Yii2

- [Yii2 权威指南英文版](http://www.yiiframework.com/doc-2.0/guide-index.html)
- [Yii2 Api 英文版](http://www.yiiframework.com/doc-2.0/index.html)
- [Yii 2.0权威指南中文版](http://yii2.techbrood.com/guide-index.html)
- [Yii 2.0权威指南中文版](http://yii2.yiibar.com/guide-zh-CN/guide-README.html)
- [Yii 2.0权威指南中文版](http://www.yiifans.com/yii2/guide/index.html)
- [深入理解Yii2.0](http://www.digpage.com)
- [Krajee Yii Extensions](http://demos.krajee.com/)


### Yii 资源

- [Yii 基础教程博客](http://www.bsourcecode.com/)
- [CSDN Yii 开发教程](http://blog.csdn.net/column/details/mapdigityiiframework.html)


### Yii 书籍

- [Yii框架图书](http://www.yiibook.com/)


### Yii 优秀开源

#### 基于Yii1

- [yupe](https://github.com/yupe/yupe)
- [CiiMS](https://github.com/charlesportwoodii/CiiMS)
- [Yincart](https://github.com/yincart/basic)
- [dlfblog](https://github.com/windsdeng/dlfblog)
- [FirCMS](https://github.com/poctsy/fircms)
- [birdbbs](https://github.com/outman/birdbbs)
- [dcms](https://github.com/djfly/dcms)
- [bagecms](http://www.bagecms.com/)

#### 基于Yii2

- [GetYii](https://github.com/iiYii/getyii)
- [huajuan](https://github.com/callmez/huajuan)
- [dcms2](https://github.com/djfly/dcms2)
- [yii2-adminlte](https://github.com/funson86/yii2-adminlte)
- [yii2-simple](https://github.com/azraf/yii2-simple)
- [dotplant2](https://github.com/DevGroup-ru/dotplant2)


### 贡献者

- [forecho](/member/forecho)

### 最后

欢迎大家跟我联系提供更多资料。
';
?>
<div class="panel panel-default">
    <div class="panel-heading">
        Wiki 列表
    </div>
    <div class="panel-body">
        <?= Markdown::process($content, 'gfm') ?>
    </div>
</div>