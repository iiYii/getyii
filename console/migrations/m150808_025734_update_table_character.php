<?php

use yii\db\Schema;
use yii\db\Migration;

class m150808_025734_update_table_character extends Migration
{
    public function safeUp()
    {
        $this->changeCharacter('utf8mb4', 'utf8mb4_general_ci');
    }

    public function safeDown()
    {
        echo "m150720_031448_update_table_character cannot be reverted.\n";
        $this->changeCharacter('utf8', 'utf8_general_ci');
    }

    protected function changeCharacter($toA, $toB)
    {
        $this->execute("ALTER TABLE {{%post_comment}} MODIFY COLUMN `comment` text CHARACTER SET {$toA} COLLATE {$toB};");
        $this->execute("ALTER TABLE {{%post}} MODIFY COLUMN `content` text CHARACTER SET {$toA} COLLATE {$toB};");
        $this->execute("ALTER TABLE {{%notification}} MODIFY COLUMN `data` text CHARACTER SET {$toA} COLLATE {$toB};");
    }
}
