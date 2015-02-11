<?php

use yii\db\Schema;
use common\components\db\Migration;

class m150211_070335_update_user_info extends Migration
{
    public function up()
    {
    	$this->addColumn('{{%user_info}}', 'like_count' , Schema::TYPE_STRING . '(40) DEFAULT NULL COMMENT "公司" AFTER `location`');
    	$this->addColumn('{{%user_info}}', 'thanks_count' , Schema::TYPE_STRING . '(100) DEFAULT NULL COMMENT "个人主页" AFTER `location`');
    	$this->addColumn('{{%user_info}}', 'post_count' , Schema::TYPE_STRING . '(100) DEFAULT NULL COMMENT "GitHub 帐号" AFTER `location`');
    	$this->addColumn('{{%user_info}}', 'comment_count' , Schema::TYPE_STRING . '(100) DEFAULT NULL COMMENT "GitHub 帐号" AFTER `location`');
    }

    public function down()
    {
        echo "m150211_070335_update_user_info cannot be reverted.\n";
        $this->dropColumn('{{%user_info}}', 'like_count');
        $this->dropColumn('{{%user_info}}', 'thanks_count');
        $this->dropColumn('{{%user_info}}', 'post_count');
        $this->dropColumn('{{%user_info}}', 'comment_count');
        return false;
    }
}
