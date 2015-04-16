<?php

use yii\db\Schema;
use common\components\db\Migration;

class m150416_134819_create_notification_table extends Migration
{
    public function up()
    {
        $tableName = '{{%notification}}';
        $this->createTable($tableName, [
            'id' => Schema::TYPE_PK,
            'from_user_id' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL COMMENT '通知来源用户ID'",
            'user_id' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL COMMENT '用户ID'",
            'post_id' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL COMMENT '文章ID'",
            'comment_id' => Schema::TYPE_INTEGER . " UNSIGNED DEFAULT NULL COMMENT '文章评论ID'",
            'type' => Schema::TYPE_STRING . " NOT NULL COMMENT '通知类型'",
            'data' => Schema::TYPE_TEXT . " NOT NULL COMMENT '通知内容'",
            'created_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'updated_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
        ], $this->tableOptions);
        $this->createIndex('type', $tableName, 'type');
        $this->createIndex('post_id', $tableName, 'post_id');
        $this->createIndex('user_id', $tableName, 'user_id');
        $this->addColumn('{{%user}}', 'notification_count' , Schema::TYPE_INTEGER . ' UNSIGNED DEFAULT 0 COMMENT "通知条数" AFTER `tagline`');
    }

    public function down()
    {
        echo "m150416_134819_create_notifications_table cannot be reverted.\n";
        $this->dropTable('{{%notification}}');
        $this->dropColumn('{{%user}}', 'notification_count');
        return false;
    }
}
