<?php
/* @var $this yii\web\View */
?>

<a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>添加</a>
<form class="form-inline  pull-right">
    <div class="form-group">
        <input type="text" class="form-control" id="minprice" placeholder="最低价" name="minPrice">
    </div>
    - -
    <div class="form-group">
        <input type="text" class="form-control" id="maxprice" placeholder="最高价" name="maxPrice">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" id="keyWord" placeholder="货号或者名称" name="keyWord">
    </div>
    <button type="submit" class="btn btn-default">查询</button>
</form>
<h1>商品管理</h1>

<p>
    <table class="table">
    <tr>
        <th>id</th>
        <th>名称</th>
        <th>货号</th>
        <th>图像</th>
        <th>商品分类</th>
        <th>品牌</th>
        <th>市场价格</th>
        <th>本地价格</th>
        <th>库存</th>
        <th>状态</th>
        <th>录入时间</th>
        <th>操作</th>
    </tr>
    <?php foreach ($model as $models):?>
    <tr>
        <td><?=$models->id?></td>
        <td><?=$models->name?></td>
        <td><?=$models->sn?></td>
        <td><img src="<?=$models->logo?>" height="30" width="30"></td>
        <td><?=$models->category->name?></td>
        <td><?=$models->brand->name?></td>
        <td><?=$models->make_price?></td>
        <td><?=$models->shop_price?></td>
        <td><?=$models->stock?></td>

        <td>
            <?php
            if($models->status){
            echo \yii\bootstrap\Html::a("",["","id"=>"$models->id"],["class"=>"glyphicon glyphicon-ok"]);
            }else{
            echo \yii\bootstrap\Html::a("",["","id"=>"$models->id"],["class"=>"glyphicon glyphicon-remove"]);
            }

            ?></td>
        <td><?=date('Y-m-d H:i:s')?></td>
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
