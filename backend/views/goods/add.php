<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/19
 * Time: 15:21
 */
/** @var $this \yii\web\View */
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($models,'name');
echo $form->field($models,'sn');
echo $form->field($models,'logo')->widget(\manks\FileInput::className());
echo $form->field($models,'imgs')->widget(\manks\FileInput::className(),[
        'clientOptions' => [
            'pick' => [
                'multiple' => true,
            ],
            // 'server' => Url::to('upload/u2'),
            // 'accept' => [
            //     'extensions' => 'png',
            // ],
        ],
]);
echo $form->field($intro,'intro')->widget(kucha\ueditor\UEditor::className());
echo $form->field($models,'goods_category_id')->dropDownList($categoryArr,['prompt'=>'请选择']);
echo $form->field($models,'make_price');
echo $form->field($models,'shop_price');
echo $form->field($models,'stock');
echo $form->field($models,'brand_id')->dropDownList($brandArr,['prompt'=>'请选择']);
echo $form->field($models,'status')->inline()->radioList([0=>'下架',1=>'上架'],['value'=>1]);;

echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
$form=\yii\bootstrap\ActiveForm::end();
