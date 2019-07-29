<?php

namespace frontend\modules\topic\controllers;

use common\components\Controller;
use common\models\PostComment;
use common\models\PostMeta;
use common\models\Search;
use common\models\SearchLog;
use common\models\User;
use common\services\PostService;
use common\services\TopicService;
use frontend\modules\topic\models\Topic;
use frontend\modules\user\models\Donate;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    /**
     * @var integer 评论翻页
     */
    const PAGE_SIZE = 300;
    public $sorts = [
        'newest' => '最新',
        'excellent' => '优质',
        'hotest' => '热门',
//        'uncommented' => '未回答的'
    ];

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    // 默认只能Get方式访问
                    ['allow' => true, 'actions' => ['view', 'index', 'search', 'captcha'], 'verbs' => ['GET']],
                    // 登录用户才能提交回复或其他内容
                    ['allow' => true, 'actions' => ['api', 'view', 'delete'], 'verbs' => ['POST'], 'roles' => ['@']],
                    // 登录用户才能使用API操作(赞,踩,收藏)
                    ['allow' => true, 'actions' => ['create', 'update', 'revoke', 'excellent'], 'roles' => ['@']],
                ]
            ],
        ]);
    }


    /**
     * 话题列表
     * @return mixed
     */
    public function actionIndex()
    {
        // 话题或者分类筛选
        $params = Yii::$app->request->queryParams;
        $search = PostService::search($params);

        return $this->render('index', [
            'searchModel' => $search['searchModel'],
            'sorts' => $this->sorts,
            'dataProvider' => $search['dataProvider'],
            'nodes' => PostMeta::getNodes(),
        ]);
    }

    public function actionSearch()
    {
        $keyword = htmlspecialchars(Yii::$app->request->get('keyword'));
        if (empty($keyword)) {
            $this->goHome();
        }

        // 记录log
        $model = new SearchLog();
        $model->setAttributes([
            'user_id' => (Yii::$app->user->isGuest) ? '' : Yii::$app->user->identity->getId(),
            'keyword' => $keyword,
            'created_at' => time(),
        ]);
        $model->save();

        $id = ArrayHelper::getColumn(Search::search($keyword), 'topic_id') ?: 0;
        $search = PostService::search(['PostSearch' => ['id' => $id]]);

        return $this->render('index', [
            'searchModel' => $search['searchModel'],
            'sorts' => $this->sorts,
            'dataProvider' => $search['dataProvider'],
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

        //登录才能访问的节点内容
        if (\Yii::$app->user->isGuest && in_array($model->category->alias, params('loginNode'))) {
            $this->flash('查看本主题需要登录!', 'warning');
            return $this->redirect(['/site/login']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => PostComment::findCommentList($id),
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
            'sort' => ['defaultOrder' => ['created_at' => SORT_ASC]]
        ]);

        // 文章浏览次数
        Topic::updateAllCounters(['view_count' => 1], ['id' => $id]);

        //内容页面打赏
        if (in_array($model->category->alias, params('donateNode')) || array_intersect(explode(',', $model->tags),
                params('donateTag'))) {
            $donate = Donate::findOne(['user_id' => $model->user_id, 'status' => Donate::STATUS_ACTIVE]);
        }

        /** @var User $user */
        $user = Yii::$app->user->identity;
        $admin = ($user && ($user->isAdmin($user->username) || $user->isSuperAdmin($user->username))) ? true : false;

        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'comment' => new PostComment(),
            'admin' => $admin,
            'donate' => isset($donate) ? $donate : [],
        ]);
    }

    /**
     * 新建话题
     * @return mixed
     * @throws \yii\base\ExitException
     */
    public function actionCreate()
    {
        $model = new Topic();
        if ($time = $model->limitPostTime()) {
            $this->flash("发表文章失败!新注册用户只能回帖，{$time}秒之后才能发帖。", 'warning');
            return $this->redirect('index');
        }
        if ($time = $model->limitPostingIntervalTime()) {
            $this->flash("发表文章失败!请勿连续频繁发帖，{$time}秒之后才能发帖。", 'warning');
            return $this->redirect('index');
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $topService = new TopicService();
            if (!$topService->filterContent($model->title) || !$topService->filterContent($model->content)) {
                $model->addError('content', '请勿发表无意义的内容');
                return $this->redirect('create');
            }

            if ($model->save(false)) {
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
     * @throws \yii\base\ExitException
     */
    public function actionUpdate($id)
    {
        $model = Topic::findTopic($id);

        if (!($model && (User::getThrones() || $model->isCurrent()))) {
            throw new NotFoundHttpException;
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
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
        if (!($model && (User::getThrones() || $model->isCurrent()))) {
            throw new NotFoundHttpException;
        }

        if ($model->comment_count) {
            $this->flash("「{$model->title}」此文章已有回复，属于共有财产，不能删除", 'warning');
        } else {

            TopicService::delete($model);
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
        if (!($model && (User::getThrones() || $model->isCurrent()))) {
            throw new NotFoundHttpException;
        }
        TopicService::revoke($model);
        $this->flash("「{$model->title}」文章撤销删除成功。", 'success');
        return $this->redirect(['/topic/default/view', 'id' => $model->id]);
    }

    /**
     * 加精华
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionExcellent($id)
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;
        $model = Topic::findTopic($id);
        if ($user && ($user->isAdmin($user->username) || $user->isSuperAdmin($user->username))) {
            TopicService::excellent($model);
            $this->flash("操作成功", 'success');
            return $this->redirect(['/topic/default/view', 'id' => $model->id]);
        } else {
            throw new NotFoundHttpException();
        }
    }
}
