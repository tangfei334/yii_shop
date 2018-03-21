<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods_logo".
 *
 * @property int $id
 * @property string $path 图片地址
 * @property int $goods_id 商品ID
 */
class GoodsLogo extends \yii\db\ActiveRecord
{


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'path' => '图片地址',
            'goods_id' => '商品ID',
        ];
    }
}
