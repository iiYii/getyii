<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Portfolio';
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="portfolio" class="container">
    <ul class="portfolio-filter">
        <li><a class="btn btn-default active" href="#" data-filter="*">All</a></li>
        <li><a class="btn btn-default" href="#" data-filter=".bootstrap">Bootstrap</a></li>
        <li><a class="btn btn-default" href="#" data-filter=".html">HTML</a></li>
        <li><a class="btn btn-default" href="#" data-filter=".wordpress">Wordpress</a></li>
    </ul><!--/#portfolio-filter-->

    <ul class="portfolio-items col-3">
        <li class="portfolio-item apps">
            <div class="item-inner">
                <img src="images/portfolio/thumb/item1.jpg" alt="">
                <h5>Lorem ipsum dolor sit amet</h5>
                <div class="overlay">
                    <a class="preview btn btn-danger" href="images/portfolio/full/item1.jpg" rel="prettyPhoto"><i class="icon-eye-open"></i></a>
                </div>
            </div>
        </li><!--/.portfolio-item-->
        <li class="portfolio-item joomla bootstrap">
            <div class="item-inner">
                <img src="images/portfolio/thumb/item2.jpg" alt="">
                <h5>Lorem ipsum dolor sit amet</h5>
                <div class="overlay">
                    <a class="preview btn btn-danger" href="images/portfolio/full/item2.jpg" rel="prettyPhoto"><i class="icon-eye-open"></i></a>
                </div>
            </div>
        </li><!--/.portfolio-item-->
        <li class="portfolio-item bootstrap wordpress">
            <div class="item-inner">
                <img src="images/portfolio/thumb/item3.jpg" alt="">
                <h5>Lorem ipsum dolor sit amet</h5>
                <div class="overlay">
                    <a class="preview btn btn-danger" href="images/portfolio/full/item3.jpg" rel="prettyPhoto"><i class="icon-eye-open"></i></a>
                </div>
            </div>
        </li><!--/.portfolio-item-->
        <li class="portfolio-item joomla wordpress apps">
            <div class="item-inner">
                <img src="images/portfolio/thumb/item4.jpg" alt="">
                <h5>Lorem ipsum dolor sit amet</h5>
                <div class="overlay">
                    <a class="preview btn btn-danger" href="images/portfolio/full/item4.jpg" rel="prettyPhoto"><i class="icon-eye-open"></i></a>
                </div>
            </div>
        </li><!--/.portfolio-item-->
        <li class="portfolio-item joomla html">
            <div class="item-inner">
                <img src="images/portfolio/thumb/item5.jpg" alt="">
                <h5>Lorem ipsum dolor sit amet</h5>
                <div class="overlay">
                    <a class="preview btn btn-danger" href="images/portfolio/full/item5.jpg" rel="prettyPhoto"><i class="icon-eye-open"></i></a>
                </div>
            </div>
        </li><!--/.portfolio-item-->
        <li class="portfolio-item wordpress html">
            <div class="item-inner">
                <img src="images/portfolio/thumb/item6.jpg" alt="">
                <h5>Lorem ipsum dolor sit amet</h5>
                <div class="overlay">
                    <a class="preview btn btn-danger" href="images/portfolio/full/item6.jpg" rel="prettyPhoto"><i class="icon-eye-open"></i></a>
                </div>
            </div>
        </li><!--/.portfolio-item-->
    </ul>
</section><!--/#portfolio-->
