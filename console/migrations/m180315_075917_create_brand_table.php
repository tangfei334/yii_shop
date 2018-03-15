<?php

use yii\db\Migration;

/**
 * Handles the creation of table `brand`.
 */
class m180315_075917_create_brand_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('brand', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->notNull()->comment('名称'),
            'logo'=>$this->string()->notNull()->comment('图像'),
            'sort'=>$this->integer()->notNull()->comment('排序'),
            'status'=>$this->smallInteger()->notNull()->comment('排序'),
            'intro'=>$this->text()->notNull()->comment('简介')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('brand');
    }
}
