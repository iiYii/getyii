<?php

namespace frontend\widgets;

class PostTypeTab extends \yii\bootstrap\Widget
{

    public $node;

    public function run()
    {
        return $this->render('postTypeTab', [
            'node' => $this->node,
        ]);
    }
}