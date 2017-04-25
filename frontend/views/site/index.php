<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\icons\Icon;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;

Icon::map($this);

$this->title = \Yii::$app->setting->get('siteName');
/** @var array $headline */
/** @var array $topics */
/** @var array $statistics */
/** @var array $users */
/** @var \yii\web\View $this */
?>



    <div class="panel panel-default">
        <div class="panel-body text-center mp0">
            <?= ($headline) ? HtmlPurifier::process(Markdown::process(reset($headline), 'gfm')) : \Yii::t('app', 'site_intro') ?>
        </div>
    </div>
    <div class="btn-group btn-group-justified">
        <?php if(Yii::$app->user->isGuest || (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isSign)): ?>
            <a class="btn btn-danger btn-registration " href="<?= Url::to(['/sign'])?>"><i class="fa fa-calendar-plus-o"></i> 点此处签到<br>签到有好礼</a>
        <?php else: ?>
            <a class="btn btn-danger disabled" href="<?= Url::to(['/sign'])?>"><i class="fa fa-calendar-check-o"></i> 今日已签到<br>已连续<?= Yii::$app->user->identity->sign->continue_times ?>天</a>
        <?php endif; ?>
        <a class="btn btn-info" href="<?= Url::to(['/sign'])?>"><?= date('Y年m月d日') ?><br>今日已有<?= Yii::$app->db->createCommand('SELECT COUNT(*) FROM {{%sign}} WHERE FROM_UNIXTIME(last_sign_at, "%Y%m%d") = "'. date('Ymd') . '"')->queryScalar() ?>人签到</a>
    </div>

    <div class="panel panel-default list-panel mt10">
        <div class="panel-heading">
            <h3 class="panel-title text-center">
                <?= \Yii::t('app', 'Hot Articles') ?> &nbsp;
            </h3>
        </div>

        <div class="clearfix site-index-topic article-list">
            <?php if ($articles) {
                foreach ($articles as $key => $vlaue) {
                    echo $this->render('_item_article', ['model' => $vlaue]);
                }
            } else {
                echo \Yii::t('app', 'Dont have any data Yet');
            } ?>
        </div>
    </div>

    <div class="panel panel-default list-panel ">
        <div class="panel-heading">
            <h3 class="panel-title text-center">
                <?= \Yii::t('app', 'Excellent Topics') ?> &nbsp;
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
            <span class="index_count">
                <?= Icon::show('user'); ?><?= \Yii::t('app', 'Online Count') ?>：<?= $statistics['online_count']; ?>
                <?= Icon::show('list'); ?><?= \Yii::t('app', 'Post Count') ?>：<?= $statistics['post_count']; ?>
                <?= Icon::show('share'); ?><?= \Yii::t('app', 'Comment Count') ?>：<?= $statistics['comment_count']; ?>
            </span>
            <?= Html::a(\Yii::t('app', 'More Excellent Topics'), ['topic/default/index', 'sort' => 'excellent']) ?>
        </div>
    </div>

    <div class="panel panel-default list-panel">
        <div class="panel-heading">
            <h3 class="panel-title text-center">社区会员榜</h3>
        </div>

        <div class="panel-body row">
            <?= $this->render('/partials/users', ['model' => $users]); ?>
        </div>
    </div>

<?= \frontend\widgets\Node::widget() ?>