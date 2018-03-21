<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

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
    public function behaviors()
    {
        return [
            [

                'class' => TimestampBehavior::className(),
                'attributes' => [

                    ActiveRecord::EVENT_BEFORE_INSERT => ['add_time'],
//                        ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                // 'value' => new Expression('NOW()'),
            ],
        ];
    }
    public function rules()
    {
        return [
            [['username', 'password', 'salt', 'email','last_login_ip','last_login_time'], 'safe'],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '姓名',
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
