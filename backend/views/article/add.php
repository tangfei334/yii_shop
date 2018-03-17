<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/15
 * Time: 16:57
 */
/** @var $this \yii\web\View */
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($models,'name');
echo $form->field($models,'intro')->textarea();
//echo $form->field($content,'content')->textarea();
echo $form->field($content,'content')->widget('kucha\ueditor\UEditor',[]);
echo $form->field($models,'status')->inline()->radioList([0=>'下线',1=>'上线'],['value'=>1]);
echo $form->field($models,'sort');
echo $form->field($models,'category_id')->dropDownList($catesArr);

echo \yii\bootstrap\Html::submitButton("提交",['class'=>'btn btn-info']);
$form=\yii\bootstrap\ActiveForm::end();
