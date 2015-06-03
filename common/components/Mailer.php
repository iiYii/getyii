<?php

namespace common\components;

use yii\base\Component;

class Mailer extends Component
{
    /** @var string */
    public $viewPath = '@dektrium/user/views/mail';
    /** @var string|array */
    public $sender = 'no-reply@example.com';
    /** @var string */
    public $welcomeSubject;
    /** @var string */
    public $confirmationSubject;
    /** @var string */
    public $reconfirmationSubject;
    /** @var string */
    public $recoverySubject;

    public function init()
    {
        parent::init();
        \Yii::$app->set('mailer', [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => \Yii::$app->setting->get('smtpHost'),
                'username' => \Yii::$app->setting->get('smtpUser'),
                'password' => \Yii::$app->setting->get('smtpPassword'),
                'port' => \Yii::$app->setting->get('smtpPort'),
                // 'mail' => \Yii::$app->setting->get('smtpMail'), // 显示地址
                'encryption' => 'tls',
            ],
        ]);
    }

    /**
     * Sends an email to a user with credentials and confirmation link.
     *
     * @param  User $user
     * @param  Token $token
     * @return bool
     */
    public function sendWelcomeMessage(User $user, Token $token = null)
    {
        return $this->sendMessage($user->email,
            $this->welcomeSubject,
            'welcome',
            ['user' => $user, 'token' => $token]
        );
    }

    /**
     * @param  string $to
     * @param  string $subject
     * @param  string $view
     * @param  array $params
     * @return bool
     */
    protected function sendMessage($to, $subject, $view, $params = [])
    {
        $mailer = \Yii::$app->mailer;
        $mailer->viewPath = $this->viewPath;
        $mailer->getView()->theme = \Yii::$app->view->theme;

        return $mailer->compose(['html' => $view, 'text' => 'text/' . $view], $params)
            ->setTo($to)
            ->setFrom($this->sender)
            ->setSubject($subject)
            ->send();
    }

    /**
     * Sends an email to a user with confirmation link.
     *
     * @param  User $user
     * @param  Token $token
     * @return bool
     */
    public function sendConfirmationMessage(User $user, Token $token)
    {
        return $this->sendMessage($user->email,
            $this->confirmationSubject,
            'confirmation',
            ['user' => $user, 'token' => $token]
        );
    }

    /**
     * Sends an email to a user with reconfirmation link.
     *
     * @param  User $user
     * @param  Token $token
     * @return bool
     */
    public function sendReconfirmationMessage(User $user, Token $token)
    {
        if ($token->type == Token::TYPE_CONFIRM_NEW_EMAIL) {
            $email = $user->unconfirmed_email;
        } else {
            $email = $user->email;
        }
        return $this->sendMessage($email,
            $this->reconfirmationSubject,
            'reconfirmation',
            ['user' => $user, 'token' => $token]
        );
    }

    /**
     * Sends an email to a user with recovery link.
     *
     * @param  User $user
     * @param  Token $token
     * @return bool
     */
    public function sendRecoveryMessage(User $user, Token $token)
    {
        return $this->sendMessage($user->email,
            $this->recoverySubject,
            'recovery',
            ['user' => $user, 'token' => $token]
        );
    }
}