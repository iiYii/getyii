<?php

use yii\db\Schema;
use common\components\db\Migration;

class m150807_082458_create_merit_table extends Migration
{
    public $useTransaction = true;

    public function up()
    {
        $this->createTable('{{%merit_template}}', [
            'id' => Schema::TYPE_PK,
            'type' => Schema::TYPE_STRING . "(20) NOT NULL COMMENT '分类'",
            'description' => Schema::TYPE_STRING . " NOT NULL COMMENT '描述'",
            'action' => Schema::TYPE_STRING . " NOT NULL COMMENT '具体操作的action'",
            'action_type' => Schema::TYPE_BOOLEAN . " DEFAULT 1 COMMENT '操作类型 0减去 1新增'",
            'increment' => Schema::TYPE_INTEGER . " UNSIGNED DEFAULT NULL COMMENT '变化值'",
            'created_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'updated_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
        ], $this->tableOptions);
        $this->createIndex('type', '{{%merit_template}}', 'type');

        $this->createTable('{{%merit}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . " UNSIGNED DEFAULT NULL COMMENT '用户ID'",
            'type' => Schema::TYPE_STRING . "(20) NOT NULL COMMENT '分类'",
            'merit' => Schema::TYPE_INTEGER . " UNSIGNED DEFAULT NULL COMMENT '总值'",
            'created_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'updated_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
        ], $this->tableOptions);
        $this->createIndex('type', '{{%merit}}', 'type');
        $this->createIndex('user_id', '{{%merit}}', 'user_id');

        $this->createTable('{{%merit_log}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . " UNSIGNED NULL NULL COMMENT '用户ID'",
            'merit_template_id' => Schema::TYPE_INTEGER . " UNSIGNED NULL NULL COMMENT '模板ID'",
            'type' => Schema::TYPE_STRING . "(20) NOT NULL COMMENT '分类'",
            'description' => Schema::TYPE_STRING . " NOT NULL COMMENT '描述'",
            'action_type' => Schema::TYPE_BOOLEAN . " DEFAULT 1 COMMENT '操作类型 0减去 1新增'",
            'increment' => Schema::TYPE_INTEGER . " UNSIGNED DEFAULT NULL COMMENT '变化值'",
            'created_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'updated_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
        ], $this->tableOptions);
        $this->createIndex('type', '{{%merit_log}}', 'type');
        $this->createIndex('user_id', '{{%merit_log}}', 'user_id');
        $this->createIndex('merit_template_id', '{{%merit_log}}', 'merit_template_id');
        $this->execute($this->initSql());
    }

    public function down()
    {
        echo "m150807_082458_create_merit_table cannot be reverted.\n";
        $this->dropTable('{{%merit_template}}');
        $this->dropTable('{{%merit}}');
        $this->dropTable('{{%merit_log}}');
        return false;
    }

    /**
     * @return string SQL to insert first user
     */
    private function initSql()
    {
        $time = time();
        return "INSERT INTO {{%merit_template}} (`type`, `description`,`action`, `increment`, `created_at`, `updated_at`) VALUES
                ('point', '会员登录', 'frontend@site_login', 1, {$time}, {$time}),
                ('point', '会员发帖', 'frontend@topic_default_create', 10, {$time}, {$time}),
                ('point', '会员发动弹', 'frontend@tweet_default_create', 5, {$time}, {$time}),
                ('point', '会员帖子评论', 'frontend@topic_comment_create', 2, {$time}, {$time})
                ";
    }
}
