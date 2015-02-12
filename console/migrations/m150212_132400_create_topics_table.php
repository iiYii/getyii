<?php

use yii\db\Schema;
use common\components\db\Migration;

class m150212_132400_create_topics_table extends Migration
{
    public function up()
    {
    	$this->addColumn('{{%post}}', 'type' , Schema::TYPE_STRING . '(32) DEFAULT "blog" COMMENT "内容类型" AFTER `id`');
    	// 修改字段
    	$this->alterColumn('{{%post}}', 'tags' , Schema::TYPE_STRING . " DEFAULT NULL COMMENT '标签 用英文逗号隔开'");
    	$this->alterColumn('{{%post}}', 'post_meta_id' , Schema::TYPE_INTEGER . " UNSIGNED NOT NULL COMMENT '版块ID'");
    	$this->createIndex('type', '{{%post}}', 'type');
    }

    public function down()
    {
        echo "m150212_132400_create_topics_table cannot be reverted.\n";
        $this->dropColumn('{{%post}}', 'type');
        return false;
    }
}
