<?php
/**
 * @Author: forecho
 * @Date:   2015-02-27 11:08:56
 * @Last Modified by:   forecho
 * @Last Modified time: 2015-02-27 11:38:44
 */

namespace frontend\widgets;

use common\models\Post;

class NewestPost extends \yii\bootstrap\Widget
{
	public $options = [];

    public function getPost()
    {
        return $model = Post::find()
            ->where(['status' => 1])
            ->orderBy(['order' => SORT_ASC, 'created_at' => SORT_DESC])
            ->limit(3)->all();
    }
}
