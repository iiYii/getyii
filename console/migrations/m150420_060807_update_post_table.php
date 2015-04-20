<?php

use yii\db\Schema;
use common\components\db\Migration;

class m150420_060807_update_post_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%post}}', 'follow_count' , Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '讨厌数' AFTER `view_count`");
    }

    public function down()
    {
        echo "m150420_060807_update_post_table cannot be reverted.\n";
        $this->dropColumn('{{%post}}', 'follow_count');
        return false;
    }
}
