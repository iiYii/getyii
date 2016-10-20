<?php

namespace frontend\modules\manual\controllers;

use Yii;
use yii\web\Controller;
use common\models\Manual;
use common\models\ManualContent;

/**
 * Default controller for the `manual` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $model = Manual::find()->orderBy('sort_order asc')->all();
        return $this->render('index', ['model' => $model]);
    }

    /**
     * 手册详细页
     * @param integer $id
     * @return mixed
     */
    public function actionView($manual_id)
    {
        $this->layout = false;
        $model = ManualContent::find()->where(['manual_id'=>$manual_id,'parent_id'=>0,'status'=>'Y'])->orderBy('sort_order asc')->all();
        $manual = Manual::find()->where(['id'=>$manual_id])->one();
        $params = Yii::$app->request->queryParams;
        $id = isset($params['_id']) ? $params['_id'] : 0;
        if($id==0){
            $manual_content = ManualContent::find()->where(['manual_id'=>$manual_id,'status'=>'H'])->andWhere(['=','parent_id',0])->orderBy('sort_order asc')->one();
        }
        else{
            $manual_content = ManualContent::find()->where(['manual_id'=>$manual_id,'id'=>$id,'status'=>'Y'])->one();
        }

        ManualContent::updateAllCounters(['view_count' => 1], ['id' => $manual_content->id]);

        return $this->render('view', [
            'model' => $model,
            'manual' => $manual,
            'manual_content' => $manual_content,
        ]);
    }
}
