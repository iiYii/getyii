<?php
/**
 * @Author: forecho
 * @Date:   2015-01-10 21:08:56
 * @Last Modified by:   forecho
 * @Last Modified time: 2015-01-24 21:38:44
 */

namespace frontend\widgets;

use common\models\PostTag;
use common\models\PostMeta;

class PostRight extends \yii\bootstrap\Widget
{
    public function run()
    {
        $category = PostMeta::findAll(['type' => 'category']);
        $tags = PostTag::find()->orderBy('count DESC')->all();

        return $this->render('postRight', [
            'category' => $category,
            'tags' => $tags,
        ]);
    }
}
