<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use frontend\widgets\TopicSidebar;

use kartik\icons\Icon;

Icon::map($this);

$this->title = '社区';
$sort = Yii::$app->request->getQueryParam('sort');
$tag = Yii::$app->request->getQueryParam('tag');
if ($node = Yii::$app->request->getQueryParam('node')) {
    $node = \common\models\PostMeta::find()->where(['alias' => $node])->one();
}
$bg_color = !empty($node['bg_color']) ? $node['bg_color'] : '#f0f0f0';
?>
<div class="col-md-9 topic">
    <div class="panel panel-default">
        <?php if (isset($nodes)): ?>
        <div class="panel-heading p0 m0 clearfix">
            <dl class="dl-horizontal hot-node mb0 ml5">
                <dd>
                    <ul class="list-inline">
                        <?php if(!isset($node)){$tab_class = "tab_current";}else{$tab_class = "tab";} ?>
                        <li><?= \yii\helpers\Html::a('全部', ['/topic/default/index'],['class'=>$tab_class]) ?></li>
                        <?php foreach ($nodes as $item): ?>
                            <?php if(isset($node) && $item['alias']==$node->alias){$tab_class = "tab_current";}else{$tab_class = "tab";} ?>
                            <li><?= \yii\helpers\Html::a($item['name'], ['/topic/default/index', 'node' => $item['alias']],['class'=>$tab_class]) ?></li>
                        <?php endforeach ?>
                    </ul>
                </dd>
            </dl>
        </div>
        <?php endif ?>

        <?php if($node and !empty($node->description)): ?>
        <div class="panel-body clearfix">
            <?= Icon::show('cloud-upload') ?> <?= $node->name; ?>
                <br/>
                <span style="color: #666666; font-size: 12px;"><?= $node->description; ?></span>
        </div>
        <?php endif; ?>

        <div class="panel-heading clearfix">
            <?php if ($tag): ?>
                <div class="pull-left">搜索标签：<?= $tag; ?>
                </div>
            <?php endif; ?>

            <div class="filter pull-right">
                <span class="l">查看:</span>
                <?php foreach ($sorts as $key => $name): ?>
                    <?= Html::a($name, \yii\helpers\Url::current(['sort' => $key]), ['class' => ($sort == $key || ((empty($sort) && $key == 'newest'))) ? 'active' : '']) ?> \
                <?php endforeach ?>
            </div>

        </div>

        <?php Pjax::begin([
            'scrollTo' => 0,
            'formSelector' => false,
            'linkSelector' => '.pagination a'
        ]); ?>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'list-group-item'],
            'summary' => false,
            'itemView' => '_item',
            'options' => ['class' => 'list-group'],
        ]) ?>
        <?php Pjax::end(); ?>

    </div>
    <?= \frontend\widgets\Node::widget(); ?>
</div>
<?= TopicSidebar::widget([
    'node' => $node
]); ?>

<script type="text/javascript">
    document.getElementById('wrap').style.backgroundColor="<?= $bg_color ?>";
</script>
