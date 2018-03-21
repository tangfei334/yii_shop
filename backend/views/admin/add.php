<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 9:46
 */
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($models,'name');
echo $form->field($models,'password');
echo $form->field($models,'salt');
echo $form->field($models,'email');
echo $form->field($models,'token');
//echo $form->field($models,'name');
echo  \yii\bootstrap\Html::submitButton('注册',['class'=>'btn btn-info']);


$form=\yii\bootstrap\ActiveForm::end();