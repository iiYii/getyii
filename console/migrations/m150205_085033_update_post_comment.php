<?php

use yii\db\Schema;
use common\components\db\Migration;

class m150205_085033_update_post_comment extends Migration
{
    public function up()
    {
    	$this->addColumn('{{%post_comment}}', 'updated_at', Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '修改时间'");
    	$this->addColumn('{{%post_comment}}', 'like_count', Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '喜欢数' AFTER `user_id`");
    }

    public function down()
    {
        echo "m150205_085033_update_post_comment cannot be reverted.\n";
        $this->dropColumn('{{%post_comment}}', 'updated_at');
        $this->dropColumn('{{%post_comment}}', 'like_count');
        return false;
    }
}