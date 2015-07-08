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
<<<<<<< HEAD
        //'materialize/css/materialize.min.css',
        //'foundation/css/foundation.min.css',
=======
        'pace/themes/green/pace-theme-minimal.css',
>>>>>>> ormm/master
    ];
    public $js = [
        'bootstrap/dist/js/bootstrap.min.js',
        'marked/lib/marked.js',
        'highlightjs/highlight.pack.js',
        'localforage/dist/localforage.min.js',
        'jquery-textcomplete/dist/jquery.textcomplete.min.js',
<<<<<<< HEAD
        // 'foundation/js/foundation.min.js',
=======
        'pace/pace.min.js',
>>>>>>> ormm/master
    ];
}
