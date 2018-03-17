<?php
/* @var $this yii\web\View */
?>


<h1>分类管理</h1>

<p>
    <table class="table">
    <tr>
        <th>id</th>
        <th>名称</th>
        <th>简介</th>
        <th>状态</th>
        <th>排序</th>
        <th>是否需要帮助</th>


        <th>操作</th>
    </tr>
    <?php foreach ($model as $models):?>
    <tr>
        <td><?=$models->id?></td>
        <td><?=$models->name?></td>
        <td><?=$models->intro?></td>
        <td><?=\backend\models\ArticleCategory::$status[$models->status]?></td>
        <td><?=$models->sort?></td>
        <td><?=\backend\models\ArticleCategory::$is_help[$models->is_help]?></td>
        <td>
            <a href="<?=\yii\helpers\Url::to(['edit','id'=>$models->id])?>" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i>  修改</a>
            <a href="<?=\yii\helpers\Url::to(['del','id'=>$models->id])?>" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i>  删除</a>

        </td>
    </tr>
<?php endforeach;?>
</table>

<a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>添加</a>
<?=yii\widgets\LinkPager::widget([
    'pagination' => $page,
])

?>


</p>
