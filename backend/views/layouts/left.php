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
                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']]
                        ],
                    ]
                ];
            }
        ?>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => array_merge([
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
                    ['label' => '用户管理', 'icon' => 'fa fa-users', 'url' => ['/user/index']],
                    ['label' => '文章管理', 'icon' => 'fa fa-comment-o', 'url' => ['/post/index']],
                    ['label' => '分类管理', 'icon' => 'fa fa-th-list', 'url' => ['/post-meta']],
                    ['label' => '网站配置', 'icon' => 'fa fa-cog', 'url' => ['/setting/default']],
                    [
                        'label' => '网站导航', 'url' => '#', 'icon' => 'fa fa-share',
                        'items' => [
                            ['label' => '导航分类', 'icon' => 'fa fa-plane', 'url' => ['/nav/index']],
                            ['label' => '导航链接', 'icon' => 'fa fa-plane', 'url' => ['/nav-url/index']],
                        ]
                    ],
                    [
                        'label' => '积分模块', 'url' => '#', 'icon' => 'fa fa-share',
                        'items' => [
                            ['label' => '积分模板', 'icon' => 'fa fa-money', 'url' => ['/merit/merit-template']],
                            ['label' => '会员积分', 'icon' => 'fa fa-money', 'url' => ['/merit/merit']],
                            ['label' => '积分日志', 'icon' => 'fa fa-money', 'url' => ['/merit/merit-log']],
                        ]
                    ],
                    ['label' => '搜索日志', 'icon' => 'fa fa-search', 'url' => ['/search-log/index']],
                    ['label' => '右边栏设置', 'icon' => 'fa fa-diamond', 'url' => ['/right-link/index']],
                ], $debugMenu),
            ]
        ) ?>

    </section>

</aside>
