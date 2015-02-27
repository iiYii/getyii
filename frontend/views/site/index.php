<?php
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>
<section id="main-slider" class="no-margin">
    <div class="carousel slide wet-asphalt">
        <ol class="carousel-indicators">
            <li data-target="#main-slider" data-slide-to="0" class="active"></li>
            <li data-target="#main-slider" data-slide-to="1"></li>
            <li data-target="#main-slider" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="item active" style="background-image: url(/images/slider/bg1.jpg)">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="carousel-content centered">
                                <h2 class="boxed animation animated-item-1">快速，安全，专业的 PHP 框架</h2>
                                <br>
                                <p class="boxed animation animated-item-2">Yii 是一个高性能的，适用于开发 WEB2.0 应用的 PHP 框架。</p>
                                <br>
                                <a class="btn btn-md animation animated-item-3" href="http://www.yiiframework.com/" target="_blank">Learn More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--/.item-->
            <div class="item" style="background-image: url(/images/slider/bg2.jpg)">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="carousel-content center centered">
                                <h2 class="boxed animation animated-item-1">基于组件、用于开发大型 Web 应用的高性能 PHP 框架</h2>
                                <p class="boxed animation animated-item-2">Yii 几乎拥有了 所有的特性 ，包括 MVC、DAO/ActiveRecord、I18N/L10N、caching、基于 JQuery 的 AJAX 支持、用户认证和基于角色的访问控制、脚手架、输入验证、部件、事件、主题化以及 Web 服务等等。</p>
                                <br>
                                <a class="btn btn-md animation animated-item-3" href="http://www.yiiframework.com/" target="_blank">Learn More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--/.item-->
            <div class="item" style="background-image: url(/images/slider/bg3.jpg)">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="carousel-content centered">
                                <h2 class="boxed animation animated-item-1">约定大于配置</h2>
                                <p class="boxed animation animated-item-2">Yii 采用严格的 OOP 编写，Yii 使用简单，非常灵活，具有很好的可扩展性。</p>
                                <a class="btn btn-md animation animated-item-3" href="http://www.yiiframework.com/" target="_blank">Learn More</a>
                            </div>
                        </div>
                        <!-- <div class="col-sm-6 hidden-xs animation animated-item-4">
                            <div class="centered">
                                <div class="embed-container">
                                    <iframe src="//player.vimeo.com/video/69421653?title=0&amp;byline=0&amp;portrait=0&amp;color=a22c2f" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div><!--/.item-->
        </div><!--/.carousel-inner-->
    </div><!--/.carousel-->
    <a class="prev hidden-xs" href="#main-slider" data-slide="prev">
        <i class="icon-angle-left"></i>
    </a>
    <a class="next hidden-xs" href="#main-slider" data-slide="next">
        <i class="icon-angle-right"></i>
    </a>
</section><!--/#main-slider-->

<section id="services" class="emerald">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="media">
                    <div class="pull-left">
                        <i class="icon-bolt icon-md"></i>
                    </div>
                    <div class="media-body">
                        <h3 class="media-heading">快速</h3>
                        <p>Yii 只加载您需要的功能。它具有强大的缓存支持。它明确的设计能与 AJAX 一起高效率的工作。</p>
                    </div>
                </div>
            </div><!--/.col-md-4-->
            <div class="col-md-4 col-sm-6">
                <div class="media">
                    <div class="pull-left">
                        <i class="icon-cloud icon-md"></i>
                    </div>
                    <div class="media-body">
                        <h3 class="media-heading">安全</h3>
                        <p>Yii 的标准是安全的。它包括了输入验证，输出过滤，SQL 注入和跨站点脚本的预防。</p>
                    </div>
                </div>
            </div><!--/.col-md-4-->
            <div class="col-md-4 col-sm-6">
                <div class="media">
                    <div class="pull-left">
                        <i class="icon-fire icon-md"></i>
                    </div>
                    <div class="media-body">
                        <h3 class="media-heading">专业</h3>
                        <p>Yii 可帮助您开发清洁和可重用的代码。它遵循了 MVC 模式，确保了清晰分离逻辑层和表示层。</p>
                    </div>
                </div>
            </div><!--/.col-md-4-->
        </div>
    </div>
</section><!--/#services-->

