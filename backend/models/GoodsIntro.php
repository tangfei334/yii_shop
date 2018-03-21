<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/19
 * Time: 22:02
 */

namespace backend\models;


use yii\db\ActiveRecord;

class GoodsIntro extends ActiveRecord
{
    public function rules()
    {
        return [
            [['intro'],'required']
        ];
    }
    public function attributeLabels()
    {
        return [
            'intro'=>'简介',
            'goods_id'=>'商品ID',
        ];
    }
}