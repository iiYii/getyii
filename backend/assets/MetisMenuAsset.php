<?php
namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author forecho <caizhenghai@gmail.com>
 */
class MetisMenuAsset extends AssetBundle
{
    public $sourcePath = '@bower/metisMenu';
    public $css = [
        'dist/metisMenu.min.css',
    ];
    public $js = [
        'dist/metisMenu.min.js',
    ];
}
