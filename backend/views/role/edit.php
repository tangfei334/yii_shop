<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/23
 * Time: 16:25
 */
/** @var $this \yii\web\View */

$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($models,'name')->textInput(['disabled'=>'disabled']);
echo $form->field($models,'description');
echo $form->field($models,'permissions')->inline()->checkboxList($persArr);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
$form=\yii\bootstrap\ActiveForm::end();
