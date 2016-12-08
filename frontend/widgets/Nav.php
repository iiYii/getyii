<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/23 下午4:13
 * description:
 */

namespace frontend\widgets;

use Yii;
use common\services\UserService;
use common\models\PostMeta;

class Nav extends \yii\bootstrap\Widget
{

    public function run()
    {
        $notifyCount = UserService::findNotifyCount();

        //  获取热门节点
        $params = Yii::$app->request->queryParams;
        if (isset($params['node'])) {
            $nodeParent = PostMeta::findOne(['alias' => $params['node']])->parent;
            $my_nodes = PostMeta::find()->where(['not',['parent' =>null]])->andWhere(['parent'=>$nodeParent])->orderBy([ 'count' => SORT_DESC,'order' => SORT_ASC,])->limit(10)->all();
        }
        else{
            $my_nodes = PostMeta::find()->where(['not',['parent' =>null]])->orderBy([ 'count' => SORT_DESC,'order' => SORT_ASC,])->limit(10)->all();
        }
        //print_r($nodes);exit;
        return $this->render('nav', [
            'notifyCount' => $notifyCount,
            'my_nodes' => $my_nodes,
        ]);
    }
}