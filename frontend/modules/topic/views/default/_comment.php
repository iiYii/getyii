<?php
/**
 * @Author: forecho
 * @Date:   2015-01-29 23:26:54
 * @Last Modified by:   forecho
 * @Last Modified time: 2015-02-04 21:53:45
 */

use yii\helpers\Html;
use yii\helpers\Markdown;

$index += +1;
?>

<div class="avatar pull-left">
    <?php $img = "http://gravatar.com/avatar/" . md5($model->user['email']) . "?s=48"; ?>
    <?= Html::a(Html::img($img, ['class' => 'media-object avatar-48']),
        ['/user/default/show', 'username' => $model->user['username']]
    ); ?>
</div>

<div class="infos">

    <div class="media-heading meta info opts">
        <?= Html::a($model->user['username'], ['/people', 'id' => $model->user['username']]) ?>
        <span> •  </span>
        <?= Html::a("#{$index}", "#comment{$index}", ['class' => 'comment-floor']) ?>
        <span> •  </span>
        <abbr class="timeago" title="<?= Yii::$app->formatter->asDatetime($model->created_at) ?>">
            <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?>
        </abbr>

        <span class="opts pull-right">
            <?php
                echo Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-thumbs-o-up']) . ' ' . Html::tag('span', $model->like_count) . ' 个赞',
                    '#',
                    [
                        'data-do' => 'like',
                        'data-id' => $model->id,
                        'data-type' => 'comment',
                        'class' => ($model->like) ? 'active': ''
                    ]
                );
                if($model->isCurrent()){
                    echo Html::a('',
                        ['/topic/comment/update', 'id' => $model->id],
                        ['title' => '修改回帖', 'class' => 'fa fa-pencil']
                    );
                } else{
                    echo Html::a('', '#',
                        [
                            'data-login' => $model->user['username'],
                            'data-floor' => $index,
                            'title' => '回复此楼',
                            'class' => 'fa fa-mail-reply'
                        ]
                    );
                }
            ?>
        </span>

    </div>

    <div class="media-body markdown-reply content-body">
        <?= Markdown::process($model->comment, 'gfm') ?>
    </div>
</div>