<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/18 下午4:13
 * description:
 */

namespace frontend\widgets;

class Panel extends \yii\bootstrap\Widget
{
    public $items = [];
    public $title = '';

    public function run()
    {
        $model = [
            'items' => $this->items,
            'title' => $this->title,
        ];

        return $this->render('panel', [
            'model' => $model,
        ]);
    }
}