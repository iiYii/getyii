<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class SelectizeAsset extends AssetBundle
{
    public $sourcePath = '@bower/selectize';
    public $css = [
        'dist/css/selectize.default.css',
    ];
    public $js = [
        'dist/js/standalone/selectize.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}