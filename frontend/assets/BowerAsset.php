<?php
namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author forecho <caizhenghai@gmail.com>
 */
class BowerAsset extends AssetBundle
{
    public $sourcePath = '@bower';
    public $css = [
        'font-awesome/css/font-awesome.min.css',
        'highlightjs/styles/monokai_sublime.css',
    ];
    public $js = [
        'marked/lib/marked.js',
        'highlightjs/highlight.pack.js',
        'jquery-textcomplete/dist/jquery.textcomplete.min.js',
    ];
}
