<?php

use yii\db\Schema;
use common\components\db\Migration;

class m150211_070335_update_user_info extends Migration
{
    public function up()
    {
    	$this->addColumn('{{%user_info}}', 'like_count' , Schema::TYPE_INTEGER . ' DEFAULT 0 COMMENT "被赞次数" AFTER `location`');
    	$this->addColumn('{{%user_info}}', 'thanks_count' , Schema::TYPE_INTEGER . ' DEFAULT 0 COMMENT "被感谢次数" AFTER `location`');
    	$this->addColumn('{{%user_info}}', 'post_count' , Schema::TYPE_INTEGER . ' DEFAULT 0 COMMENT "发布文章数" AFTER `location`');
    	$this->addColumn('{{%user_info}}', 'comment_count' , Schema::TYPE_INTEGER . ' DEFAULT 0 COMMENT "发布评论数" AFTER `location`');
    	$this->addColumn('{{%user_info}}', 'view_count' , Schema::TYPE_INTEGER . ' DEFAULT 0 COMMENT "个人主页浏览次数" AFTER `location`');
    }

    public function down()
    {
        echo "m150211_070335_update_user_info cannot be reverted.\n";
        $this->dropColumn('{{%user_info}}', 'like_count');
        $this->dropColumn('{{%user_info}}', 'thanks_count');
        $this->dropColumn('{{%user_info}}', 'post_count');
        $this->dropColumn('{{%user_info}}', 'comment_count');
        $this->dropColumn('{{%user_info}}', 'view_count');
        return false;
    }
}
