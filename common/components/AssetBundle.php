<?php
namespace common\components;

class AssetBundle extends \yii\web\AssetBundle
{
    public $publishOptions = [
        'forceCopy' => YII_DEBUG // debug模式时强制拷贝
    ];
}