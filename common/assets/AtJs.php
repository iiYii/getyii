<?php
namespace common\assets;

use yii\web\AssetBundle;

/**
 * @author forecho <caizhenghai@gmail.com>
 */
class AtJs extends AssetBundle
{
    public $sourcePath = '@bower/At.js/dist';

    public $css = [
        'css/jquery.atwho.min.css',
    ];

    public $js = [
        'js/jquery.atwho.min.js',
    ];
}
