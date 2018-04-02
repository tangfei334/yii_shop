<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m180402_013114_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'name' => $this->string(20),
            'province' => $this->string(20),
            'city' => $this->string(20),
            'county' => $this->string(20),
            'detail_address' => $this->string(),
            'mobile' => $this->string(20),
            'delivery_id' => $this->smallInteger(1),
            'delivery_name' => $this->string(20),
            'delivery_price' => $this->decimal(7,2),
            'pay_id' => $this->smallInteger(1),
            'pay_name' => $this->string(20),
            'price' => $this->decimal(10,2),
            'status' => $this->smallInteger(1),
            'trade_no' => $this->string(20)->comment("货号"),
            'create_time' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('order');
    }
}
