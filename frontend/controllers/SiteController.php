<?php
namespace frontend\controllers;

use common\helpers\Arr;
use common\models\Post;
use common\models\PostComment;
use common\models\PostTag;
use common\models\RightLink;
use common\models\Session;
use common\services\UserService;
use dosamigos\qrcode\QrCode;
use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use common\components\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use frontend\modules\user\models\UserAccount;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return Arr::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'connect'],
                'rules' => [
                    ['actions' => ['signup', 'connect'], 'allow' => true, 'roles' => ['?']],
                    ['actions' => ['logout'], 'allow' => true, 'roles' => ['@']],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => ['logout' => ['post']],
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $topics = Post::find()->limit(20)->where(['status' => 2])->orderBy(['created_at' => SORT_DESC])->all();
        $users = UserService::findActiveUser(12);
        $headline = Arr::getColumn(RightLink::find()->where(['type' => RightLink::RIGHT_LINK_TYPE_HEADLINE])->all(), 'content');

        $statistics = [];
        $statistics['post_count'] = Post::find()->count();
        $statistics['comment_count'] = PostComment::find()->count();
        $statistics['online_count'] = Session::find()->where(['>', 'expire', time()])->count();

        return $this->render('index', [
            'topics' => $topics,
            'users' => $users,
            'statistics' => $statistics,
            'headline' => Arr::arrayRandomAssoc($headline),
        ]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionTags()
    {
        $tags = PostTag::find()->orderBy('updated_at DESC')->all();

        return $this->render('tags', [
            'tags' => $tags,
        ]);
    }

    public function actionContributors()
    {
        return $this->render('contributors');
    }

    public function actionGetstart()
    {
        return $this->render('getstart');
    }

    public function actionUsers()
    {
        $model = UserService::findActiveUser(100);
        $count = User::find()->where(['status' => 10])->count();
        return $this->render('users', [
            'model' => $model,
            'count' => $count,
        ]);
    }

    public function actionAtUsers()
    {
        $model = UserService::findActiveUser(400);
        return Json::encode(Arr::getColumn($model, 'username'));
    }

    public function actionBook()
    {
        return $this->redirect('http://book.getyii.com');
    }

    public function actionMarkdown()
    {
        return $this->render('markdown');
    }

    public function actionTimeline()
    {
        return $this->render('timeline');
    }

    /**
     * Displays page where user can create new account that will be connected to social account.
     * @param  integer $account_id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionConnect($account_id)
    {
        $account = UserAccount::find()->where(['id' => $account_id])->one();

        if ($account === null || $account->getIsConnected()) {
            throw new NotFoundHttpException;
        }
        $accountData = \yii\helpers\Json::decode($account->data);

        $model = new SignupForm();
        $model->username = $accountData['login'];
        $model->email = empty($accountData['email']) ? '' : $accountData['email'];

        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                $account->user_id = $user->id;
                $account->save(false);
                if (Yii::$app->getUser()->login($user, 1209600)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionQrcode($url = '')
    {
        return QrCode::png($url);
    }

    public function actionSignup()
    {
        $model = new SignupForm();

        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Performs ajax validation.
     * @param Model $model
     * @throws \yii\base\ExitException
     */
    protected function performAjaxValidation($model)
    {
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            echo json_encode(\yii\widgets\ActiveForm::validate($model));
            Yii::$app->end();
        }
    }
}
