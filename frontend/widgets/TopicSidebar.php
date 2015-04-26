<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/18 下午4:13
 * description:
 */

namespace frontend\widgets;

use common\models\PostMeta;
use common\models\RightLink;
use frontend\modules\topic\models\Topic;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class TopicSidebar extends \yii\bootstrap\Widget
{
    public $type = 'node';
    public $node = '';

    public function run()
    {
        $tipsModel = ArrayHelper::map(
            RightLink::find()->where(['type' => RightLink::RIGHT_LINK_TYPE_TIPS])->all(),
            'content',
            'title'
        );
        $tips = array_rand($tipsModel);

        $recommendResources = ArrayHelper::map(
            RightLink::find()->where(['type' => RightLink::RIGHT_LINK_TYPE_RSOURCES])->all(),
            'title',
            'url'
        );

        $links = RightLink::find()->where(['type' => RightLink::RIGHT_LINK_TYPE_Links])->all();

        $sameTopics = [];
        if ($this->node) {
            $sameTopics = ArrayHelper::map(
                Topic::find()
                    ->where('status >= :status', [':status' => Topic::STATUS_ACTIVE])
                    ->andWhere(['post_meta_id' => $this->node->id, 'type' => 'topic'])
                    ->limit(200)->all(),
                'title',
                function ($e) {
                    return Url::to(['/topic/default/view', 'id' => $e->id]);
                }
            );
            if (count($sameTopics) > 10) {
                $sameTopics = $this->arrayRandomAssoc($sameTopics, 10);
            }
        }

        $config = [
            'type' => $this->type,
            'node' => $this->node,
        ];

        return $this->render('topicSidebar', [
            'category' => PostMeta::blogCategory(),
            'config' => $config,
            'sameTopics' => $sameTopics,
            'tips' => $tips,
            'recommendResources' => $recommendResources,
            'links' => $links,
        ]);
    }

    /**
     * 随机筛选$num个数组
     * @param $arr
     * @param int $num
     * @return array
     */
    public function arrayRandomAssoc($arr, $num = 1)
    {
        $keys = array_keys($arr);
        shuffle($keys);

        $r = [];
        for ($i = 0; $i < $num; $i++) {
            $r[$keys[$i]] = $arr[$keys[$i]];
        }
        return $r;
    }
}