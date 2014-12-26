## 项目搭建

* 本项目是基于 [Yii2 ](https://github.com/yiisoft/yii2) 高级应用模板开发的，参考文档 [高级应用模板](http://yii2.xlbd.net/web/index.php/guide/3.html)。
* 配置环境的时候你要配置两个虚拟目录，对于前台指定 `frontend/web/` ，访问URL为 `http://www.xxx.com/` (域名自己随便配置)
* 对于后台指定 `backend/web/` ，访问URL为 `http://admin.xxx.com/` (域名自己随便配置)
* git clone 一份代码之后要在项目根目录下在终端运行 `php init` 初始化一下。
* 手动新建一个数据库名为 vfanr，然后更该 `common/config/main-local.php` 里面的 `dbname=vafanr`。
* 使用命令行命令 `yii migrate` (windows下面可能是 `php yii migrate` 命令)初始化数据。


## 文档和手册

* 手册：[http://yii2.xlbd.net/web/index.php/guide/1.html](http://yii2.xlbd.net/web/index.php/guide/1.html)
* 代码当中没有vender，可以使用打开DOS命令到项目的根目录里面执行：`php composer.phar update` 然后就有vender目录了【前提：当前目录里面有composer.phar，可以看手册里面】