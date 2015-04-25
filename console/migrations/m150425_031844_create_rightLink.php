<?php

use yii\db\Schema;

class m150425_031844_create_rightLink extends \common\components\db\Migration
{
    public function up()
    {
        $table = '{{%rightLink}}';
        $this->createTable($table, [
            'rlid' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING.' NOT NULL COMMENT "标题"',
            'url' => Schema::TYPE_STRING.'(225) ',
            'image' => Schema::TYPE_STRING.'(255) COMMENT "图片链接"',
            'content' => Schema::TYPE_STRING.'(255) COMMENT "内容"',
            'class' =>Schema::TYPE_INTEGER.'(5) COMMENT "展示类别"',
            'created_user' => Schema::TYPE_STRING.'(32) NOT NULL COMMENT "创建人"',
            'created_at' => Schema::TYPE_TIMESTAMP . '  NOT NULL',
            'updated_at' => Schema::TYPE_TIMESTAMP . '  NOT NULL',
        ],$this->tableOptions);
        $this->createIndex('class_index',$table,'class');
    }
    
    public function down()
    {
        echo "m150425_031844_create_rightLink cannot be reverted.\n";
        $this->dropTable('{{%rightLink}}');
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
