<?php
namespace common\assets;

use yii\web\AssetBundle;

/**
 * @author forecho <caizhenghai@gmail.com>
 */
class CaretJs extends AssetBundle
{
    public $sourcePath = '@bower/caret.js/dist';

    public $css = [];

    public $js = [
        'jquery.caret.min.js',
    ];
}
