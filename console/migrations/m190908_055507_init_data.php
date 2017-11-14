<?php

use yii\db\Migration;
use yii\helpers\Console;
use frontend\modules\topic\models\Topic;
use common\models\PostComment;
use common\models\PostMeta;
use common\models\User;
use common\models\UserInfo;
use yii\db\Exception;

class m190908_055507_init_data extends Migration
{
    public function up()
    {
        if (Console::confirm('是否生成测试问题数据?', true)) {
            $this->generateFakeData(rand(20, 100));
        }
    }

    public function down()
    {
        echo "m190908_055507_init_data cannot be reverted.\n";

        return false;
    }


    public function generateFakeData($num)
    {
        Console::startProgress(0, 100);
        $topic = new Topic();
        $comment = new PostComment();
        $node = new PostMeta();

        $faker = Faker\Factory::create('zh_CN');
        $nodeData = [
            ['name' => '分享', 'alias' => '', 'parent' => 0],
            ['name' => '招聘', 'alias' => 'jobs', 'parent' => 1],
            ['name' => '瞎扯淡', 'alias' => 'booshit', 'parent' => 1],
            ['name' => '健康', 'alias' => 'health', 'parent' => 1],
            ['name' => '创业', 'alias' => 'startup', 'parent' => 1],
        ];
        $transaction = Yii::$app->db->beginTransaction();
        try {
            for ($j = 0; $j < count($nodeData); $j++) {
                $_node = clone $node;
                $_node->setAttributes($nodeData[$j] + ['type' => 'topic_category']);
                $_node->save();
            }

            $this->execute("INSERT INTO {{%merit_template}} (`id`, `type`, `title`, `unique_id`, `method`, `event`, `action_type`, `rule_key`, `rule_value`, `increment`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '登录', 'site/login', 2, 0, 2, 1, 1, 2, 1, 1458657160, 1458823425),
(2, 1, '发帖', 'topic/default/create', 2, 0, 2, 0, NULL, 6, 1, 1458657218, 1458657218),
(3, 1, '回复', 'topic/comment/create', 2, 0, 2, 0, NULL, 4, 1, 1458657251, 1458657251),
(4, 1, '发动弹', 'tweet/default/create', 2, 0, 2, 0, NULL, 4, 1, 1458657296, 1468647701);
");
            /** @var User $user */
            $user = User::find()->where(['role' => User::ROLE_SUPER_ADMIN])->one();
            Yii::$app->user->setIdentity($user);
            for ($i = 1; $i <= $num; $i++) {
                $_topic = clone $topic;
                $_topic->setAttributes([
                    'type' => Topic::TYPE,
                    'title' => $faker->text(rand(10, 50)),
                    'post_meta_id' => rand(2, 4),
                    'status' => rand(1, 2),
                    'content' => $faker->text(rand(100, 2000)),
                    'user_id' => 1
                ]);
                if (!$_topic->save()) {
                    throw new Exception(array_values($_topic->getFirstErrors())[0]);
                }

                for ($_i = 1; $_i <= rand(1, 20); $_i++) {
                    $_comment = clone $comment;
                    $_comment->setAttributes([
                        'comment' => $faker->text(rand(100, 2000)),
                        'post_id' => $_topic->id,
                        'ip' => '127.0.0.1',
                        'user_id' => 1
                    ]);
                    if (!$_comment->save()) {
                        throw new Exception(array_values($_comment->getFirstErrors())[0]);
                    }

                    // 更新回复时间
                    $_topic->lastCommentToUpdate($user['username']);
                    // 评论计数器
                    Topic::updateAllCounters(['comment_count' => 1], ['id' => $_topic->id]);
                    // 更新个人总统计
                    UserInfo::updateAllCounters(['comment_count' => 1], ['user_id' => $_topic->user_id]);
                }
                Console::updateProgress($i / $num * 100, 100);
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        Console::endProgress();
    }
}
