<?php

use yii\db\Schema;
use common\components\db\Migration;

class m150104_071047_init_blog extends Migration
{
    public function up()
    {
    	// 分类
        $tableName = '{{%post_meta}}';
        $this->createTable($tableName, [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . "(100) DEFAULT NULL COMMENT '名称'",
            'type' => Schema::TYPE_STRING . "(32) DEFAULT NULL COMMENT '项目类型'",
            'description' => Schema::TYPE_STRING . " DEFAULT NULL COMMENT '选项描述'",
            'count' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '项目所属内容个数'",
            'order' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '项目排序'",
            'created_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'updated_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '修改时间'",
        ], $this->tableOptions);
        $this->createIndex('type', $tableName, 'type');

        // 文章
        $tableName = '{{%post}}';
        $this->createTable($tableName, [
            'id' => Schema::TYPE_PK,
            'post_meta_id' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '版块ID'",
            'user_id' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '作者ID'",
            'title' => Schema::TYPE_STRING . " NOT NULL COMMENT '标题'",
            'author' => Schema::TYPE_STRING . "(100) DEFAULT NULL COMMENT '作者'",
            'excerpt' => Schema::TYPE_STRING . " DEFAULT NULL COMMENT '摘要'",
            'image' => Schema::TYPE_STRING . " DEFAULT NULL COMMENT '封面图片'",
            'content' => Schema::TYPE_TEXT . " NOT NULL COMMENT '内容'",
            'tags' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT '标签 用英文逗号隔开'",
            'view_count' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '查看数'",
            'comment_count' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '评论数'",
            'favorite_count' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '收藏数'",
            'like_count' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '喜欢数'",
            'thanks_count' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '感谢数'",
            'hate_count' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '讨厌数'",
            'status' => Schema::TYPE_BOOLEAN . " NOT NULL DEFAULT '1' COMMENT '状态 1:发布 0：草稿'",
            'order' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '999' COMMENT '排序 0最大'",
            'created_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'updated_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '修改时间'",
        ]);
        $this->createIndex('post_meta_id', $tableName, 'post_meta_id');
        $this->createIndex('tags', $tableName, 'tags');
        $this->createIndex('user_id', $tableName, 'user_id');

        // 标签表
        $tableName = '{{%post_tag}}';
        $this->createTable($tableName, [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . "(20) DEFAULT NULL COMMENT '名称'",
            'count' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '计数'",
            'created_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'updated_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '修改时间'",
        ], $this->tableOptions);

        // 评论表
        $tableName = '{{%post_comment}}';
        $this->createTable($tableName, [
            'id' => Schema::TYPE_PK,
            'parent' => Schema::TYPE_INTEGER . " UNSIGNED DEFAULT NULL COMMENT '父级评论'",
            'post_id' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL COMMENT '文章ID'",
            'comment' => Schema::TYPE_TEXT . " NOT NULL COMMENT '评论'",
            'status' => Schema::TYPE_BOOLEAN . " NOT NULL DEFAULT '1' COMMENT '1为正常 0为禁用'",
            'user_id' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL COMMENT '用户ID'",
            'ip' => Schema::TYPE_STRING . " NOT NULL COMMENT '评论者ip地址'",
            'created_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
        ], $this->tableOptions);
        $this->createIndex('post_id', $tableName, 'post_id');
        $this->createIndex('user_id', $tableName, 'user_id');
    }

    public function down()
    {
        echo "m150104_071047_init_blog cannot be reverted.\n";
        $this->dropTable('{{%post_meta}}');
        $this->dropTable('{{%post}}');
        $this->dropTable('{{%post_tag}}');
        $this->dropTable('{{%post_comment}}');
        return false;
    }
}
