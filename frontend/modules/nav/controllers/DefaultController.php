<?php

namespace frontend\modules\nav\controllers;

use common\components\Controller;
use common\models\Nav;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $nav = Nav::find()->orderBy('order asc')->all();
        return $this->render('index', ['nav' => $nav]);
    }
}
