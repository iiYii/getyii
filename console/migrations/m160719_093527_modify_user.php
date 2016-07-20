<?php

use yii\db\Migration;

class m160719_093527_modify_user extends Migration
{
    public $userTable = '{{%user}}';

    public function up()
    {
        $this->createIndex('idx_username', $this->userTable, 'username', true);
    }

    public function down()
    {
        $this->dropIndex('idx_username', $this->userTable);
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
