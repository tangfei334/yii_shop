<?php
/* @var $this yii\web\View */
?>

<a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>添加</a>
<h1>品牌管理</h1>

<p>
    <table class="table">
    <tr>
        <th>id</th>
        <th>名称</th>
        <th>图像</th>
        <th>排序</th>
        <th>状态</th>
        <th>简介</th>
        <th>操作</th>
    </tr>
    <?php foreach ($model as $models):?>
    <tr>
        <td><?=$models->id?></td>
        <td><?=$models->name?></td>
        <td><?php
//            $imgPath = strpos($models->logo,"http://")===false?"/".$models->logo:$models->logo;
            $imgPath=strpos($models->logo,'ttp://')?$models->logo:"/".$models->logo;
            echo \yii\bootstrap\Html::img($imgPath,['height'=>40]);
            ?></td>
        <td><?=$models->sort?></td>
        <td><?=\backend\models\Brand::$status[$models->status]?></td>
        <td><?=$models->intro?></td>
        <td>
            <a href="<?=\yii\helpers\Url::to(['edit','id'=>$models->id])?>" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i>  修改</a>
            <a href="<?=\yii\helpers\Url::to(['del','id'=>$models->id])?>" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i>  删除</a>

        </td>
    </tr>
<?php endforeach;?>
</table>
<?=yii\widgets\LinkPager::widget([
        'pagination' => $page,
])

?>
</p>
