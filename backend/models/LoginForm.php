<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/22
 * Time: 13:54
 */

namespace backend\models;


use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
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