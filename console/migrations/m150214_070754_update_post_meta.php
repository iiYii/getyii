<?php

use yii\db\Schema;
use yii\db\Migration;

class m150214_070754_update_post_meta extends Migration
{
    public function up()
    {
    	$this->addColumn('{{%post_meta}}', 'alias' , Schema::TYPE_STRING . "(32) DEFAULT NULL COMMENT '变量（别名）' AFTER `name`");
        $this->createIndex('alias', '{{%post_meta}}', 'alias');
    }

    public function down()
    {
        echo "m150214_070754_update_post_meta cannot be reverted.\n";
        $this->dropColumn('{{%post_meta}}', 'alias');
        return false;
    }
}
