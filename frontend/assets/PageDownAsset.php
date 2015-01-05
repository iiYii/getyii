<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class PageDownAsset extends AssetBundle
{
    public $sourcePath = '@bower/pagedown';
    public $js = [
        'Markdown.Converter.js',
        'Markdown.Sanitizer.js',
        'Markdown.Editor.js'
    ];
}