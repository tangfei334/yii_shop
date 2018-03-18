<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 */
class m180318_034100_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('商品名称'),
            'left' => $this->integer()->notNull()->comment('左值'),
            'right' => $this->integer()->notNull()->comment('右值'),
            'deep' => $this->integer()->notNull()->comment('深度'),
            'intro'=>$this->string()->comment('简介'),
            'tree' => $this->integer()->notNull()->comment('树'),
            'parent_id'=>$this->integer()->notNull()->comment('父级ID'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('category');
    }
}
