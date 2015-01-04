<?php

use yii\db\Schema;
use yii\db\Migration;

class m150104_091352_init_user extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->addColumn('{{%user}}', 'avatar' , Schema::TYPE_STRING . " DEFAULT NULL COMMENT '头像' AFTER `username` ");
    }

    public function down()
    {
        echo "m150104_091352_init_user cannot be reverted.\n";
        $this->dropTable('{{%user}}');
        return false;
    }
}
