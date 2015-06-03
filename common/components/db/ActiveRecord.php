<?php
namespace common\components\db;

class ActiveRecord extends \yii\db\ActiveRecord
{
	/**
     * 自动更新created_at和updated_at时间
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
            ],
        ];
    }
}