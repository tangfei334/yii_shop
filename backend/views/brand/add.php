<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/15
 * Time: 16:57
 */
/** @var $this \yii\web\View */
$from=\yii\bootstrap\ActiveForm::begin();
echo $from->field($models,'name');
echo $from->field($models,'img')->fileInput();
echo $from->field($models,'sort');
echo $from->field($models,'status')->inline()->radioList([0=>'上线',1=>'下线'],['value'=>1]);
echo $from->field($models,'intro')->textarea();
echo $from->field($models,'code')->widget(\yii\captcha\Captcha::className());
echo \yii\bootstrap\Html::submitButton("提交",['class'=>'btn btn-info']);
$from=\yii\bootstrap\ActiveForm::end();
