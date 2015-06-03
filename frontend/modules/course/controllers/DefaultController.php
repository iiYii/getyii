<?php

namespace frontend\modules\course\controllers;

use yii;
use yii\web\Controller;
use common\models\Course;
use yii\filters\VerbFilter;

class DefaultController extends Controller
{
	public function behaviors()
	{

		// return [
		// 	'verbs' => VerbFilter::className(),
		// 	'actions' => [

		// 	],
		// ];

		return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
            	'class' => AccessControl::className(),
            	'rules' => [
            		['allow' => true, 'actions' => ['view', 'index'], 'verbs' => ['GET']],
            		['allow' => true, 'actions' =>['delete'], 'verbs' => ['POST'], 'roles' => ['@']],
            		
            	]
            ],
        ];
	}

	/**
	* 课程列表
	* @return mixed
	*/
    public function actionIndex()
    {
        return $this->render('index');
    }


}
