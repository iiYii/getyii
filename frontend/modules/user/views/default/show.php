<?php

use yii\helpers\Html;

// $this->title = Html::encode($user->username);
// $this->params['breadcrumbs'][] = $this->title;
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

                    <?php if (!empty($user->userInfo->location)): ?>
                        <li><i class="fa fa-map-marker text-muted"></i> <?= Html::encode($user->userInfo->location) ?></li>
                    <?php endif; ?>

                    <?php if (!empty($user->userInfo->company)): ?>
                        <li><i class="fa fa-laptop"></i> <?= Html::a(Html::encode($user->userInfo->company), Html::encode($user->userInfo->company)) ?></li>
                    <?php endif; ?>

                    <?php if (!empty($user->userInfo->website)): ?>
                        <li><i class="fa fa-globe text-muted"></i> <?= Html::a(Html::encode($user->userInfo->website), Html::encode($user->userInfo->website)) ?></li>
                    <?php endif; ?>

                    <?php if (!empty($user->userInfo->github)): ?>
                        <li><i class="fa fa-github text-muted"></i> <?= Html::a(Html::encode($user->userInfo->github), Html::encode($user->userInfo->github)) ?></li>
                    <?php endif; ?>

                    <li><i class="fa fa-calendar text-muted"></i> <?= '加入于 ', Yii::$app->formatter->asDateTime($user->userInfo->created_at) ?></li>

                    <?php if (!empty($user->userInfo->info)): ?>
                        <li><i class="fa fa-user text-muted"></i> <?= Html::a(Html::encode($user->userInfo->info), Html::encode($user->userInfo->info)) ?></li>
                    <?php endif; ?>

                </ul>
                <?php if (!empty($user->userInfo->bio)): ?>
                    <p><?= Html::encode($user->userInfo->bio) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php echo $this->render('_view', ['module' => Yii::$app->getModule('user')]) ?>
</section>
