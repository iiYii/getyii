<?php

namespace frontend\modules\course\controllers;

use yii;
use yii\web\Controller;
use common\models\Course;
use common\models\CourseSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class DefaultController extends Controller
{
	public function behaviors()
	{
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
        $searchCourse = new CourseSearch();

        #分类筛选
        $params = Yii::$app->request->queryParams;
        return $this->render('index');
    }


}
