<?php

use yii\db\Schema;
use yii\db\Migration;

class m150424_100155_update_post_meta_table extends Migration
{

    public function safeUp()
    {
        $this->addColumn('{{%post_meta}}', 'parent', Schema::TYPE_INTEGER . " UNSIGNED DEFAULT NULL COMMENT '父级ID' AFTER `name`");
    }

    public function safeDown()
    {
        echo "m150424_100155_update_post_meta_table cannot be reverted.\n";
        $this->dropColumn('{{%post_meta}}', 'parent');
        return false;
    }

}
