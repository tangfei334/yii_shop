<?php

use yii\db\Migration;

/**
 * Handles the creation of table `address`.
 */
class m180328_060440_create_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('address', [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer()->comment("用户ID"),
            'name'=>$this->string(20)->comment("姓名"),
            'province'=>$this->string(20)->comment("省份"),
            'city'=>$this->string(20)->comment("市"),
            'county'=>$this->string(20)->comment("区县"),
            'address'=>$this->string()->comment("地址"),
            'mobile'=>$this->string(20)->comment("手机号"),
            'status'=>$this->smallInteger()->defaultValue(0)->comment("状态:1 默认 0非默认"),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('address');
    }
}
