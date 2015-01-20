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
        'sb-admin-2-assets/dist/css/sb-admin-2.css',
        'font-awesome/css/font-awesome.min.css',
        'metisMenu/dist/metisMenu.min.css',
    ];
    public $js = [
        'metisMenu/dist/metisMenu.min.js',
        'sb-admin-2-assets/dist/js/sb-admin-2.js',
    ];
}
