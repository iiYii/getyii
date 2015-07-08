<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/25 下午1:44
 * description:
 */
?>
<?php if (isset($nodes)): ?>
<div class="panel panel-default node-panel">
    <div class="panel-heading">
        <h3 class="panel-title text-center">节点导航</h3>
    </div>

    <div class="panel-body p0">
        <dl class="dl-horizontal node-box mb0">
            <?php foreach ($nodes as $key => $value): ?>
                <dt><?= $key ?></dt>
                <dd>
                    <ul class="list-inline">
                        <?php foreach ($value as $node): ?>
                            <li><?= \yii\helpers\Html::a($node['name'], ['/topic/default/index', 'node' => $node['alias']]) ?></li>
                        <?php endforeach ?>
                    </ul>
                </dd>
                <div class="divider"></div>
            <?php endforeach ?>
        </dl>
    </div>
</div>
<?php endif ?>
