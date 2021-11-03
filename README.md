GetYii
==================

[![Latest Stable Version](https://poser.pugx.org/iiyii/getyii/v/stable)](https://packagist.org/packages/iiyii/getyii) 
[![Total Downloads](https://poser.pugx.org/iiyii/getyii/downloads)](https://packagist.org/packages/iiyii/getyii) 
[![Latest Unstable Version](https://poser.pugx.org/iiyii/getyii/v/unstable)](https://packagist.org/packages/iiyii/getyii) 
[![License](https://poser.pugx.org/iiyii/getyii/license)](https://packagist.org/packages/iiyii/getyii)

community for Yii2

## 说明

你现在看到的是全新版本的 GetYii 之前的版本我放在 V1 分支上面了，那个版本以后可能就不会更新了。
「doc/images」文件夹里面有截图，你们可以看一下。

全新的 GetYii 只专注于社区，现在基本功能已经 OK 了，以后我们会不断完善的。分享我们的 [trello 项目管理地址](https://trello.com/b/rsZAtG1Y/getyii)。

## 项目搭建

### 原始安装方法（推荐）

1、首先你要安装 [Composer](http://www.yiiframework.com/doc-2.0/guide-start-installation.html#installing-via-composer)，然后你需要手动去新建一个数据库，比方说新建 `getyii` 数据库，如果想使用 emoji 表情的话，意见使用 `utf8mb4` 编码格式，不想用的话，
建议使用 `utf8` 编码格式。

```
git clone https://github.com/iiYii/getyii.git
cd getyii
composer install
php init
```

2、然后修改数据库配置文件的配置信息

```
vim common/config/db.php
```

再使用运行我写的安装程序（帮你生成数据库表和假数据）

```
php yii install 
```

或者直接执行数据库迁移工具生成数据库表

```
php yii migrate 
```

### composer 安装方法（可能不是最新的）

1、首先你要安装 [Composer](http://www.yiiframework.com/doc-2.0/guide-start-installation.html#installing-via-composer)，然后你需要手动去新建一个数据库，比方说新建 `getyii` 数据库，如果想使用 emoji 表情的话，意见使用 `utf8mb4` 编码格式，不想用的话，
建议使用 `utf8` 编码格式。

```
composer create-project --prefer-dist --stability=dev iiyii/getyii getyii
cd getyii
php init
```

2、然后复制一份数据库配置，并且修改数据库配置，

```
cp common/config/db.php common/config/db-local.php
```

再使用运行我写的安装程序（帮你生成数据库表和假数据）

```
php yii install 
```

或者直接执行数据库迁移工具生成数据库表

```
php yii migrate 
```

### docker 搭建方法

1. 安装好 docker 保证可以运行 docker 和 docker-compose 命令
2. 克隆代码到你本地，并 cd 到相应目录
3. 启动 getyii 应用

$ cp docker-files/docker-compose-example.yml docker-compose.yml

$ docker-compose up -d

访问 getyii

添加以下两个域名加到自己机器的 host 里面

	<your_docker_ip> <your_name>.dev.getyii.com 前台
	<your_docker_ip> <your_name>.dev.admin.getyii.com 后台

### 用户相关

1. 把 user 表中的某用户值 role 字段值改为20，即为前台管理员，目前可以给帖子加精华，不能登录后台。
1. 把 user 表中的某用户值 role 字段值改为30，即为超级管理员，可登录后台。


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
![支付宝支付](https://raw.githubusercontent.com/iiYii/getyii/master/ali-pay.png)

手机微信或者支付宝扫描上方二维码可向本项目捐款


感谢以下这些朋友的资金支持，所得捐赠将用于改善网站服务器、购买开发/调试设备&工具。


捐赠人    | 金额 | 时间 | 说明
-------|------|------ | ------
张**  | 1.00  | 2015年7月7日 | http://asjmtz.com/
*作军  | 100.00 | 2015年08月07日 | dba-china
树*  | 333.00 | 2015年09月11日 | http://www.21cnjy.com/
*作军  | 300.00 | 2016年04月28日 | dba-china
*勇  | 20.00 | 2017年05月31日 | http://www.fecshop.com/
*勇  | 66.00 | 2017年12月21日 | http://www.fecshop.com/


## 他们正在使用 GetYii

- DBA-CHINA
- [Fecshop 社区](http://www.fecshop.com/)

## 感谢

- 感谢 [Ruby-China](https://github.com/ruby-china/ruby-china) 的开源代码。
- 感谢 [PHPHub](https://github.com/summerblue/phphub) 的开源代码。
- 感谢 [huajuan](https://github.com/callmez/huajuan) 的开源代码。
- 最后再感谢一下女朋友的支持 <(▰˘◡˘▰)>。

PS:

如果你暂时无法使用 `composer` 的话，访问链接: <http://pan.baidu.com/s/1eQnsn7s> 密码: ux6c 下载 zip 文件解压就可以用了。然后你要做的是：

- 新建数据库导入 getyii-2015-11-3.sql 数据库
- 修改 `common\config\db-local.php` 文件的数据库配置
- 默认用户名是`admin`，密码是`123456`
