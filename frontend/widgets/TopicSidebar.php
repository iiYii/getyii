<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/18 下午4:13
 * description:
 */

namespace frontend\widgets;

use common\models\PostMeta;
use common\models\RightLink;
use yii\helpers\ArrayHelper;

class TopicSidebar extends \yii\bootstrap\Widget
{
    public $type = 'node';
    public $node = '';

    public function run()
    {
        // $tags = PostTag::find()->orderBy('count DESC')->all();

        $tipsModel = RightLink::find()
            ->select(['content'])
            ->where(['type' => RightLink::RIGHT_LINK_TYPE_TIPS])
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->one();

        $recommendResources = ArrayHelper::map(
            RightLink::find()->where(['type' => RightLink::RIGHT_LINK_TYPE_RSOURCES])->all(),
            'title',
            'url'
        );

        $links = RightLink::find()->where(['type' => RightLink::RIGHT_LINK_TYPE_Links])->all();

        $config = [
            'type' => $this->type,
            'node' => $this->node,
        ];

        return $this->render('topicSidebar', [
            'category' => PostMeta::blogCategory(),
            'config' => $config,
            'tips' => $tipsModel['content'],
            'recommendResources' => $recommendResources,
            'links' => $links,
        ]);
    }
}