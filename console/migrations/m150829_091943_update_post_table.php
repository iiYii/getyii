<?php

use yii\db\Schema;
use yii\db\Migration;

class m150829_091943_update_post_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%post}}', 'last_comment_username' , Schema::TYPE_STRING . '(20) DEFAULT NULL COMMENT "最后评论用户" AFTER `tags`');
        $this->addColumn('{{%post}}', 'last_comment_time' , Schema::TYPE_INTEGER . ' DEFAULT NULL COMMENT "最后评论用户" AFTER `tags`');
    }

    public function down()
    {
        echo "m150829_091943_update_post_table cannot be reverted.\n";
        $this->dropColumn('{{%post}}', 'last_comment_time');
        $this->dropColumn('{{%post}}', 'last_comment_username');
        return false;
    }
}
