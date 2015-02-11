<?php

namespace common\models;

use Yii;
use common\components\db\ActiveRecord;

/**
 * This is the model class for table "user_info".
 *
 * @property integer $id
 * @property string $user_id
 * @property string $info
 * @property string $github
 * @property string $website
 * @property string $company
 * @property string $location
 * @property string $comment_count
 * @property string $post_count
 * @property string $thanks_count
 * @property string $like_count
 * @property integer $login_count
 * @property string $prev_login_time
 * @property string $prev_login_ip
 * @property string $last_login_time
 * @property string $last_login_ip
 * @property string $created_at
 * @property string $updated_at
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
            [['github', 'website', 'comment_count', 'post_count', 'thanks_count'], 'string', 'max' => 100],
            [['company', 'like_count'], 'string', 'max' => 40],
            [['location'], 'string', 'max' => 10],
            [['prev_login_ip', 'last_login_ip'], 'string', 'max' => 32]
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
            'info' => '会员简介',
            'github' => 'GitHub 帐号',
            'website' => '个人主页',
            'company' => '公司',
            'location' => '城市',
            'comment_count' => 'GitHub 帐号',
            'post_count' => 'GitHub 帐号',
            'thanks_count' => '个人主页',
            'like_count' => '公司',
            'login_count' => '登录次数',
            'prev_login_time' => '上次登录时间',
            'prev_login_ip' => '上次登录IP',
            'last_login_time' => '最后登录时间',
            'last_login_ip' => '最后登录IP',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
