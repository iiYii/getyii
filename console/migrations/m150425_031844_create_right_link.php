<?php

use yii\db\Schema;

class m150425_031844_create_right_link extends \common\components\db\Migration
{
    public function up()
    {
        $this->execute('DROP TABLE IF EXISTS {{%rightlink}}');
        $table = '{{%right_link}}';
        $this->createTable($table, [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . ' NOT NULL COMMENT "标题"',
            'url' => Schema::TYPE_STRING . '(225) ',
            'image' => Schema::TYPE_STRING . '(255) COMMENT "图片链接"',
            'content' => Schema::TYPE_STRING . '(255) COMMENT "内容"',
            'type' => Schema::TYPE_INTEGER . '(5) COMMENT "展示类别"',
            'created_user' => Schema::TYPE_STRING . '(32) NOT NULL COMMENT "创建人"',
            'created_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'updated_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '修改时间'",
        ], $this->tableOptions);
        $this->createIndex('type_index', $table, 'type');
    }

    public function down()
    {
        echo "m150425_031844_create_rightLink cannot be reverted.\n";
        $this->dropTable('{{%right_link}}');
        return false;
    }

}
