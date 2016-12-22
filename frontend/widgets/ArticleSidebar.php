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
use frontend\modules\article\models\Article;
use frontend\modules\topic\models\Topic;
use frontend\modules\user\models\Donate;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class ArticleSidebar extends \yii\bootstrap\Widget
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

        $links = RightLink::find()->where(['type' => RightLink::RIGHT_LINK_TYPE_LINKS])->all();

        $sameArticles = [];
        if ($this->node) {
            $sameArticles = ArrayHelper::map(
                Article::find()
                    ->where('status >= :status', [':status' => Article::STATUS_ACTIVE])
                    ->andWhere(['post_meta_id' => $this->node->id, 'type' => 'article'])
                    ->limit(200)->all(),
                'title',
                function ($e) {
                    return Url::to(['/article/default/view', 'id' => $e->id]);
                }
            );
            if (count($sameArticles) > 10) {
                $sameArticles = Arr::arrayRandomAssoc($sameArticles, 8);
            }

            if ($this->type == 'view' && (in_array($this->node->alias, params('donateNode')) || array_intersect(explode(',', $this->tags), params('donateTag')))) {
                $donate = Donate::findOne(['user_id' => Topic::findOne(['id' => request()->get('id')])->user_id, 'status' => Donate::STATUS_ACTIVE]);
            }
        }

        return $this->render('articleSidebar', [
            'category' => PostMeta::blogCategory(),
            'config' => ['type' => $this->type, 'node' => $this->node],
            'sameArticles' => $sameArticles,
            'links' => $links,
        ]);
    }
}