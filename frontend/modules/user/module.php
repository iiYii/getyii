<?php

namespace frontend\modules\user;

class module extends \yii\base\Module
{
	public $modelMap = [];
	/** @var bool Whether to show flash messages. */
    public $enableFlashMessages = true;

    public $controllerNamespace = 'frontend\modules\user\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
