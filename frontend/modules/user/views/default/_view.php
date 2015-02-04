<?php
/**
 * @Author: forecho
 * @Date:   2015-01-29 23:26:54
 * @Last Modified by:   forecho
 * @Last Modified time: 2015-02-04 21:53:45
 */

use yii\helpers\Html;
?>
<div class="list-group-item">
    <?= Html::a(
        Html::tag('h4', $model->title, ['class' => 'list-group-item-heading']),
        ['/post/view',
        'id' => $model->id]
    );?>
    <p class="list-group-item-text">
        <?= Html::a($model->category->name, ['/post/view', 'id' => $model->id]);?>
        <span>
            <?= $model->like_count ?> 人喜欢 • <?= $model->comment_count ?> 条回复
        </span>
    </p>
</div>