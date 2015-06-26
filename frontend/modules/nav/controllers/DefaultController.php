<?php

namespace frontend\modules\nav\controllers;

use yii\web\Controller;
use common\models\Nav;
use common\models\NavUrl;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $nav = Nav::find()->orderBy('order asc')->all();
        return $this->render('index', ['nav' => $nav]);
    }
}
