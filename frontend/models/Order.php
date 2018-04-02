<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $province
 * @property string $city
 * @property string $county
 * @property string $detail_address
 * @property string $mobile
 * @property int $delivery_id
 * @property string $delivery_name
 * @property string $delivery_price
 * @property int $pay_id
 * @property string $pay_name
 * @property string $price
 * @property int $status
 * @property string $trade_no 货号
 * @property int $create_time
 */
class Order extends \yii\db\ActiveRecord
{


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'province' => 'Province',
            'city' => 'City',
            'county' => 'County',
            'detail_address' => 'Detail Address',
            'mobile' => 'Mobile',
            'delivery_id' => 'Delivery ID',
            'delivery_name' => 'Delivery Name',
            'delivery_price' => 'Delivery Price',
            'pay_id' => 'Pay ID',
            'pay_name' => 'Pay Name',
            'price' => 'Price',
            'status' => 'Status',
            'trade_no' => '货号',
            'create_time' => 'Create Time',
        ];
    }
}
