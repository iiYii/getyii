<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/19 下午3:20
 * description:
 */

namespace common\services;

use frontend\models\Notification;
use frontend\modules\article\models\Article;

class ArticleService extends PostService
{

    public function userDoAction($id, $action)
    {
        $article = Article::findArticle($id);
        $user = \Yii::$app->user->getIdentity();
        if (in_array($action, ['like', 'hate'])) {
            return UserService::ActionA($user, $article, $action);
        } else {
            return UserService::ActionB($user, $article, $action);
        }
    }

    /**
     * 撤销
     * @param Article $question
     */
    public static function revoke(Article $article)
    {
        $article->setAttributes(['status' => Article::STATUS_ACTIVE]);
        $article->save();
    }

}