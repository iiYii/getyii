<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/19 下午3:20
 * description:
 */

namespace common\services;


use common\models\Post;
use frontend\models\Notification;

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
     */
    public function filterContent($content)
    {
        $content = strtolower($content);
        $content = trim($content);
        $data = ['test', '测试'];
        if (in_array($content, $data)) {
            return false;
        }
        $action = ['+1', '赞', '很赞', '喜欢', '收藏', 'mark', '写的不错', '不错', '给力'];
        if (in_array($content, $action)) {
            return false;
        }
        return true;
    }
}