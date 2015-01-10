<?php

namespace frontend\widgets;

use common\Models\PostTag;
use common\Models\PostMeta;

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
