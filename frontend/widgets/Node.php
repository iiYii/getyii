<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/25 下午1:42
 * description:
 */

namespace frontend\widgets;

use common\models\PostMeta;
use DevGroup\TagDependencyHelper\NamingHelper;
use yii\caching\TagDependency;
use yii\helpers\ArrayHelper;

class Node extends \yii\bootstrap\Widget
{
    public function run()
    {
        $cacheKey = md5(__METHOD__);
        if (false === $items = \Yii::$app->cache->get($cacheKey)) {
            $parents = ArrayHelper::map(
                PostMeta::find()->where(['parent' => null])->orWhere(['parent' => 0])->orderBy(['order' => SORT_ASC])->all(),
                'id', 'name'
            );
            foreach ($parents as $key => $value) {
                $nodes[$value] = PostMeta::find()->where(['parent' => $key])->asArray()->all();
            }
            $items = $nodes;
            //一天缓存
            \Yii::$app->cache->set($cacheKey, $items, 86400,
                new TagDependency([
                    'tags' => [NamingHelper::getCommonTag(PostMeta::className())]
                ])
            );
        }

        return $this->render('node', [
            'nodes' => $items
        ]);
    }
}