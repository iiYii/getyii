<?php
namespace common\components\db;

class Command extends \yii\db\Command
{

    /**
     * @param $replace 是否替换数据,如果为真, 则创建REPLACE INTO sql语句 (Only Mysql)
     * @see \yii\db\Command::batchInsert();
     */
    public function batchReplace($table, $columns, $rows)
    {
        $sql = $this->db->getQueryBuilder()->batchInsert($table, $columns, $rows);
        return $this->setSql('REPLACE' . substr($sql, strpos($sql, ' ')));
    }

}

?>