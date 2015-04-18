<?php
use yii\helpers\Html;

$this->title = \Yii::$app->setting->get('siteName');
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="text-center"><?= \Yii::t('app', 'site_intro') ?></div>
    </div>
</div>


<div class="panel panel-default list-panel">
    <div class="panel-heading">
        <h3 class="panel-title text-center">
            <?= \Yii::t('app', 'Excellent Topics') ?> &nbsp;
            <a href="{{ route('feed') }}" style="color: #E5974E; font-size: 14px;" target="_blank">
                <i class="fa fa-rss"></i>
            </a>
        </h3>

    </div>

    <div class="clearfix site-index-topic">
        <?php if ($topics) {
            foreach ($topics as $key => $vlaue) {
                echo $this->render('_item', ['model' => $vlaue]);
            }
        } else {
            echo \Yii::t('app', 'Dont have any data Yet');
        } ?>
    </div>

    <div class="panel-footer text-right">

        <a href="topics?filter=excellent">
            <?= \Yii::t('app', 'More Excellent Topics') ?>
        </a>
    </div>
</div>