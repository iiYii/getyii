<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class LayuiAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $css = [
        'lib/layui/css/layui.css',
        'css/site-ruyi.css',  //site.css or site-ruyi.css
    ];
    public $js = [
        'lib/layui/layui.js',
    ];
}
