<?php


use yii\widgets\Menu;

$user = Yii::$app->user->identity;
$networksVisible = count(Yii::$app->authClientCollection->clients) > 0;

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            <img src="<?= $user->gravatar ?>" class="img-rounded" alt="<?= $user->username ?>"/>
            <?= $user->username ?>
        </h3>
    </div>
    <div class="panel-body">
        <?= Menu::widget([
            'options' => [
                'class' => 'nav nav-pills nav-stacked'
            ],
            'items' => [
                ['label' => 'Profile',  'url' => ['/user/settings/profile']],
                ['label' => 'Account',  'url' => ['/user/settings/account']],
                ['label' => 'Networks', 'url' => ['/user/settings/networks'], 'visible' => $networksVisible],
            ]
        ]) ?>
    </div>
</div>