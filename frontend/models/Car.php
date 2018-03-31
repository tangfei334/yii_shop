<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "car".
 *
 * @property int $id
 * @property int $user_id
 * @property int $goods_id
 * @property int $status
 * @property int $create_
 */
class Car extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['user_id', 'goods_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'goods_id' => 'Goods ID',
            'status' => 'Status',
            'create_' => 'Create',
        ];
    }
}
