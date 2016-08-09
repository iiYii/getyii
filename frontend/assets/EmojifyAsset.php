<?php
namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author forecho <caizhenghai@gmail.com>
 */
class EmojifyAsset extends AssetBundle
{
    public $sourcePath = '@bower/emojify.js';
    public $baseUrl = '@bower/emojify.js';

    public $css = [
    ];

    public $js = [
        'dist/js/emojify.min.js',
    ];
}
