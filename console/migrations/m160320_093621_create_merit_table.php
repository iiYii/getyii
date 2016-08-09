<?php

use yii\db\Schema;
use yii\db\Migration;

class m160320_093621_create_merit_table extends Migration
{
    /**
     * 创建表选项
     * @var string
     */
    public $tableOptions = null;

    /**
     * 是否事务性存储表, 则创建为事务性表. 默认不使用
     * @var bool
     */
    public $useTransaction = true;

    public function init()
    {
        parent::init();

        if ($this->db->driverName === 'mysql') { //Mysql 表选项
            $engine = $this->useTransaction ? 'InnoDB' : 'MyISAM';
            $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=' . $engine;
        }
    }

    public function up()
    {
        $this->execute($this->delMeritTable());
        $this->createTable('{{%merit_template}}', [
            'id' => Schema::TYPE_PK,
            'type' => Schema::TYPE_INTEGER . "(2) DEFAULT 1 COMMENT '类型 1:积分 2:声望 3:徽章'",
            'title' => Schema::TYPE_STRING . " NOT NULL COMMENT '标题'",
            'unique_id' => Schema::TYPE_STRING . " NOT NULL COMMENT 'action uniqueId'",
            'method' => Schema::TYPE_INTEGER . "(2) DEFAULT 2 COMMENT '请求方式 1 get 2 post'",
            'event' => Schema::TYPE_INTEGER . "(2) DEFAULT 0 COMMENT '事件 0:不绑定'",
            'action_type' => Schema::TYPE_INTEGER . "(2) DEFAULT 2 COMMENT '操作类型 1减去 2新增'",
            'rule_key' => Schema::TYPE_INTEGER . "(2) DEFAULT 0 COMMENT '规则类型 0:不限制 1:按天限制 2:按次限制'",
            'rule_value' => Schema::TYPE_INTEGER . " DEFAULT 0 COMMENT '规则值'",
            'increment' => Schema::TYPE_INTEGER . " UNSIGNED DEFAULT NULL COMMENT '变化值'",
            'status' => Schema::TYPE_BOOLEAN . " DEFAULT 1 COMMENT '状态 0暂停 1开启'",
            'created_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'updated_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间'",
        ], $this->tableOptions);
        $this->createIndex('type', '{{%merit_template}}', 'type');
        $this->createIndex('unique_id', '{{%merit_template}}', 'unique_id');

        $this->createTable('{{%merit}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . " UNSIGNED DEFAULT NULL COMMENT '用户ID'",
            'username' => Schema::TYPE_STRING . "(20) DEFAULT NULL COMMENT '用户名'",
            'type' => Schema::TYPE_INTEGER . "(2) DEFAULT 1 COMMENT '类型 1:积分 2:声望 3:徽章'",
            'merit' => Schema::TYPE_INTEGER . " DEFAULT NULL COMMENT '总值'",
            'created_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'updated_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间'",
        ], $this->tableOptions);
        $this->createIndex('type', '{{%merit}}', 'type');
        $this->createIndex('user_id', '{{%merit}}', 'user_id');

        $this->createTable('{{%merit_log}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . " UNSIGNED NULL NULL COMMENT '用户ID'",
            'username' => Schema::TYPE_STRING . "(20) DEFAULT NULL COMMENT '用户名'",
            'merit_template_id' => Schema::TYPE_INTEGER . " UNSIGNED NULL NULL COMMENT '模板ID'",
            'type' => Schema::TYPE_INTEGER . "(2) DEFAULT 1 COMMENT '类型 1:积分 2:声望 3:徽章'",
            'description' => Schema::TYPE_STRING . " NOT NULL COMMENT '描述'",
            'action_type' => Schema::TYPE_INTEGER . "(2) DEFAULT 2 COMMENT '操作类型 1减去 2新增'",
            'increment' => Schema::TYPE_INTEGER . " UNSIGNED DEFAULT NULL COMMENT '变化值'",
            'created_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
        ], $this->tableOptions);
        $this->createIndex('type', '{{%merit_log}}', 'type');
        $this->createIndex('user_id', '{{%merit_log}}', 'user_id');
        $this->createIndex('merit_template_id', '{{%merit_log}}', 'merit_template_id');
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
     * @return string
     */
    private function delMeritTable()
    {
        return 'DROP TABLE IF EXISTS {{%merit_template}};
                DROP TABLE IF EXISTS {{%merit}};
                DROP TABLE IF EXISTS {{%merit_log}};
              ';
    }
}
