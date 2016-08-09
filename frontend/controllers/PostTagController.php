<?php
namespace frontend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\PostTagSearch;
use common\components\Controller;

/**
 * PostTagController implements the CRUD actions for PostTag model.
 */
class PostTagController extends Controller
{
    /**
     * Lists all PostTag models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostTagSearch();
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params);
        //ajax
        if (Yii::$app->request->getIsAjax()) {
            return json_encode(ArrayHelper::getColumn($dataProvider->getModels(), function ($model) {
                return $model->getAttributes(['name']);
            }));
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}