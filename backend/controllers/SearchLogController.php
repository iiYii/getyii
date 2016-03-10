<?php

namespace backend\controllers;

use Yii;
use common\models\SearchLog;
use backend\models\SearchLogSearch;
use yii\web\NotFoundHttpException;

/**
 * SearchLogController implements the CRUD actions for SearchLog model.
 */
class SearchLogController extends Controller
{
    /**
     * Lists all SearchLog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Deletes an existing SearchLog model.
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
     * Finds the SearchLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SearchLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SearchLog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
