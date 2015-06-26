<?php

use yii\db\Schema;
use yii\db\Migration;

class m150626_073539_create_nav extends Migration
{
    public function up()
    {
        $this->execute('DROP TABLE IF EXISTS {{%nav}}');
        $table = '{{%nav}}';
        $this->createTable($table, [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL COMMENT "名称"',
            'alias' => Schema::TYPE_STRING .' NOT NULL COMMENT "变量（别名）"',
            'order' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '99' COMMENT '项目排序'",
            'created_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'updated_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '修改时间'",
        ]);
    }

    public function down()
    {
        echo "m150626_073539_create_nav cannot be reverted.\n";
        $this->dropTable('{{%nav}}');
        return false;
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
