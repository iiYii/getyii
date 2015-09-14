<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class InstallController extends Controller
{
    /**
     * 检查当前环境是否可用
     */
    public function actionCheck($path = '@root/requirements.php')
    {
        ob_start();
        ob_implicit_flush(false);
        require Yii::getAlias($path);
        $content = ob_get_clean();
        $content = str_replace('OK', $this->ansiFormat("OK", Console::FG_GREEN), $content);
        $content = str_replace('WARNING!!!', $this->ansiFormat("WARNING!!!", Console::FG_YELLOW), $content);
        $content = str_replace('FAILED!!!', $this->ansiFormat("FAILED!!!", Console::FG_RED), $content);
        $this->stdout($content);
    }

    /**
     * 项目安装 当代码第一次初始化后执行此命令可引导安装项目
     */
    public function actionIndex()
    {
        $lockFile = Yii::getAlias('@root/install.lock');
        if (!file_exists($lockFile)) {
            $result = $this->runSteps([
                '数据库配置' => 'db',
                '初始化数据库数据' => 'migrate'
            ]);
            if ($result) {
                $this->stdout("恭喜, 站点配置成功!\n", Console::FG_GREEN);
                touch($lockFile);
            }
        } else {
            $this->stdout("站点已经配置完毕,无需再配置\n", Console::FG_GREEN);
            $this->stdout(" - 如需重新配置, 请删除{$lockFile}文件后再执行命令!\n");
        }
    }

    public function runSteps(array $steps)
    {
        $i = 1;
        foreach ($steps as $step => $args) {
            $this->stdout("\n\n - Step {$i} {$step} \n");
            $this->stdout("==================================================\n");
            !is_array($args) && $args = (array)$args;
            $method = array_shift($args);
            $result = call_user_func_array([$this, 'action' . $method], $args);
            if ($result === false) {
                $this->stdout("{$step}失败, 退出安装流程\n", Console::FG_RED);
                return false;
            }
            $i++;
        }
        return true;
    }

    /**
     * 生成数据库配置文件
     * @return mixed
     */
    public function actionDb()
    {
        $dbFile = Yii::getAlias('@common/config/db-local.php');
        if (!file_exists($dbFile)) {
            $this->stdout("默认数据库配置文件未找到,将进入数据库配置创建流程\n", Console::FG_RED);
            $result = $this->generateDbFile($dbFile);
            if ($result !== false) { // 生成文件了之后.加载db配置
                Yii::$app->set('db', require $dbFile);
            }
            return $result;
        }
        $this->stdout("'{$dbFile}' 配置文件已存在, 无需配置\n");
    }

    /**
     * 创建数据库配置文件
     * @param $dbFile
     * @return mixed
     */
    public function generateDbFile($dbFile)
    {
        $host = $this->prompt('请输入数据库主机地址:', [
            'default' => 'localhost'
        ]);
        $dbName = $this->prompt('请输入数据库名称:', [
            'default' => 'getyii'
        ]);
        $dbConfig = [
            'dsn' => "mysql:host={$host};dbname={$dbName}",
            'username' => $this->prompt("请输入数据库访问账号:", [
                'default' => 'root'
            ]),
            'password' => $this->prompt("请输入数据库访问密码:"),
            'tablePrefix' => $this->prompt("请输入数据库表前缀（默认不使用）:", [
                'default' => ''
            ]),
            'charset' => $this->prompt("请输入数据默认的字符集:", [
                'default' => 'utf8mb4'
            ])
        ];

        $message = null;
        if ($this->confirm('是否测试数据库可用?', true)) {
            $db = Yii::createObject(array_merge([
                'class' => 'yii\db\Connection'
            ], $dbConfig));
            try {
                $db->open();
                $this->stdout("数据连接成功\n", Console::FG_GREEN);
            } catch (\Exception $e) {
                $this->stdout("数据连接失败:" . $e->getMessage() . "\n", Console::FG_RED);
                $message = '依然写入文件?(如果依然写入文件, 会影响后续安装步骤)';
            }
        }
        if ($message === null || $this->confirm($message)) {
            $this->stdout("生成数据库配置文件...\n");
            $code = <<<EOF
<?php
return [
    'class' => 'yii\db\Connection',
    'dsn' => '{$dbConfig['dsn']}',
    'username' => '{$dbConfig['username']}',
    'password' => '{$dbConfig['password']}',
    'tablePrefix' => '{$dbConfig['tablePrefix']}',
    'charset' => '{$dbConfig['charset']}',
];
EOF;
            file_put_contents($dbFile, $code);
            $this->stdout("恭喜! 数据库配置完毕!\n", Console::FG_GREEN);
        } elseif ($this->confirm("是否重新设置?", true)) {
            return $this->generateDbFile($dbFile);
        } else {
            return false;
        }
    }

    /**
     * 生成数据库结构和数据
     */
    public function actionMigrate()
    {
        $this->stdout("\n开始迁移数据库结构和数据\n", Console::FG_GREEN);
        $this->stdout("** 如无特殊需求,当询问是否迁移数据是回复yes既可 **\n", Console::FG_RED);
        // 默认迁移目录
        $migrationsPath = array(
            '默认目录' => Yii::getAlias('@console/migrations')
        );

        foreach ($migrationsPath as $name => $migrationPath) {
            if (!is_dir($migrationPath)) {
                continue;
            }
            $this->stdout("\n\n{$name}迁移: {$migrationPath}\n", Console::FG_YELLOW);
            Yii::$app->runAction('migrate/up', [
                'migrationPath' => $migrationPath
            ]);
        }
    }
}
