<?php

namespace frontend\widgets;

class Ad extends \yii\bootstrap\Widget
{

    public $key;

    public function run()
    {
        return $this->render('ad', [
            'key' => $this->key,
        ]);
    }
}