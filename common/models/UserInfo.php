<?php

namespace common\models;

use Yii;
use common\components\db\ActiveRecord;

/**
 * This is the model class for table "user_info".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $info
 * @property integer $login_count
 * @property integer $prev_login_time
 * @property string $prev_login_ip
 * @property integer $last_login_time
 * @property string $last_login_ip
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $location
 * @property string $company
 * @property string $website
 * @property string $github
 */
class UserInfo extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'prev_login_time', 'prev_login_ip', 'last_login_time', 'last_login_ip', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'login_count', 'prev_login_time', 'last_login_time', 'created_at', 'updated_at'], 'integer'],
            [['info'], 'string', 'max' => 255],
            [['prev_login_ip', 'last_login_ip'], 'string', 'max' => 32],
            [['location'], 'string', 'max' => 10],
            [['company'], 'string', 'max' => 40],
            [['website', 'github'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'info' => '个人介绍',
            'login_count' => '登录次数',
            'prev_login_time' => '上次登录时间',
            'prev_login_ip' => '上次登录IP',
            'last_login_time' => '最后登录时间',
            'last_login_ip' => '最后登录IP',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'location' => '城市',
            'company' => '公司',
            'website' => '个人主页',
            'github' => 'GitHub 帐号',
        ];
    }
}
