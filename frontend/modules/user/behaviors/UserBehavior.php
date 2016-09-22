<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/23
 * Time: 下午9:13
 */

namespace frontend\modules\user\behaviors;


use common\models\User;
use common\models\UserInfo;
use yii\base\Behavior;

/**
 * 方便替换
 * Class UserBehavior
 * @package common\behaviors
 */
class UserBehavior extends Behavior
{
    public $userIdAttribute = 'user_id';
    public function getUser()
    {
        return $this->owner->hasOne(User::className(), ['id' => $this->userIdAttribute]);
    }

    public function getFrom()
    {
        return $this->owner->hasOne(User::className(), ['id' => 'from_uid']);
    }

    public function getTo()
    {
        return $this->owner->hasOne(User::className(), ['id' => 'to_uid']);
    }

    public function getProfile()
    {
        return $this->hasOne(UserInfo::className(), ['user_id' => $this->userIdAttribute]);
    }
}