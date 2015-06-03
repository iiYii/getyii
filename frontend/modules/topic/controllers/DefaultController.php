<?php

namespace frontend\modules\topic\controllers;

use common\models\Post;
use common\models\User;
use common\services\NotificationService;
use common\services\TopicService;
use frontend\models\Notification;
use frontend\modules\topic\models\Topic;
use frontend\modules\user\models\UserMeta;
use Yii;
use yii\filters\AccessControl;
use common\models\PostSearch;
use common\models\PostComment;
use common\models\PostMeta;
use common\models\UserInfo;
use common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

class DefaultController extends Controller
{
    const PAGE_SIZE = 50;
    public $sorts = [
        'newest'      => '最新的',
        'excellent'   => '优质主题',
        'hotest'      => '热门的',
        'uncommented' => '未回答的'
    ];

    public function behaviors()
    {
        return [
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    // 默认只能Get方式访问
                    ['allow' => true, 'actions' => ['view', 'index', 'sync'], 'verbs' => ['GET']],
                    // 登录用户才能提交评论或其他内容
                    ['allow' => true, 'actions' => ['api', 'view', 'delete'], 'verbs' => ['POST'], 'roles' => ['@']],
                    // 登录用户才能使用API操作(赞,踩,收藏)
                    ['allow' => true, 'actions' => ['create', 'update', 'revoke', 'excellent'], 'roles' => ['@']],
                ]
            ]
        ];
    }

    /**
     * 话题列表
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $conditions['type'] = 'topic';
        $conditions['status'] = [1, 2];

        // 话题或者分类筛选
        $params = Yii::$app->request->queryParams;
        empty($params['tag']) ?: $params['PostSearch']['tags'] = $params['tag'];
        if (isset($params['node'])) {
            $postMeta = PostMeta::findOne(['alias' => $params['node']]);
            ($postMeta) ? $params['PostSearch']['post_meta_id'] = $postMeta->id : '';
        }

        $dataProvider = $searchModel->search($params, $conditions);
        // 排序
        $sort = $dataProvider->getSort();
        $sort->attributes = array_merge($sort->attributes, [
            'hotest'      => [
                'asc' => [
                    'comment_count' => SORT_DESC,
                    'created_at'    => SORT_DESC
                ],
            ],
            'excellent'   => [
                'asc' => [
                    'status'        => SORT_DESC,
                    'comment_count' => SORT_DESC,
                    'created_at'    => SORT_DESC
                ],
            ],
            'uncommented' => [
                'asc' => [
                    'comment_count' => SORT_ASC,
                    'created_at'    => SORT_DESC
                ],
            ]
        ]);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'sorts'        => $this->sorts,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 话题详细页
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = Topic::findTopic($id);
        $comment = $this->newComment($model);
        $dataProvider = new ActiveDataProvider([
            'query'      => PostComment::findCommentList($id),
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
        ]);

        // 文章浏览次数
        Topic::updateAllCounters(['view_count' => 1], ['id' => $id]);

        $user = Yii::$app->user->identity;
        $admin = ($user && ($user->isAdmin($user->username) || $user->isSuperAdmin($user->username))) ? true : false;

        return $this->render('view', [
            'model'        => $model,
            'dataProvider' => $dataProvider,
            'comment'      => $comment,
            'admin'        => $admin,
        ]);
    }

    /**
     * 新建话题
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Topic();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $topService = new TopicService();
            if (!$topService->filterContent($model->title) || !$topService->filterContent($model->content)) {
                $this->flash('请勿发表无意义的内容', 'warning');
                return $this->redirect('create');
            }
            $model->user_id = Yii::$app->user->id;
            $model->type = 'topic';
            if ($model->tags) {
                $model->addTags(explode(',', $model->tags));
            }
            if ($model->save()) {
                (new UserMeta)->saveNewMeta('topic', $model->id, 'follow');
                // 更新个人总统计
                UserInfo::updateAllCounters(['post_count' => 1], ['user_id' => $model->user_id]);
                $this->flash('发表文章成功!', 'success');
                return $this->redirect(['view', 'id' => $model->id]);
            }

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 修改自己的话题
     * @param integer $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = Topic::findTopic($id);

        if ($model === null || !$model->isCurrent()) {
            throw new NotFoundHttpException;
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->tags) {
                $model->addTags(explode(',', $model->tags));
            }
            if ($model->save()) {
                $this->flash('发表更新成功!', 'success');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 伪删除
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $model = Topic::findTopic($id);
        if (!$model->isCurrent()) {
            throw new NotFoundHttpException();
        }
        if ($model->comment_count) {
            $this->flash("「{$model->title}」此文章已有评论，属于共有财产，不能删除", 'warning');
        } else {
            $model->updateAttributes(['status' => 0]);
            Notification::updateAll(['status' => 0], ['post_id' => $model->id]);
            $revoke = Html::a('撤消', ['/topic/default/revoke', 'id' => $model->id]);
            $this->flash("「{$model->title}」文章删除成功。 反悔了？{$revoke}", 'success');
        }

        return $this->redirect(['index']);
    }

    /**
     * 撤消删除
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionRevoke($id)
    {
        $model = Topic::findDeletedTopic($id);
        if (!$model->isCurrent()) {
            throw new NotFoundHttpException();
        }
        $model->updateCounters(['status' => 1]);
        $this->flash("「{$model->title}」文章撤销删除成功。", 'success');
        return $this->redirect(['/topic/default/view', 'id' => $model->id]);
    }

    /**
     * 伪删除
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionExcellent($id)
    {
        $user = Yii::$app->user->identity;
        $model = Topic::findTopic($id);
        if ($user && ($user->isAdmin($user->username) || $user->isSuperAdmin($user->username))) {
            $action = ($model->status == Topic::STATUS_ACTIVE) ? Topic::STATUS_GOOD : Topic::STATUS_ACTIVE;
            $model->updateAttributes(['status' => $action]);
            $this->flash("操作成功", 'success');
            return $this->redirect(['/topic/default/view', 'id' => $model->id]);
        } else {
            throw new NotFoundHttpException();
        }
    }

    /**
     * 创建评论
     * @param Post $post
     * @return array|PostComment|string
     */
    protected function newComment(Post $post)
    {
        $model = new PostComment();
        if ($model->load(Yii::$app->request->post())) {
            $topService = new TopicService();
            if (!$topService->filterContent($model->comment)) {
                $this->flash('回复内容请勿回复无意义的内容，如你想收藏或赞等功能，请直接操作这篇帖子。', 'warning');
                return $this->redirect(['view', 'id' => $post->id]);
            }
            $model->user_id = Yii::$app->user->id;
            $model->post_id = $post->id;
            $model->ip = Yii::$app->getRequest()->getUserIP();
            $rawComment = $model->comment;
            $model->comment = $model->replace($rawComment);
            if ($model->save()) {
                (new UserMeta)->saveNewMeta('topic', $post->id, 'follow');
                (new NotificationService)->newReplyNotify(Yii::$app->user->identity, $post, $model, $rawComment);
                // 评论计数器
                Topic::updateAllCounters(['comment_count' => 1], ['id' => $post->id]);
                // 更新个人总统计
                UserInfo::updateAllCounters(['comment_count' => 1], ['user_id' => $model->user_id]);

                $this->flash("评论成功", 'success');
                return $this->redirect(['view', 'id' => $post->id]);
            }
        }
        return $model;
    }


    public function actionSync()
    {
        UserInfo::updateAll(['thanks_count' => 0, 'like_count' => 0, 'hate_count' => 0]);
        $meta = UserMeta::find()->all();
        foreach ($meta as $key => $value) {
            if (in_array($value->type, ['thanks', 'like', 'hate'])) {
                switch ($value->target_type) {
                    case 'topic':
                    case 'post':
                        echo '同步文章操作</br>';
                        $topic = Topic::findOne($value->target_id);
                        UserInfo::updateAllCounters([$value->type . '_count' => 1], ['user_id' => $topic->user_id]);
                        break;
                    case 'comment':
                        echo '同步评论操作</br>';
                        $comment = PostComment::findOne($value->target_id);
                        UserInfo::updateAllCounters([$value->type . '_count' => 1], ['user_id' => $comment->user_id]);
                        break;

                    default:
                        # code...
                        break;
                }
            }

        }
        return;
    }
}
