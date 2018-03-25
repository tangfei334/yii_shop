<?php
/* @var $this yii\web\View */
?>
<h1>auth-item/index</h1>

<p>
    <a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>添加</a>
    <table class="table">
    <tr>
        <th>名称</th>
        <th>描述</th>
        <th>操作</th>
    </tr>
    <?php
    foreach ($model as $models):
    ?>
    <tr>
        <td><?=strpos($models->name,'/')?'---'.$models->name:$models->name?></td>
        <td><?=$models->description?></td>
        <td>
            <a href="<?=\yii\helpers\Url::to(['edit','name'=>$models->name])?>" class="btn btn-primary"><i class="glyphicon glyphicon-trash"></i>编辑</a>
            <a href="<?=\yii\helpers\Url::to(['del','name'=>$models->name])?>" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i>  删除</a>
        </td>
    </tr>

<?php
    endforeach;?>
</table>
</p>
