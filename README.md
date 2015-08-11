## 说明

你现在看到的是全新版本的 GetYii 之前的版本我放在 V1 分支上面了，那个版本以后可能就不会更新了。
「doc/images」文件夹里面有截图，你们可以看一下。

全新的 GetYii 只专注于社区，现在基本功能已经 OK 了，以后我们会不断完善的。

## 项目搭建

1. 本项目是基于 [Yii2 ](https://github.com/yiisoft/yii2) 高级应用模板开发的，参考文档 [高级应用模板](http://yii2.xlbd.net/web/index.php/guide/3.html)。
1. 配置环境的时候你要配置两个虚拟目录，对于前台指定 `frontend/web/` ，访问URL为 `http://www.xxx.com/` (域名自己随便配置)
1. 对于后台指定 `backend/web/` ，访问URL为 `http://admin.xxx.com/` (域名自己随便配置)
1. git clone 一份代码之后要在项目根目录下在终端运行 `php init` 初始化一下。
1. 手动新建一个数据库名为 getyii，然后更该 `common/config/main.php` 里面的 `dbname=getyii`。
1. 在终端输入命令 `curl -sS https://getcomposer.org/installer | php` 安装 PHP 的 [Composer](http://docs.phpcomposer.com/download/)。
1. 在终端输入命令 `mv composer.phar /usr/local/bin/composer` 添加环境变量。
1. 在终端输入命令 `composer global require "fxp/composer-asset-plugin:~1.0"` 安装 [composer-asset-plugin](https://github.com/francoispluchino/composer-asset-plugin) 来管理静态资源文件。
1. 最后在终端输入命令 `composer install` 更新包。
1. 在终端输入命令 `yii migrate` (windows下面可能是 `php yii migrate` 命令)初始化数据。
1. 把 user 表中的某用户值 role 字段值改为20，即为前台管理员，目前可以给帖子加精华，不能登录后台。
1. 把 user 表中的某用户值 role 字段值改为30，即为超级管理员，可登录后台。


~~1. 在终端输入命令 `yii migrate --migrationPath=@funson86/setting/migrations` 初始化数据。~~


## 文档和手册

1. [Yii2手册](http://book.getyii.com)
2. [中文 Composer 手册](http://docs.phpcomposer.com/)


## 安装遇到问题怎么办?

建议在官网的[社区版块](http://www.getyii.com/topic/default/create)**新手提问**下面提问，我会抽空亲自回答。请最大可能的把问题描述清楚，以免浪费我们彼此的时间。

## 交流群

- Yii2 中国交流群：343188481
- Get√Yii 开发者群：321493381

## 捐赠

![微信支付](https://raw.githubusercontent.com/iiYii/getyii/master/wechat-pay.png)

手机微信扫描上方二维码可向本项目捐款


感谢以下这些朋友的资金支持，所得捐赠将用于改善网站服务器、购买开发/调试设备&工具。


捐赠人    | 金额 | 时间 | 说明
-------|------|------ | ------
张**  | 1.00  | 2015年7月7日 | http://iamtutu.com/
*作军  | 100.00 | 2015年08月07日 | http://www.dba-china.com/


## 感谢

- 感谢 [Ruby-China](https://github.com/ruby-china/ruby-china) 的开源代码。
- 感谢 [PHPHub](https://github.com/summerblue/phphub) 的开源代码。
- 感谢 [huajuan](https://github.com/callmez/huajuan) 的开源代码。
- 最后再感谢一下女朋友的支持 <(▰˘◡˘▰)>。

PS:

如果你暂时无法使用 `composer` 的话，访问 <http://git.oschina.net/forecho/getyii-vendor> 下载 zip 文件解压就可以用了。
但是本人不推荐这种做法。
