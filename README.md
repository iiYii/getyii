## 说明

你现在看到的是全新版本的 GetYii 之前的版本我放在 V1 分支上面了，那个版本以后可能就不会更新了。
「doc/images」文件夹里面有截图，你们可以看一下。

全新的 GetYii 只专注于社区，现在基本功能已经 OK 了，以后我们会不断完善的。

## 项目搭建

1. 本项目是基于 [Yii2 ](https://github.com/yiisoft/yii2) 高级应用模板开发的，参考文档 [高级应用模板](http://yii2.xlbd.net/web/index.php/guide/3.html)。
2. 配置环境的时候你要配置两个虚拟目录，对于前台指定 `frontend/web/` ，访问URL为 `http://www.xxx.com/` (域名自己随便配置)
3. 对于后台指定 `backend/web/` ，访问URL为 `http://admin.xxx.com/` (域名自己随便配置)
4. git clone 一份代码之后要在项目根目录下在终端运行 `php init` 初始化一下。
5. 手动新建一个数据库名为 vfanr，然后更该 `common/config/main-local.php` 里面的 `dbname=vfanr`。
6. 在终端输入命令 `yii migrate` (windows下面可能是 `php yii migrate` 命令)初始化数据。
7. 在终端输入命令 `curl -sS https://getcomposer.org/installer | php` 安装 PHP 的 [Composer](http://docs.phpcomposer.com/download/)。
8. 在终端输入命令 `mv composer.phar /usr/local/bin/composer` 添加环境变量。
9. 在终端输入命令 `composer global require "fxp/composer-asset-plugin:~1.0"` 安装 [composer-asset-plugin](https://github.com/francoispluchino/composer-asset-plugin) 来管理静态资源文件。
10. 最后在终端输入命令 `composer update` 更新包。
10. 把 user 表中的某用户值 role 字段值改为20，即可登录后台。


~~1. 在终端输入命令 `yii migrate --migrationPath=@funson86/setting/migrations` 初始化数据。~~


## 文档和手册

1. [Yii2手册](http://book.getyii.com)
2. [中文 Composer 手册](http://docs.phpcomposer.com/)


## 安装遇到问题怎么办?

建议在官网的[社区版块](http://www.getyii.com/topic/default/create)**新手提问**下面提问，我会抽空亲自回答。请最大可能的把问题描述清楚，以免浪费我们彼此的时间。

## 交流群

- Yii2 中国交流群：343188481
- Get√Yii 核心开发者群：321493381（本群只接受参与本站开发的 Yiier）