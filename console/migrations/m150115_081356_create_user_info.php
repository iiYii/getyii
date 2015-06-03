<?php

use yii\db\Schema;
use common\components\db\Migration;

class m150115_081356_create_user_info extends Migration
{
    public function up()
    {
    	$this->createTable('{{%user_info}}', [
    	    'id' => Schema::TYPE_PK,
    	    'user_id' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
    	    'info' => Schema::TYPE_STRING . ' DEFAULT NULL COMMENT "会员简介"',
    	    'login_count' => Schema::TYPE_INTEGER . ' DEFAULT 1 COMMENT "登录次数"',
    	    'prev_login_time' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL COMMENT "上次登录时间"',
    	    'prev_login_ip' => Schema::TYPE_STRING . '(32) NOT NULL COMMENT "上次登录IP"',
    	    'last_login_time' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL COMMENT "最后登录时间"',
    	    'last_login_ip' => Schema::TYPE_STRING . '(32) NOT NULL COMMENT "最后登录IP"',
    	    'created_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
    	    'updated_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
    	], $this->tableOptions);
    }

    public function down()
    {
        echo "m150115_081356_create_user_info cannot be reverted.\n";
        $this->dropTable('{{%user_info}}');
        return false;
    }
}
