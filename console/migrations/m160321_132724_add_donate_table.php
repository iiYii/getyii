<?php

use common\components\db\Migration;

class m160321_132724_add_donate_table extends Migration
{
    public $tableName = '{{%donate}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'status' => $this->boolean()->defaultValue(1),
            'description' => $this->string(),
            'qr_code' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $this->tableOptions);
        $this->createIndex('user_id', $this->tableName, 'user_id');
    }

    public function down()
    {
        echo "m160321_132724_add_donate_table cannot be reverted.\n";
        $this->dropTable($this->tableName);
        return false;
    }
}
