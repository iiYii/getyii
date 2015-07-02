<?php

use yii\db\Schema;
use common\components\db\Migration;

class m150702_130239_create_session_init extends Migration
{
    public $tableName = '{{%session}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => "varchar(40) NOT NULL",
            'expire' => "int(11)",
            'data' => "blob",
        ]);
        $this->addPrimaryKey('idx', $this->tableName, 'id');
        $this->createIndex('idx_expire', $this->tableName, 'expire');
        $this->addColumn('{{%user_info}}', 'session_id', Schema::TYPE_STRING . "(100) DEFAULT NULL AFTER `last_login_ip`");
    }

    public function down()
    {
        echo "m150702_130239_create_session_init cannot be reverted.\n";
        $this->dropTable($this->tableName);
        $this->dropColumn('{{%user_info}}', 'session_id');
        return false;
    }

}
