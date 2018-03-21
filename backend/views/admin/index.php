<?php
/* @var $this yii\web\View */
?>
<h1>admin/index</h1>

<p>
    <a href="<?=\yii\helpers\Url::to(['admin/add/'])?>" class="btn btn-info">添加</a>
<table class="table">
    <tr>
        <th>id</th>
        <th>管理员</th>
        <th>密码</th>
        <th>盐</th>
        <th>邮箱</th>
        <th>自动登录</th>
        <th>自动登录时间</th>
        <th>添加时间</th>
        <th>最后登录时间</th>
        <th>最后登录IP</th>
        <th>操作</th>

    </tr>
    <?php
    foreach ($models as $model):
    ?>
    <tr>
        <td><?=$model->id?></td>
        <td><?=$model->username?></td>
        <td><?=$model->password?></td>
        <td><?=$model->salt?></td>
        <td><?=$model->email?></td>
        <td><?=$model->token?></td>
        <td><?=$model->token_create_time?></td>
        <td><?=date('Y-m-d H:i:s',$model->add_time)?></td>
        <td><?=date('Y-m-d H:i:s',$model->last_login_time)?></td>
        <td><?=$model->last_login_ip?></td>
        <td>

            <a href="">删除</a>
            <a href="">修改</a>
        </td>
    </tr>
<?php endforeach;?>

</table>
</p>
