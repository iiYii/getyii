<?php

use yii\db\Schema;
use yii\db\Migration;

class m150424_025409_update_table_engine extends Migration
{
    public function safeUp()
    {
        $this->changeEngine('MyISAM', 'InnoDB');
    }

    public function safeDown()
    {
        echo "m150424_025409_update_table_engine cannot be reverted.\n";
        $this->changeEngine('InnoDB', 'MyISAM');
    }

    protected function changeEngine($from, $to)
    {
        $table = [
            '{{%notification}}',
            '{{%post}}',
            '{{%post_meta}}',
            //'{{%post_tag}}',
            //'{{%setting}}',
            '{{%user}}',
            '{{%user_info}}',
            '{{%user_meta}}',
        ];
        foreach ($table as $key => $value) {
            $this->execute("ALTER TABLE $value ENGINE = {$to};");

        }
    }

}
