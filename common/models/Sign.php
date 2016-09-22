<?php

namespace common\models;

use frontend\modules\user\behaviors\UserBehavior;
use Yii;

/**
 * This is the model class for table "pop_sign".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $last_sign_at
 * @property integer $times
 * @property integer $continue_times
 */
class Sign extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sign}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'last_sign_at', 'times'], 'required'],
            [['user_id', 'last_sign_at', 'times', 'continue_times'], 'integer'],
            [['user_id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '会员号',
            'last_sign_at' => '最后签到时间',
            'times' => '总签到次数',
            'continue_times' => '连续签到次数',
        ];
    }

    public function behaviors()
    {
        return [
            UserBehavior::class
        ];
    }
}
