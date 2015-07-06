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
        //'materialize/css/materialize.min.css',
        //'foundation/css/foundation.min.css',
    ];
    public $js = [
        'bootstrap/dist/js/bootstrap.min.js',
        'marked/lib/marked.js',
        'highlightjs/highlight.pack.js',
        'localforage/dist/localforage.min.js',
        'jquery-textcomplete/dist/jquery.textcomplete.min.js',
        // 'foundation/js/foundation.min.js',
    ];
}
