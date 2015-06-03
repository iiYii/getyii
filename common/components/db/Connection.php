<?php
namespace common\components\db;

class Connection extends \yii\db\Connection
{
    /**
     * @see \yii\db\Connection::createCommand
     */
    public function createCommand($sql = null, $params = [])
    {
        $this->open();
        $command = new Command([ // 使用了继承了之后的Command类..
            'db' => $this,
            'sql' => $sql,
        ]);

        return $command->bindValues($params);
    }
}