<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/18
 * Time: 15:47
 */
/** @var $this \yii\web\View */
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($models,'name');
echo $form->field($models,'intro');
echo $form->field($models,'parent_id');
echo \liyuze\ztree\ZTree::widget([
    'setting' => '{
			data: {
				simpleData: {
					enable: true,
					pIdKey: "parent_id",
					
				}
			},
			callback: {
				onClick: onClick
			}
		}',
    'nodes' => $modelJson
]);


echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
echo \yii\bootstrap\Html::a(' 返回',['index'],['class'=>'btn btn-danger']);
$form=\yii\bootstrap\ActiveForm::end();

//<!--定义js代码块-->
$js=<<<JS
        var treeObj = $.fn.zTree.getZTreeObj("w1");
        treeObj.expandAll(true);
JS;
//<!--        注册js-->

$this->registerJs($js);
?>


<script>

    function onClick(e,treeId, treeNode) {
        //找到父ID的input框

        $("#category-parent_id").val(treeNode.id)
//        console.log(1111);
        console.dir(treeNode.id);
    }
</script>