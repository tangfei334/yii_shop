<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 14:47
 */
/** @var $this \yii\web\View */
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($models,'name');
echo $form->field($models,'name');
echo \yii\bootstrap\Html::submitButton('登录',['class'=>'btn btn-danger']);
$form=\yii\bootstrap\ActiveForm::end();
