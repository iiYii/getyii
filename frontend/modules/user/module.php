<?php

namespace frontend\modules\user;

use yii\base\Module as BaseModule;
use yii\web\GroupUrlRule;

class module extends BaseModule
{
	public $modelMap = [];
	/** @var bool Whether to show flash messages. */
    public $enableFlashMessages = true;

    public $controllerNamespace = 'frontend\modules\user\controllers';

    public function init()
    {
        parent::init();

    	$configUrlRule = [
	        'prefix' => $this->urlPrefix,
	        'rules'  => $this->urlRules
	    ];
	    \Yii::$app->get('urlManager')->rules[] = new GroupUrlRule($configUrlRule);

    }

    public $urlPrefix = 'user';
    public $urlRules = [
    	'<username:\w+>' => 'default/show',
    	'setting' => 'setting/profile',
    ];
}
