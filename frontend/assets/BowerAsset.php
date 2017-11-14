<?php
namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author forecho <caizhenghai@gmail.com>
 */
class BowerAsset extends AssetBundle
{
    public $sourcePath = '@bower';
    public $baseUrl = '@bower';

    public $css = [
        'highlightjs/styles/darkula.css',
        'pace/themes/green/pace-theme-minimal.css',
    ];

    public $js = [
        'highlightjs/highlight.pack.js',
        'localforage/dist/localforage.min.js',
        'pace/pace.min.js',
    ];
}
