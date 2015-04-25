<?php

use yii\db\Schema;
use yii\db\Migration;

class m150424_031429_update_notification_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%notification}}', 'status' , Schema::TYPE_BOOLEAN . " UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态 1显示 0不显示' AFTER `data`");
    }

    public function safeDown()
    {
        echo "m150424_031429_update_notification_table cannot be reverted.\n";
        $this->dropColumn('{{%notification}}', 'status');
        return false;
    }

}
