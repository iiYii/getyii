<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/18 下午4:13
 * description:
 */

namespace frontend\widgets;

use common\models\PostTag;
use common\models\PostMeta;

class TopicSidebar extends \yii\bootstrap\Widget
{
    public $type = 'node';
    public $node = '';

    public function run()
    {
        $tags = PostTag::find()->orderBy('count DESC')->all();

        $config = [
            'type' => $this->type,
            'node' => $this->node,
        ];

        return $this->render('topicSidebar', [
            'category' => PostMeta::blogCategory(),
            'config' => $config,
        ]);
    }
}