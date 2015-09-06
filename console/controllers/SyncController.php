<?php

namespace console\controllers;

use frontend\modules\topic\models\Topic;
use frontend\modules\user\models\UserMeta;
use Yii;
use common\models\PostComment;
use common\models\UserInfo;
use yii\console\Controller;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;


class SyncController extends Controller
{
    public function actionUserInfo()
    {
        UserInfo::updateAll(['thanks_count' => 0, 'like_count' => 0, 'hate_count' => 0]);
        $meta = UserMeta::find()->all();
        foreach ($meta as $key => $value) {
            if (in_array($value->type, ['thanks', 'like', 'hate'])) {
                switch ($value->target_type) {
                    case 'topic':
                    case 'post':
                        $this->stdout("同步文章操作……\n");
                        $topic = Topic::findOne($value->target_id);
                        if (UserInfo::updateAllCounters([$value->type . '_count' => 1], ['user_id' => $topic->user_id])) {
                            $this->stdout("同步评论成功`(*∩_∩*)′\n");
                        } else {
                            $this->stdout("同步评论失败::>_<::\n");
                        }
                        break;

                    case 'comment':
                        $this->stdout("同步评论操作……\n");
                        $comment = PostComment::findOne($value->target_id);
                        if (UserInfo::updateAllCounters([$value->type . '_count' => 1], ['user_id' => $comment->user_id])) {
                            $this->stdout("同步评论成功`(*∩_∩*)′\n");
                        } else {
                            $this->stdout("同步评论失败::>_<:: \n");
                        }
                        break;

                    default:
                        # code...
                        break;
                }
            }
        }
        return;
    }

    public function actionPost()
    {
        $update = Topic::updateAll(
            ['last_comment_time' => new Expression('created_at')],
//            ['or', ['type' => Topic::TYPE, 'last_comment_username' => ''], ['type' => Topic::TYPE, 'last_comment_username' => null]]
            ['and', ['type' => Topic::TYPE], ['or', ['last_comment_username' => ''], ['last_comment_username' => null]]]
        );
        $this->stdout("同步最后回复时间，同步{$update}条数据\n");

        $subQuery = new Query();
        $subQuery->from(PostComment::tableName())->where(['status' => PostComment::STATUS_ACTIVE])->orderBy(['created_at' => SORT_DESC]);
        $comment = PostComment::find()->from(['tmpA' => $subQuery])
            ->groupBy('post_id')
            ->all();

        Topic::updateAll(['comment_count' => 0], ['type' => Topic::TYPE]);

        $updateComment = [];
        foreach ($comment as $value) {
            $commentCount = PostComment::find()->where(['post_id' => $value->post_id, 'status' => PostComment::STATUS_ACTIVE])->count();
            $updateComment[] = Topic::updateAll(
                [
                    'last_comment_time' => $value->created_at,
                    'last_comment_username' => $value->user->username,
                    'comment_count' => $commentCount,
                ],
                ['id' => $value->post_id, 'type' => Topic::TYPE]
            );
        }
        $this->stdout("校正最后回复时间和回复会员还有评论条数，校正" . count($updateComment) . "条数据\n");
    }
}
