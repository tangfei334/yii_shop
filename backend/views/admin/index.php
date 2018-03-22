<?php
/* @var $this yii\web\View */
?>
<h1>管理员</h1>

<p>
    <a href="<?=\yii\helpers\Url::to(['admin/add/'])?>" class="btn btn-info">添加</a>
<table class="table">
    <tr>
        <th>id</th>
        <th>管理员</th>
        <th>添加时间</th>
        <th>最后登录时间</th>
        <th>最后登录IP</th>、
        <th>状态</th>
        <th>操作</th>

    </tr>
    <?php
    foreach ($models as $model):
    ?>
    <tr>
        <td><?=$model->id?></td>
        <td><?=$model->username?></td>
        <td><?=date('Y-m-d H:i:s',$model->add_time)?></td>
        <td><?=date('Y-m-d H:i:s',$model->last_login_time)?></td>
        <td><?=$model->last_login_ip?></td>
        <td><?php
            if($model->status){
                echo \yii\bootstrap\Html::a("",["","id"=>"$model->id"],["class"=>"glyphicon glyphicon-ok"]);
            }else{
                echo \yii\bootstrap\Html::a("",["","id"=>"$model->id"],["class"=>"glyphicon glyphicon-remove"]);
            }

            ?></td>
        <td>

            <a href="<?=\yii\helpers\Url::to(['admin/edit','id'=>$model->id])?>" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i>  修改</a>
            <a href="<?=\yii\helpers\Url::to(['admin/del','id'=>$model->id])?>" class="btn btn-danger"><i class="glyphicon glyphicon-pencil"></i> 删除</a>
        </td>
    </tr>
<?php endforeach;?>

</table>
</p>
