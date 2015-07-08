<?php

use yii\db\Schema;
use yii\db\Migration;

class m150626_073559_create_nav_url extends Migration
{
    public function up()
    {
        $this->execute('DROP TABLE IF EXISTS {{%nav_url}}');
        $table = '{{%nav_url}}';
        $this->createTable($table, [
            'id' => Schema::TYPE_PK,
            'nav_id' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '导航分类ID'",
            'title' => Schema::TYPE_STRING . ' NOT NULL COMMENT "标题"',
            'url' => Schema::TYPE_STRING . '(225) NOT NULL COMMENT "链接"',
            'description' => Schema::TYPE_STRING . '(255) COMMENT "描述"',
            'order' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '99' COMMENT '项目排序'",
            'user_id' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户ID'",
            'created_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'updated_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '修改时间'",
        ]);
    }

    public function down()
    {
        echo "m150626_073559_create_nav_url cannot be reverted.\n";
        $this->dropTable('{{%nav_url}}');
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
