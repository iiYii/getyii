<?php

use yii\db\Schema;
use yii\db\Migration;

class m150212_030127_update_user_info_and_post_meta extends Migration
{
    public function up()
    {
    	$this->addColumn('{{%user_info}}', 'hate_count' , Schema::TYPE_INTEGER . ' DEFAULT 0 COMMENT "喝倒彩次数" AFTER `like_count`');
    }

    public function down()
    {
        echo "m150212_030127_update_user_info_and_post_meta cannot be reverted.\n";
        $this->dropColumn('{{%user_info}}', 'hate_count');
        return false;
    }
}
