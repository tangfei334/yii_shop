<?php
/* @var $this yii\web\View */
?>


<h1>文章管理</h1>

<p>
    <table class="table">
    <tr class="active">
        <th>id</th>
        <th>名称</th>
        <th>简介</th>
        <th>状态</th>
        <th>排序</th>
        <th>创建时间</th>
        <th>更新时间</th>
        <th>分类</th>



        <th>操作</th>
    </tr>
    <?php foreach ($model as $models):?>
    <tr>
        <td  class="warning"><?=$models->id?></td>
        <td class="warning"><?=$models->name?></td>
        <td class="warning"><?=$models->intro?></td>
        <td class="warning"><?php
                if($models->status){
                    echo \yii\bootstrap\Html::a("",["","id"=>"$models->id"],["class"=>"glyphicon glyphicon-ok"]);
                }else{
                    echo \yii\bootstrap\Html::a("",["","id"=>"$models->id"],["class"=>"glyphicon glyphicon-remove"]);
                }

            ?></td>
        <td class="danger"><?=$models->sort?></td>
        <td class="warning"><?=date('Y-m-d H:i:s',$models->create_time)?></td>
        <td class="warning"><?=date('Y-m-d H:i:s',$models->update_time)?></td>
        <td class="warning"><?=$models->article->name?></td>
        <td class="danger">
            <a href="<?=\yii\helpers\Url::to(['edit','id'=>$models->id])?>" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i>  修改</a>
            <a href="<?=\yii\helpers\Url::to(['del','id'=>$models->id])?>" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i>  删除</a>

        </td>
    </tr>
<?php endforeach;?>
    <a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>添加</a>
</table>

<?=yii\widgets\LinkPager::widget([
    'pagination' => $page,
])

?>



</p>
