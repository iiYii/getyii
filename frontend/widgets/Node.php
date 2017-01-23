<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/25 下午1:42
 * description:
 */

namespace frontend\widgets;

use common\models\PostMeta;

class Node extends \yii\bootstrap\Widget
{
    public function run()
    {
        $nodes = PostMeta::getNodes();

        return $this->render('node', [
            'nodes' => $nodes
        ]);
    }
}