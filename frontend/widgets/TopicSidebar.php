<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/18 下午4:13
 * description:
 */

namespace frontend\widgets;

use common\helpers\Arr;
use common\models\PostMeta;
use common\models\RightLink;
use frontend\modules\topic\models\Topic;
use frontend\modules\article\models\Article;
use frontend\modules\user\models\Donate;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class TopicSidebar extends \yii\bootstrap\Widget
{
    public $type = 'node';
    public $node;
    public $tags;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $tipsModel = ArrayHelper::map(
            RightLink::find()->where(['type' => RightLink::RIGHT_LINK_TYPE_TIPS])->all(),
            'content',
            'title'
        );
        $tips = array_rand($tipsModel);

        $recommendResources = ArrayHelper::map(
            RightLink::find()->where(['type' => RightLink::RIGHT_LINK_TYPE_RSOURCES])->all(),
            'title',
            'url'
        );

        $links = RightLink::find()->where(['type' => RightLink::RIGHT_LINK_TYPE_LINKS])->all();

        $sameArticles = [];
        $sameTopics = [];
        if ($this->node) {
            $sameArticles = ArrayHelper::map(
                Article::find()
                    ->where('status >= :status', [':status' => Article::STATUS_ACTIVE])
                    ->andWhere(['post_meta_id' => $this->node->id, 'type' => 'article'])
                    ->orderBy('like_count DESC,view_count DESC')
                    ->limit(8)->all(),
                'title',
                function ($e) {
                    return Url::to(['/article/default/view', 'id' => $e->id]);
                }
            );
            $sameTopics = ArrayHelper::map(
                Article::find()
                    ->where('status >= :status', [':status' => Article::STATUS_ACTIVE])
                    ->andWhere(['post_meta_id' => $this->node->id, 'type' => 'topic'])
                    ->orderBy('comment_count DESC,view_count DESC')
                    ->limit(8)->all(),
                'title',
                function ($e) {
                    return Url::to(['/topic/default/view', 'id' => $e->id]);
                }
            );

            if ($this->type == 'view' && (in_array($this->node->alias, params('donateNode')) || array_intersect(explode(',', $this->tags), params('donateTag')))) {
                $donate = Donate::findOne(['user_id' => Topic::findOne(['id' => request()->get('id')])->user_id, 'status' => Donate::STATUS_ACTIVE]);
            }
        }
        else{
            $sameArticles = ArrayHelper::map(
                Article::find()
                    ->where('status >= :status', [':status' => Article::STATUS_ACTIVE])
                    ->andWhere(['type' => 'article'])
                    ->orderBy('like_count DESC,view_count DESC')
                    ->limit(8)->all(),
                'title',
                function ($e) {
                    return Url::to(['/article/default/view', 'id' => $e->id]);
                }
            );
            $sameTopics = ArrayHelper::map(
                Article::find()
                    ->where('status >= :status', [':status' => Article::STATUS_ACTIVE])
                    ->andWhere(['type' => 'topic'])
                    ->orderBy('comment_count DESC,view_count DESC')
                    ->limit(8)->all(),
                'title',
                function ($e) {
                    return Url::to(['/topic/default/view', 'id' => $e->id]);
                }
            );

        }

        return $this->render('topicSidebar', [
            'category' => PostMeta::blogCategory(),
            'config' => ['type' => $this->type, 'node' => $this->node],
            'sameTopics' => $sameTopics,
            'sameArticles' => $sameArticles,
            'tips' => $tips,
            'donate' => isset($donate) ? $donate : [],
            'recommendResources' => $recommendResources,
            'links' => $links,
        ]);
    }
}