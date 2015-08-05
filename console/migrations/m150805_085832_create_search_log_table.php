<?php

use yii\db\Schema;
use common\components\db\Migration;

class m150805_085832_create_search_log_table extends Migration
{
    public $tableName = '{{%search_log}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . " UNSIGNED DEFAULT NULL COMMENT '用户ID'",
            'keyword' => Schema::TYPE_STRING . " NOT NULL DEFAULT '' COMMENT '搜索关键词'",
            'created_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
        ], $this->tableOptions);
        $this->createIndex('keyword', $this->tableName, 'keyword');
        $this->createIndex('user_id', $this->tableName, 'user_id');
    }

    public function down()
    {
        echo "m150805_085832_create_search_log_table cannot be reverted.\n";
        $this->dropTable($this->tableName);
        return false;
    }
}
