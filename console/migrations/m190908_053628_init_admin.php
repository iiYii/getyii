<?php

use yii\helpers\Console;
use yii\db\Migration;

class m190908_053628_init_admin extends Migration
{
    public function up()
    {
        $this->createFounder();
    }

    public function down()
    {
        echo "m190908_053628_init_admin cannot be reverted.\n";

        return false;
    }

    /**
     * 创建创始人数据
     */
    public function createFounder()
    {
        Console::output("\n请先创建创始人账户:   ");

        $user = $this->saveFounderData(new \frontend\models\SignupForm());

        $user ? $user->id : 1; // 用户创建成功则指定用户id,否则指定id为1的用户为创始人.

        Console::output("创始人创建" . ($user ? '成功' : "失败,请手动创建创始人用户\n"));
    }

    /**
     * 用户创建交互
     * @param $_model
     * @return mixed
     */
    private function saveFounderData($_model)
    {
        /** @var \frontend\models\SignupForm $model */
        $model = clone $_model;
        $model->username = Console::prompt('请输入创始人用户名', ['default' => 'admin']);
        $model->email = Console::prompt('请输入创始人邮箱', ['default' => 'admin@admin.com']);
        $model->password = Console::prompt('请输入创始人密码', ['default' => '123456']);
        $model->role = \common\models\User::ROLE_SUPER_ADMIN;

        if (!($user = $model->signup())) {
            Console::output(Console::ansiFormat("\n输入数据验证错误:", [Console::FG_RED]));
            foreach ($model->getErrors() as $k => $v) {
                Console::output(Console::ansiFormat(implode("\n", $v), [Console::FG_RED]));
            }
            if (Console::confirm("\n是否重新创建创始人账户:")) {
                $user = $this->saveFounderData($_model);
            }
        }
        return $user;
    }
}
