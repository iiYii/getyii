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
        'js/editor.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'common\assets\AtJs',
        'common\assets\CaretJs',
//        'common\assets\DropzoneJs',
    ];
}