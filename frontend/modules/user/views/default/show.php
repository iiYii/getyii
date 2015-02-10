<?php

use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\ListView;

// $this->title = Html::encode($user->username);
// $this->params['breadcrumbs'][] = $this->title;
$username = Yii::$app->getRequest()->getQueryParam('username');
?>
<section class="container user-default-index">

    <div class="col-sm-3">
        <div class="panel panel-default thumbnail center">
            <br>
            <img src="http://gravatar.com/avatar/<?= md5($user->email) ?>?s=230" alt="用户头像" title="用户头像" class="img-circle img-responsive" />
            <h1 class=""><?= Html::tag('strong', $user->username) ?></h1>
            <!-- <button type="button" class="btn btn-success">Book me!</button> -->
            <!-- <button type="button" class="btn btn-info">Send me a message</button> -->
            <!-- <br> -->
        </div>

        <!--left col-->
        <ul class="list-group">
            <li class="list-group-item text-muted" contenteditable="false">Profile</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong class="">Joined</strong></span>
                2.13.2014
            </li>
            <li class="list-group-item text-right"><span class="pull-left"><strong class="">Last seen</strong></span>
                Yesterday
            </li>
            <li class="list-group-item text-right"><span class="pull-left"><strong class="">Real name</strong></span>
                Joseph
                Doe
            </li>
            <li class="list-group-item text-right"><span class="pull-left"><strong class="">Role: </strong></span> Pet
                Sitter
            </li>
        </ul>
        <div class="panel panel-default">
            <div class="panel-heading">Insured / Bonded?

            </div>
            <div class="panel-body"><i style="color:green" class="fa fa-check-square"></i> Yes, I am insured and bonded.

            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">Website <i class="fa fa-link fa-1x"></i>

            </div>
            <div class="panel-body"><a href="http://bootply.com" class="">bootply.com</a>

            </div>
        </div>

        <ul class="list-group">
            <li class="list-group-item text-muted">Activity <i class="fa fa-dashboard fa-1x"></i>

            </li>
            <li class="list-group-item text-right"><span class="pull-left"><strong class="">Shares</strong></span> 125
            </li>
            <li class="list-group-item text-right"><span class="pull-left"><strong class="">Likes</strong></span> 13
            </li>
            <li class="list-group-item text-right"><span class="pull-left"><strong class="">Posts</strong></span> 37
            </li>
            <li class="list-group-item text-right"><span class="pull-left"><strong class="">Followers</strong></span> 78
            </li>
        </ul>
        <div class="panel panel-default">
            <div class="panel-heading">Social Media</div>
            <div class="panel-body"><i class="fa fa-facebook fa-2x"></i> <i class="fa fa-github fa-2x"></i>
                <i class="fa fa-twitter fa-2x"></i> <i class="fa fa-pinterest fa-2x"></i> <i
                    class="fa fa-google-plus fa-2x"></i>

            </div>
        </div>
    </div>
    <!--/col-3-->
    <div class="col-sm-9" contenteditable="false" style="">
        <div class="panel panel-default">
            <div class="panel-heading">Starfox221's Bio</div>
            <div class="panel-body"> A long description about me.

            </div>
        </div>
        <div class="panel panel-default target">
            <div class="panel-heading" contenteditable="false">Pets I Own</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <img alt="300x200" src="http://lorempixel.com/600/200/people">

                            <div class="caption">
                                <h3>
                                    Rover
                                </h3>

                                <p>
                                    Cocker Spaniel who loves treats.
                                </p>

                                <p>

                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <img alt="300x200" src="http://lorempixel.com/600/200/city">

                            <div class="caption">
                                <h3>
                                    Marmaduke
                                </h3>

                                <p>
                                    Is just another friendly dog.
                                </p>

                                <p>

                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <img alt="300x200" src="http://lorempixel.com/600/200/sports">

                            <div class="caption">
                                <h3>
                                    Rocky
                                </h3>

                                <p>
                                    Loves catnip and naps. Not fond of children.
                                </p>

                                <p>

                                </p>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
        <div class="panel panel-default">
            <div class="panel-heading">Starfox221's Bio</div>
            <div class="panel-body"> A long description about me.

            </div>
        </div>
    </div>
</section>