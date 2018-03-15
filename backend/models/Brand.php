<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property int $id
 * @property string $name 名称
 * @property string $logo 图像
 * @property int $sort 排序
 * @property int $status 排序
 * @property string $intro 简介
 */
class Brand extends \yii\db\ActiveRecord
{
    public $img;
    public static $status=[0=>'上线',1=>'下线'];
    public $code;
    public function rules()
    {
        return [
            [['name', 'sort', 'intro'], 'required'],
            [['img'],'image','extensions' => ['jpg','png']],
            [['status'],'safe'],
            [['code'],'captcha']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'img' => '图像',
            'sort' => '排序',
            'status' => '排序',
            'intro' => '简介',
            'code'=>'验证码',
        ];
    }
}
