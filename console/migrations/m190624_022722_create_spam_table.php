<?php

use yii\db\Migration;
use yiier\antiSpam\models\Spam;

/**
 * Handles the creation of table `{{%spam}}`.
 */
class m190624_022722_create_spam_table extends Migration
{
    /**
     * 创建表选项
     * @var string
     */
    public $tableOptions = null;

    /**
     * 是否事务性存储表, 则创建为事务性表. 默认不使用
     * @var bool
     */
    public $useTransaction = false;

    public function init()
    {
        parent::init();
        if ($this->db->driverName === 'mysql') {
            //Mysql 表选项
            $engine = $this->useTransaction ? 'InnoDB' : 'MyISAM';
            $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=' . $engine;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%spam}}', [
            'id' => $this->primaryKey(),
            'status' => $this->tinyInteger(1)->defaultValue(1)->comment('0 or 1'),
            'content' => $this->text()->notNull(),
            'type' => $this->string(20)->defaultValue('contains')->comment('contains or similar'),
            'for' => $this->string(20)->defaultValue('all'),
        ], $this->tableOptions);

        $this->createIndex('fk_status_for', '{{%spam}}', ['status', 'for']);
        self::initData();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%spam}}');
    }


    public static function initData()
    {
        Spam::create(Spam::TYPE_CONTAINS, '网{3}赌');
        Spam::create(Spam::TYPE_CONTAINS, '找小姐');
        Spam::create(Spam::TYPE_SIMILAR, '网赌平台冻账号说我违规套利不给出款该怎么办？');
    }
}
