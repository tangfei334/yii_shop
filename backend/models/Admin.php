<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "admin".
 *
 * @property int $id
 * @property string $name 姓名
 * @property string $password 密码
 * @property int $salt 盐
 * @property string $email 邮箱
 * @property string $token 自动登录
 * @property string $token_create_time 令牌创建时间
 * @property int $add_time 注册时间
 * @property int $last_login_time 最后登录时间
 * @property string $last_login_ip 最后登录ip
 */
class Admin extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            [['name', 'password', 'salt', 'email'], 'required'],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '姓名',
            'password' => '密码',
            'salt' => '盐',
            'email' => '邮箱',
            'token' => '自动登录',
            'token_create_time' => '令牌创建时间',
            'add_time' => '注册时间',
            'last_login_time' => '最后登录时间',
            'last_login_ip' => '最后登录ip',
        ];
    }
}
