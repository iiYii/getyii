<?php

use yii\helpers\Html;

$this->title = Html::encode($user->username);
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="container User-default-index">
    <div class="col-xs-12 col-sm-6 col-md-6">
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <img src="http://gravatar.com/avatar/<?= md5($user->email) ?>?s=230" alt="" class="img-rounded img-responsive" />
            </div>
            <div class="col-sm-6 col-md-8">
                <h4><?= Html::tag('b', $user->username), '，', $user->tagline ?></h4>
                <ul style="padding: 0; list-style: none outside none;">

                    <?php if (!empty($profile->location)): ?>
                        <li><i class="fa fa-map-marker text-muted"></i> <?= Html::encode($profile->location) ?></li>
                    <?php endif; ?>

                    <?php if (!empty($profile->company)): ?>
                        <li><i class="fa fa-laptop"></i> <?= Html::a(Html::encode($profile->company), Html::encode($profile->company)) ?></li>
                    <?php endif; ?>

                    <?php if (!empty($profile->website)): ?>
                        <li><i class="fa fa-globe text-muted"></i> <?= Html::a(Html::encode($profile->website), Html::encode($profile->website)) ?></li>
                    <?php endif; ?>

                    <?php if (!empty($profile->github)): ?>
                        <li><i class="fa fa-github text-muted"></i> <?= Html::a(Html::encode($profile->github), Html::encode($profile->github)) ?></li>
                    <?php endif; ?>

                    <li><i class="fa fa-calendar text-muted"></i> <?= '加入于 ', Yii::$app->formatter->asDateTime($profile->created_at) ?></li>

                    <?php if (!empty($profile->info)): ?>
                        <li><i class="fa fa-user text-muted"></i> <?= Html::a(Html::encode($profile->info), Html::encode($profile->info)) ?></li>
                    <?php endif; ?>

                </ul>
                <?php if (!empty($profile->bio)): ?>
                    <p><?= Html::encode($profile->bio) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
