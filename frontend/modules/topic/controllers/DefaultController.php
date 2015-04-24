<?php

namespace frontend\modules\topic\controllers;

use common\models\Post;
use common\services\NotificationService;
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
        'newest' => '最新的',
        'hotest' => '热门的',
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
                    ['allow' => true, 'actions' => ['view', 'index'], 'verbs' => ['GET']],
                    // 登录用户才能提交评论或其他内容
                    ['allow' => true, 'actions' => ['api', 'view', 'delete'], 'verbs' => ['POST'], 'roles' => ['@']],
                    // 登录用户才能使用API操作(赞,踩,收藏)
                    ['allow' => true, 'actions' => ['create', 'update', 'revoke'], 'roles' => ['@']],
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
        $params = Yii::$app->request->queryParams;
        $params['PostSearch']['type'] = 'topic';
        $params['PostSearch']['status'] = 1;
        // 话题筛选
        if (isset($params['tag']) && $params['tag'] != 'index') {
            $postMeta = PostMeta::findOne(['alias' => $params['tag']]);
            $params['PostSearch']['post_meta_id'] = $postMeta->id;
        }
        $dataProvider = $searchModel->search($params);
        // 排序
        $sort = $dataProvider->getSort();
        $sort->attributes = array_merge($sort->attributes, [
            'hotest' => [
                'asc' => [
                    'comment_count' => SORT_DESC,
                    'created_at' => SORT_DESC
                ],
                'desc' => [
                    'comment_count' => SORT_DESC,
                    'created_at' => SORT_DESC
                ]
            ],
            'uncommented' => [
                'asc' => [
                    'comment_count' => SORT_ASC,
                    'created_at' => SORT_DESC
                ],
                'desc' => [
                    'comment_count' => SORT_ASC,
                    'created_at' => SORT_DESC
                ]
            ]
        ]);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'sorts'  => $this->sorts,
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
            'query' => PostComment::findCommentList($id),
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
        ]);

        // 文章浏览次数
        Topic::updateAllCounters(['view_count' => 1], ['id' => $id]);

        return $this->render('view', [
            'model'        => $model,
            'dataProvider' => $dataProvider,
            'comment'      => $comment,
        ]);
    }

    /**
     * 新建话题
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Topic();
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->type = 'topic';
            if ($model->tags = Yii::$app->request->post('tags')) {
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

        if ($model->load(Yii::$app->request->post())) {
            $model->tags = Yii::$app->request->post('tags');
            $model->addTags(explode(',', $model->tags));
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
        if(!$model->isCurrent()){
            throw new NotFoundHttpException();
        }
        // 启用事物
        $transaction = \Yii::$app->db->beginTransaction();
        $updateTopic = $model->updateCounters(['status' => -1]);
        $updateNotify = Notification::updateAll(['status' => 0], ['post_id' => $model->id]);
        if ($updateNotify && $updateTopic) {
            $transaction->commit();
        } else {
            $transaction->rollback();
        }
        $revoke = Html::a('撤消', ['/topic/default/revoke', 'id' => $model->id]);
        $this->flash("「{$model->title}」文章删除成功。 反悔了？{$revoke}", 'success');
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
        if(!$model->isCurrent()){
            throw new NotFoundHttpException();
        }
        $model->updateCounters(['status' => 1]);
        $this->flash("「{$model->title}」文章撤销删除成功。", 'success');
        return $this->redirect(['/topic/default/view', 'id' => $model->id]);
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
}