<section id="recent-works">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h3>一些案例</h3>
                <p>他们正自豪的使用 Yii 框架开发。</p>
                <div class="btn-group">
                    <a class="btn btn-danger" href="#scroller" data-slide="prev"><i class="icon-angle-left"></i></a>
                    <a class="btn btn-danger" href="#scroller" data-slide="next"><i class="icon-angle-right"></i></a>
                </div>
                <p class="gap"></p>
            </div>
            <div class="col-md-9">
                <div id="scroller" class="carousel slide">
                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="portfolio-item">
                                        <div class="item-inner">
                                            <img class="img-responsive" src="/images/portfolio/recent/item1.png" alt="">
                                            <h5>
                                                DCMS - 基于Yii2 开发的小型开源CMS
                                            </h5>
                                            <div class="overlay">
                                                <a class="preview btn btn-danger" title="基于Yii2 开发的小型开源CMS" href="images/portfolio/full/item1.png" rel="prettyPhoto"><i class="icon-eye-open"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="portfolio-item">
                                        <div class="item-inner">
                                            <img class="img-responsive" src="/images/portfolio/recent/item2.png" alt="">
                                            <h5>
                                                Yincart - 基于Yii2 开发的电商系统
                                            </h5>
                                            <div class="overlay">
                                                <a class="preview btn btn-danger" title="基于Yii2 开发的电商系统" href="images/portfolio/full/item2.png" rel="prettyPhoto"><i class="icon-eye-open"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="portfolio-item">
                                        <div class="item-inner">
                                            <img class="img-responsive" src="/images/portfolio/recent/item3.png" alt="">
                                            <h5>
                                                Xunsearch - 免费开源的专业全文检索解决方案
                                            </h5>
                                            <div class="overlay">
                                                <a class="preview btn btn-danger" title="免费开源的专业全文检索解决方案" href="images/portfolio/full/item3.jpg" rel="prettyPhoto"><i class="icon-eye-open"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!--/.row-->
                        </div><!--/.item-->
                        <div class="item">
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="portfolio-item">
                                        <div class="item-inner">
                                            <img class="img-responsive" src="/images/portfolio/recent/item4.png" alt="">
                                            <h5>
                                                bageCMS - 基于 Yii1 的博客开源CMS
                                            </h5>
                                            <div class="overlay">
                                                <a class="preview btn btn-danger" title="基于 Yii1 的博客开源CMS" href="images/portfolio/full/item4.png" rel="prettyPhoto"><i class="icon-eye-open"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="portfolio-item">
                                        <div class="item-inner">
                                            <img class="img-responsive" src="/images/portfolio/recent/item5.png" alt="">
                                            <h5>
                                                yiifcms - 基于 Yii1框架开发的CMS
                                            </h5>
                                            <div class="overlay">
                                                <a class="preview btn btn-danger" title="基于 Yii1框架开发的CMS" href="images/portfolio/full/item5.png" rel="prettyPhoto"><i class="icon-eye-open"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="portfolio-item">
                                        <div class="item-inner">
                                            <img class="img-responsive" src="/images/portfolio/recent/item6.png" alt="">
                                            <h5>
                                                24betacms - 基于 Yii1 的博客开源项目
                                            </h5>
                                            <div class="overlay">
                                                <a class="preview btn btn-danger" title="基于 Yii1 的博客开源项目" href="images/portfolio/full/item6.png" rel="prettyPhoto"><i class="icon-eye-open"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--/.item-->
                    </div>
                </div>
            </div>
        </div><!--/.row-->
    </div>
</section><!--/#recent-works-->

<section id="testimonial" class="alizarin">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="center">
                    <h2>开发者如是说……</h2>
                    <!-- <p>用过都说好，你还在等什么呢？</p> -->
                </div>
                <div class="gap"></div>
                <div class="row">
                    <div class="col-md-6">
                        <blockquote>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                            <small>Someone famous in <cite title="Source Title">Source Title</cite></small>
                        </blockquote>
                        <blockquote>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                            <small>Someone famous in <cite title="Source Title">Source Title</cite></small>
                        </blockquote>
                    </div>
                    <div class="col-md-6">
                        <blockquote>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                            <small>Someone famous in <cite title="Source Title">Source Title</cite></small>
                        </blockquote>
                        <blockquote>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                            <small>Someone famous in <cite title="Source Title">Source Title</cite></small>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!--/#testimonial-->