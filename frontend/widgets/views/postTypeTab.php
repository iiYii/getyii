<?php
/**
 * Created by PhpStorm.
 * User: ruzuojun
 * Date: 2016/12/12
 * Time: 13:32
 */
use kartik\icons\Icon;
Icon::map($this);
$module_id = \Yii::$app->controller->module->id;

?>

<?php if($node->is_article==1): ?>
<div class="post_type_tab">
    <ul class="nav nav-pills" role="tablist">
        <li <?php if($module_id=='topic') echo "class='active'"; ?>><a href='<?=\yii\helpers\Url::to(["/node/$node->alias/topic"]) ?>'><?=Icon::show('comment-o')?>话题</a></li>
        <!--<li <?php if($module_id=='question') echo "class='active'"; ?>><a href='<?=\yii\helpers\Url::to(["/node/$node->alias/question"]) ?>'><?=Icon::show('question-circle-o')?>问答</a></li>-->
        <li <?php if($module_id=='article') echo "class='active'"; ?>><a href='<?=\yii\helpers\Url::to(["/node/$node->alias/article"]) ?>'><?=Icon::show('file-word-o')?>教程</a></li>
        <!--<li <?php if($module_id=='wiki') echo "class='active'"; ?>><a href='<?=\yii\helpers\Url::to(["/node/$node->alias/wiki"]) ?>'><?=Icon::show('wikipedia-w')?>百科</a></li>-->
    </ul>
</div>
<?php endif; ?>