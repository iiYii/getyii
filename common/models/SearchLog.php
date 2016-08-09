<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "search_log".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $keyword
 * @property integer $created_at
 */
class SearchLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%search_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at'], 'integer'],
            [['keyword'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', '用户ID'),
            'username' => Yii::t('app', '用户名'),
            'keyword' => Yii::t('app', '搜索关键词'),
            'created_at' => Yii::t('app', '创建时间'),
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
