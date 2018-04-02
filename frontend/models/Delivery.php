<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "delivery".
 *
 * @property int $id
 * @property string $name
 * @property string $price
 * @property string $intro
 */
class Delivery extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            [['name', 'intro','price'], 'required'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'intro' => 'Intro',
        ];
    }
}
