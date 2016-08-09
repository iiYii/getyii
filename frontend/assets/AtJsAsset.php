<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 2016/3/10 11:24
 * description:
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class AtJsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
    ];

    public $js = [
        'js/At.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'common\assets\AtJs',
        'common\assets\CaretJs',
    ];
}