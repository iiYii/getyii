<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/25 下午1:42
 * description:
 */

namespace frontend\widgets;

use common\models\PostMeta;
use yii\helpers\ArrayHelper;

class Node extends \yii\bootstrap\Widget
{
    public function run()
    {
        $nodes = [];
        $parents = ArrayHelper::map(PostMeta::find()->where(['parent' => null])->orWhere(['parent' => 0])->orderBy(['order' => SORT_ASC])->all(), 'id', 'name');
        foreach ($parents as $key => $value) {
            $nodes[$value] = PostMeta::find()->where(['parent' => $key])->asArray()->all();
        }

        return $this->render('node', [
            'nodes' => $nodes
        ]);
    }
}