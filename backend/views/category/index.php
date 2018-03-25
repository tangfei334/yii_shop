<?php
/* @var $this yii\web\View */
?>
<h1>产品分类</h1>

<p>
   <table class="table">

    <tr>
        <?= \leandrogehlen\treegrid\TreeGrid::widget([
            'dataProvider' => $dataProvider,
            'keyColumnName' => 'id',
            'parentColumnName' => 'parent_id',
            'parentRootValue' => '0', //first parentId value
            'pluginOptions' => [
                'initialState' => 'collapsed',
            ],
            'columns' => [
                'name',
                'id',
                'left',
                'right',
                'deep',
                'intro',
                'tree',
                'parent_id',
                ['class' => \yii\grid\ActionColumn::className()]
            ]
        ]); ?>
    </tr>
    <a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-primary">添加</a>

</table>
</p>
