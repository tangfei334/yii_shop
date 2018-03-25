<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 9:46
 */
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($models,'username');
echo $form->field($models,'password');
echo $form->field($models,'status')->inline()->radioList([0=>'下线',1=>'上线'],['value'=>0]);
//echo $form->field($models,'roles')->inline()->checkboxList($adminArr);
//echo $form->field($models,'token');
//echo $form->field($models,'name');
echo  \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);


$form=\yii\bootstrap\ActiveForm::end();