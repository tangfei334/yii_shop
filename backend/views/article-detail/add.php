<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/17
 * Time: 15:54
 */
$from=\yii\bootstrap\ActiveForm::begin();
echo $from->field($models,'name');
$from=\yii\bootstrap\ActiveForm::end();