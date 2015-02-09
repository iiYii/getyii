<?php

use yii\db\Schema;
use common\components\db\Migration;

class m150209_090406_create_user_account extends Migration
{
    public function up()
    {
    	$this->execute($this->delTable());
    	// 会员第三方登录账号表
    	$tableName = '{{%user_account}}';
    	$this->createTable($tableName, [
    	    'id' => Schema::TYPE_PK,
    	    'user_id' => Schema::TYPE_INTEGER . " UNSIGNED DEFAULT NULL COMMENT '用户ID'",
    	    'provider' => Schema::TYPE_STRING . "(100) NOT NULL DEFAULT '' COMMENT '授权提供商'",
    	    'client_id' => Schema::TYPE_STRING . " NOT NULL",
    	    'data' => Schema::TYPE_TEXT . " NOT NULL",
    	    'created_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
    	], $this->tableOptions);
    	$this->createIndex('client_id', $tableName, 'client_id');
    	$this->createIndex('user_id', $tableName, 'user_id');
    }

    private function delTable()
    {
    	return "DROP TABLE IF EXISTS {{%user_auth}};";
    }

    public function down()
    {
        echo "m150209_090406_create_user_account cannot be reverted.\n";
        $this->dropTable('{{%user_account}}');
        return false;
    }
}
