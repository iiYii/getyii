<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/18 下午4:13
 * description:
 */

namespace frontend\widgets;

use common\models\PostTag;
use common\models\PostMeta;
use backend\models\Rightlink;
use backend\controllers\RightLinkController;

class TopicSidebar extends \yii\bootstrap\Widget
{
    public $type = 'node';
    public $node = '';

    public function run()
    {
       // $tags = PostTag::find()->orderBy('count DESC')->all();
       
       $tipsModel = Rightlink::find()
               ->select(['content'])
               ->where(['class' => RightLinkController::RIGHT_LINK_CLASS_TIPS])
               ->orderBy(['rlid'=>SORT_DESC])
               ->asArray()
               ->one();
       $RecommendResourcesModel = Rightlink::find()
                       ->select(['title','url'])
                       ->where(['class' => RightLinkController::RIGHT_LINK_CLASS_RSOURCES])
                       ->asArray()
                       ->all();
       
       $RecommendResources = array();
       foreach($RecommendResourcesModel as $rk => $rv)
       {
           $RecommendResources[$rv['title']] = $rv['url'];
       }
       
        $config = [
            'type' => $this->type,
            'node' => $this->node,
        ];

        return $this->render('topicSidebar', [
            'category' => PostMeta::blogCategory(),
            'config' => $config,
            'tips' => $tipsModel['content'],
            'RecommendResources' => $RecommendResources,
        ]);
    }
}