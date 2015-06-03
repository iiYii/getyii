<?php

namespace frontend\modules\user;

use yii\base\Module as BaseModule;

class Module extends BaseModule
{
	public $modelMap = [];
	/** @var bool Whether to show flash messages. */
    public $enableFlashMessages = true;

    public $controllerNamespace = 'frontend\modules\user\controllers';

    public function init()
    {
        parent::init();

    }
}
