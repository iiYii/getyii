<?php

namespace common\models;

use Yii;

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
class UserMeta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_meta';
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


    /**
     * 赞 感谢 收藏 喝倒彩
     * @param $uid
     * @param $type string ['like', 'thanks', 'favorite', 'hate']
     * @return bool|string
     */
    public function userAction($uid, $type='')
    {
        return $this->toggleLikeOrHate($uid, $type);
    }

    /**
     * 喝倒彩或者赞
     * @param $uid
     * @param $type 操作类型, like 或 hate
     * @return bool|string string为错误提示, bool为操作成功还是失败
     */
    protected function _likeOrHate($uid, $type)
    {
        //查找数据库是否有记录
        $model = $this->find()
            ->where(['or', ['type' => 'like'], ['type' => 'hate']])
            ->andWhere([
                'uid' => $uid,
                'target_id' => $this->id,
                'target_type' => static::TYPE
            ])->one();
        $contrary = $return = $active = false;
        if ($model) {
            $num = $model->delete();// 有记录(赞或踩)则取消记录
            if ($model->type == $type) { //相应记录删除后直接返回取消结果
                $return = $num >= 0;
            } else {
                $model = null; // 相对记录需清空查询结果已经生成相应的记录
                $contrary = true;
            }
        }
        if (!$model) { //创建记录
            $model = $type == Like::TYPE ? new Like() : new Hate();
            $model->setAttributes(array(
                'uid' => $uid,
                'target_id' => $this->id,
                'target_type' => static::TYPE,
            ));
            if ($model->save()) {
                $return = $active = true;
            } else {
                $return = array_values($model->getFirstErrors())[0];
            }
        }
        if ($return == true) { // 更新记数
            $attributeName1 = $type . '_count';
            if ($contrary) {
                $attributeName2 = ($type == 'like' ? 'hate' : 'like') . '_count';
                $attributes = [
                    $attributeName1 => $active ? 1 : ($this->$attributeName1 > 0 ? -1 :0),
                    $attributeName2 => $active ? ($this->$attributeName2 > 0 ? -1 :0) : 1
                ];
            } else {
                $attributes = [
                    $attributeName1 => $active ? 1 : ($this->$attributeName1 > 0 ? -1 :0)
                ];
            }
            //更新版块统计
            $this->updateCounters($attributes);
        }
        return $return;
    }
}
