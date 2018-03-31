<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/27
 * Time: 14:00
 */

namespace frontend\models;


use yii\base\Model;

class LoginForm extends Model
{

    public function rules()
    {
        return [
            [['username','password'],'required']
        ];
    }
    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'password'=>'密码'
        ];
    }
}