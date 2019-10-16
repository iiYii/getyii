<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->username ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?php
            $debugMenu = [];
            if (!YII_ENV_TEST) {
                $debugMenu = [
                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    [
                        'label' => 'Same tools',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']]
                        ],
                    ]
                ];
            }
        ?>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree','data-widget'=>'tree'],
                'items' => array_merge([
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
                    ['label' => '用户管理', 'icon' => 'users', 'url' => ['/user/index']],
                    ['label' => '文章管理', 'icon' => 'comment-o', 'url' => ['/post/index']],
                    ['label' => '分类管理', 'icon' => 'th-list', 'url' => ['/post-meta']],
                    ['label' => '网站配置', 'icon' => 'cog', 'url' => ['/setting/default']],
                    [
                        'label' => '网站导航', 'url' => '#', 'icon' => 'share',
                        'items' => [
                            ['label' => '导航分类', 'icon' => 'plane', 'url' => ['/nav/index']],
                            ['label' => '导航链接', 'icon' => 'plane', 'url' => ['/nav-url/index']],
                        ]
                    ],
                    [
                        'label' => '积分模块', 'url' => '#', 'icon' => 'share',
                        'items' => [
                            ['label' => '积分模板', 'icon' => 'money', 'url' => ['/merit/merit-template']],
                            ['label' => '会员积分', 'icon' => 'money', 'url' => ['/merit/merit']],
                            ['label' => '积分日志', 'icon' => 'money', 'url' => ['/merit/merit-log']],
                        ]
                    ],
                    ['label' => '搜索日志', 'icon' => 'search', 'url' => ['/search-log/index']],
                    ['label' => '右边栏设置', 'icon' => 'diamond', 'url' => ['/right-link/index']],
                ], $debugMenu),
            ]
        ) ?>

    </section>

</aside>
