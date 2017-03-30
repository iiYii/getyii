<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/19 下午3:20
 * description:
 */

namespace common\services;


use common\models\PostMeta;
use common\models\PostSearch;
use common\models\User;
use common\models\Post;
use DevGroup\TagDependencyHelper\NamingHelper;
use frontend\models\Notification;
use Yii;
use yii\caching\TagDependency;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class PostService
{

    /**
     * 删除帖子
     * @param Post $post
     */
    public static function delete(Post $post)
    {
        $post->setAttributes(['status' => Post::STATUS_DELETED]);
        $post->save();
        Notification::updateAll(['status' => Post::STATUS_DELETED], ['post_id' => $post->id]);
    }

    /**
     * 过滤内容
     * @param $content
     * @return bool
     */
    public function filterContent($content)
    {
        $content = strtolower($content);
        $content = trim($content);
        $data = ['test', '测试'];
        if (in_array($content, $data)) {
            return false;
        }
//        $action = ['+1', '赞', '很赞', '喜欢', '收藏', 'mark', '写的不错', '不错', '给力'];
//        if (in_array($content, $action)) {
//            return false;
//        }
        return true;
    }

    public static function contentTopic($content, $model)
    {
        $content = static::contentReplaceAtUser($content, $model);
        return $content;
    }

    public static function contentComment($content, $model)
    {
        $content = static::contentReplaceAtUser($content, $model);
        $content = static::contentReplaceFloor($content);
        return $content;
    }

    public static function contentTweet($content, $model)
    {
        $content = static::contentReplaceAtUser($content, $model);
        $content = static::contentReplaceTag($content);
        return $content;
    }

    /**
     * 评论内容包含 '#n楼' 的将其替换为楼层锚链接
     * @param $content string
     * @return string
     */
    public static function contentReplaceFloor($content)
    {
        return preg_replace('/#(\d+)楼/', '[\0](#comment\1)', $content);
    }

    /**
     * 内容包含 '@summer ' 的将其替换为用户主页链接
     * @param $content string
     * @return string
     */
    public static function contentReplaceAtUser($content, $model)
    {
        $model->atUsers = $usernames = static::parseUsername($content);
        foreach ($usernames as $username) {
            $content = str_replace("@$username", sprintf('[@%s](%s)', $username, Url::to(['/user/default/show', 'username' => $username])), $content);
        }

        return $content;
    }

    public static function parseUsername($content)
    {
        preg_match_all('/@(\S{4,255}) /', $content, $matches);
        if (empty($matches[1])) {
            return [];
        }
        $existUserRows = User::find()->where(['username' => $matches[1]])->select('id,username')->asArray()->all();
        return ArrayHelper::map($existUserRows, 'id', 'username') ?: [];
    }

    public static function contentReplaceTag($content)
    {
        $content = preg_replace_callback('/#(\S+?)#/', function ($matches) {
            $tagName = $matches[1];
            return sprintf('[%s](%s)', "#$tagName#", Url::to(['/tweet/default/index', 'topic' => $tagName]));
        }, $content);

        return $content;
    }

    /**
     * @param $params
     * @return array
     */
    public static function search($params)
    {
        $searchModel = new PostSearch();


        // 话题或者分类筛选
        empty($params['tag']) ?: $params['PostSearch']['tags'] = $params['tag'];
        if (isset($params['node'])) {
            $postMeta = PostMeta::findOne(['alias' => $params['node']]);
            ($postMeta) ? $params['PostSearch']['post_meta_id'] = $postMeta->id : null;
        }

        if (isset($params['tab'])) {
            $postMeta = PostMeta::findOne(['alias' => $params['tab']]);
            ($postMeta) ? $params['PostSearch']['post_meta_id'] = ArrayHelper::getColumn($postMeta->children, 'id') : null;
        }

        $dataProvider = $searchModel->search($params);
        $dataProvider->query->andWhere([Post::tableName() . '.type' => 'topic', 'status' => [Post::STATUS_ACTIVE, Post::STATUS_EXCELLENT]]);
        // 排序
        $sort = $dataProvider->getSort();
        $sort->attributes = array_merge($sort->attributes, [
            'hotest' => [
                'asc' => [
                    'view_count' => SORT_DESC,
                    'created_at' => SORT_DESC
                ],
            ],
            'excellent' => [
                'asc' => [
                    'status' => SORT_DESC,
                    'view_count' => SORT_DESC,
                    'created_at' => SORT_DESC
                ],
            ],
            'uncommented' => [
                'asc' => [
                    'comment_count' => SORT_ASC,
                    'created_at' => SORT_DESC
                ],
            ]
        ]);

        return ['searchModel' => $searchModel, 'dataProvider' => $dataProvider];
    }
}