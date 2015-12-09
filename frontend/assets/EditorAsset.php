<?php

namespace frontend\assets;
use Yii;
use yii\web\AssetBundle;

class EditorAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
    ];

    public $js = [
//        'js/jquery.caret.js',
        'js/editor.js',
    ];
}