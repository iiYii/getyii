<?php
namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author forecho <caizhenghai@gmail.com>
 */
class BackendAsset extends AssetBundle
{
    public $sourcePath = '@bower';
    public $css = [
        'font-awesome/css/font-awesome.min.css',
        'metisMenu/dist/metisMenu.min.css',
    ];
    public $js = [
        'metisMenu/dist/metisMenu.min.js',
    ];
}
