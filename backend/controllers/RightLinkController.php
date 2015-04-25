<?php

namespace backend\controllers;

use Yii;
use backend\models\Rightlink;
use backend\models\RightlinkSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RightLinkController implements the CRUD actions for Rightlink model.
 */
class RightLinkController extends Controller
{
    const RIGHT_LINK_CLASS_RSOURCES = 1;
    const RIGHT_LINK_CLASS_TIPS = 2;
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Rightlink models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RightlinkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title' => '右边栏设置',
        ]);
    }
    
    /**
     * 首页侧边栏推荐资源设置
     * return mixed
     */
    public function actionRecommendRsources()
    {
        $searchModel =new RightlinkSearch();
        $queryParams = Yii::$app->request->queryParams;
        $queryParams['RightlinkSearch']['class'] = self::RIGHT_LINK_CLASS_RSOURCES;
        $dataProvider = $searchModel->search($queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title' => '推荐资源',
        ]);
    }
    /**
     * 首页侧边栏小贴士设置
     * return mixed 
     * */
    public function actionTips()
    {
       $searchModel = new RightlinkSearch();
       $queryParams = Yii::$app->request->queryParams;    
       $queryParams['RightlinkSearch']['class'] = self::RIGHT_LINK_CLASS_TIPS;
       $dataProvider = $searchModel->search($queryParams);
       return $this->render('index', [
           'searchModel' => $searchModel,
           'dataProvider' => $dataProvider,
           'title' => '小贴士',
       ]);
       
    }
    
    
    /**
     * Displays a single Rightlink model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Rightlink model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Rightlink();
        $request = Yii::$app->request->post();
        $request['Rightlink']['created_user'] = 'zghack';
        $request['Rightlink']['created_at'] = '';
        $request['Rightlink']['updated_at'] = '';
        if ($model->load($request) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->rlid]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Rightlink model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->rlid]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Rightlink model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Rightlink model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Rightlink the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Rightlink::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
