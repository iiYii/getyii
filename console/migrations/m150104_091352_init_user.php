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
        $this->_generateFounderUser()

        // 会员动作表
        $tableName = '{{%user_meta}}';
        $this->createTable($tableName, [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL COMMENT '用户ID'",
            'type' => Schema::TYPE_STRING . "(100) NOT NULL DEFAULT '' COMMENT '操作类型'",
            'value' => Schema::TYPE_STRING . " NOT NULL DEFAULT '' COMMENT '操作类型值'",
            'target_id' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '目标id'",
            'target_type' => Schema::TYPE_STRING . "(100) NOT NULL DEFAULT '' COMMENT '目标类型'",
            'created_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
        ], $tableOptions);
        $this->createIndex('type', $tableName, 'type');
        $this->createIndex('user_id', $tableName, 'user_id');
        $this->createIndex('target_id', $tableName, 'target_id');
        $this->createIndex('target_type', $tableName, 'target_type');

        // 会员第三方登录表
        $tableName = '{{%user_auth}}';
        $this->createTable($tableName, [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL COMMENT '用户ID'",
            'type' => Schema::TYPE_STRING . "(100) NOT NULL DEFAULT '' COMMENT '联合登录类型'",
            'token' => Schema::TYPE_STRING . " NOT NULL",
            'openid' => Schema::TYPE_STRING . " NOT NULL",
            'created_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
        ], $tableOptions);
        $this->createIndex('type', $tableName, 'type');
        $this->createIndex('user_id', $tableName, 'user_id');
    }


    public function down()
    {
        echo "m150104_091352_init_user cannot be reverted.\n";
        $this->dropColumn('{{%user}}', 'avatar');
        $this->dropTable('{{%user_meta}}');
        $this->dropTable('{{%user_auth}}');
        return false;
    }
}
