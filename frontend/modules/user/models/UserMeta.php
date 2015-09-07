<?php

namespace frontend\modules\user\models;

use common\models\PostComment;
use common\services\NotificationService;
use frontend\modules\topic\models\Topic;
use frontend\modules\tweet\models\Tweet;
use Yii;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "user_meta".
 *
 * @property integer $id
 * @property string $user_id
 * @property string $type
 * @property string $value
 * @property string $target_id
 * @property string $target_type
 * @property string $created_at
 */
class UserMeta extends ActiveRecord
{
    const STATUS_ACTIVE = 0;
    const STATUS_DELETED = -1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_meta';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'target_id', 'created_at'], 'integer'],
            [['type', 'target_type'], 'string', 'max' => 100],
            [['value'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'type' => '操作类型',
            'value' => '操作类型值',
            'target_id' => '目标id',
            'target_type' => '目标类型',
            'created_at' => '创建时间',
        ];
    }

    public static function deleteOne($conditions)
    {
        $model = self::findOne($conditions);
        if ($model) {
            return $model->delete();
        }
        return false;
    }

    /**
     * 判断指定分类下操作是否存在
     * @param string $type 话题还是评论
     * @param string $do 动作
     * @param $targetId 话题ID或者评论ID
     * @return int|string
     */
    public function isUserAction($type = '', $do = '', $targetId)
    {
        return $this->find()->where([
            'target_id' => $targetId,
            'user_id' => Yii::$app->user->id,
            'target_type' => $type,
            'type' => $do,
        ])->count();
    }

    /**
     * 添加新的动作
     * @param $type
     * @param $targetId
     * @param $do
     * @return bool
     */
    public function saveNewMeta($type, $targetId, $do)
    {
        $data = [
            'target_id' => $targetId,
            'user_id' => Yii::$app->user->id,
            'target_type' => $type,
            'type' => $do,
        ];
        $model = $this->find()->where($data)->one();
        $this->setAttributes($data);
        if (!$model) {
            if ($this->save()) {
                return true;
            } else {
                return array_values($this->getFirstErrors())[0];
            }
        }
    }

    public function getTopic()
    {
        return $this->hasOne(Topic::className(), ['id' => 'target_id']);
    }

    public function getTweet()
    {
        return $this->hasOne(Tweet::className(), ['id' => 'target_id']);
    }

    public function getComment()
    {
        return $this->hasOne(PostComment::className(), ['id' => 'target_id']);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $userActionNotify = (new NotificationService)->findUserActionNotify($this);
            if ($userActionNotify) {
                $userActionNotify->delete();
            }
            // 点赞、感谢和收藏会收到通知
            if (in_array($this->type, ['like', 'favorite', 'thanks'])) {
                switch ($this->target_type) {
                    case 'topic':
                        (new NotificationService)->newActionNotify(
                            $this->target_type . '_' . $this->type,
                            Yii::$app->user->id,
                            $this->topic->user_id,
                            $this->topic
                        );
                        break;
                    case 'tweet':
                        (new NotificationService)->newActionNotify(
                            $this->target_type . '_' . $this->type,
                            Yii::$app->user->id,
                            $this->tweet->user_id,
                            $this->tweet
                        );
                        break;
                    case 'comment':
                        (new NotificationService)->newActionNotify(
                            $this->target_type . '_' . $this->type,
                            Yii::$app->user->id,
                            $this->comment->user_id,
                            $this->comment->topic,
                            $this->comment
                        );
                        break;
                    default:
                        break;
                }
            }
        }

        return parent::beforeSave($insert);
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $userActionNotify = (new NotificationService)->findUserActionNotify($this);
            if ($userActionNotify) {
                $userActionNotify->status = 0;
                $userActionNotify->save();
            }
            return true;
        } else {
            return false;
        }
    }

}
