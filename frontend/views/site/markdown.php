<?php
use yii\helpers\Html;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
$this->title = 'Markdown 教程';
// $this->params['breadcrumbs'][] = $this->title;
$content = '
# Guide

这是一篇讲解如何正确使用 **Markdown** 的排版示例，学会这个很有必要，能让你的文章有更佳清晰的排版。

> 引用文本：Markdown is a text formatting syntax inspired

## 排版

请注意单词拼写，以及中英文排版，https://github.com/sparanoid/chinese-copywriting-guidelines

## 语法指导

### 普通内容

这段内容展示了在内容里面一些小的格式，比如：

- **加粗** - `**加粗**`
- *倾斜* - `*倾斜*`
- ~~删除线~~ - `~~删除线~~`
- `Code 标记` - ``Code 标记``
- [超级链接](http://github.com) - `[超级链接](http://github.com)`
- [caizhenghai@gmail.com](mailto:caizhenghai@gmail.com) - `[caizhenghai@gmail.com](mailto:caizhenghai@gmail.com)`
- ![图片](http://7xjanb.com1.z0.glb.clouddn.com/logo.png) - `![图片](http://7xjanb.com1.z0.glb.clouddn.com/logo.png)`

注：暂不支持上传图片，请使用外链图片。推荐图床：http://drp.io/ 和 https://imgur.com/

### 提及用户

@forecho @caicai ... 通过 @ 可以在发帖和回帖里面提及用户，信息提交以后，被提及的用户将会收到系统通知。以便让他来关注这个帖子或回帖。切记：@某人之后有一个空格。

### 表情符号 Emoji

支持表情符号，你可以用系统默认的 Emoji 符号（无法支持 Chrome 以及 Windows 用户）。
也可以用图片的表情。

#### 一些表情例子

:smile: :laughing: :dizzy_face: :sob: :cold_sweat: :sweat_smile:  :cry: :triumph: :heart_eyes:  :satisfied: :relaxed: :sunglasses: :weary:

:+1: :-1: :100: :clap: :bell: :gift: :question: :bomb: :heart: :coffee: :cyclone: :bow: :kiss: :pray: :shit: :sweat_drops: :exclamation: :anger:

更多表情请访问：[http://www.emoji-cheat-sheet.com](http://www.emoji-cheat-sheet.com)

### 大标题 - Heading 3

你可以选择使用 H2 至 H6，使用 ##(N) 打头，H1 不能使用，会自动转换成 H2。

> NOTE: 别忘了 # 后面需要有空格！

#### Heading 4

##### Heading 5

###### Heading 6

### 代码块

#### 普通

```
*emphasize*    **strong**
_emphasize_    __strong__
@a = 1
```

#### 语法高亮支持

如果在 ``` 后面更随语言名称，可以有语法高亮的效果哦，比如:

##### 演示 PHP 代码高亮

```php
public function getDataCellValue($model, $key, $index)
{
    $value = parent::getDataCellValue($model, $key, $index);
    return ArrayHelper::getValue($this->enum, $value, $value);
}
```

> Tip: 语言名称支持下面这些: `ruby`, `python`, `js`, `html`, `php`, `css`, `coffee`, `bash`, `json`, `xml` ...

### 有序、无序列表

#### 无序列表

- PHP
  - Yii
    - ActiveRecord
- Go
  - Gofmt
  - Revel
- Node.js
  - Koa
  - Express

#### 有序列表

1. Node.js
  1. Express
  2. Koa
  3. Sails
2. PHP
  1. Yii
  2. Laravel
3. Go


### 段落

留空白的换行，将会被自动转换成一个段落，会有一定的段落间距，便于阅读。

请注意后面 Markdown 源代码的换行留空情况。
';
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?= $this->title; ?>
    </div>
    <div class="panel-body">
        <div class="col-md-6">
            <pre><code><?= $content ?></code></pre>
        </div>
        <div class="col-md-6"><?= Markdown::process($content, 'gfm') ?></div>
    </div>
</div>