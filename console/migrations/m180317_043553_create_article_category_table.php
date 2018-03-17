<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_category`.
 */
class m180317_043553_create_article_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('article_category', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->notNull()->comment('名称'),
            'intro'=>$this->text()->notNull()->comment('简介'),
            'status'=>$this->smallInteger()->notNull()->comment('状态'),
            'sort'=>$this->integer()->notNull()->comment('排序'),
            'is_help'=>$this->smallInteger()->notNull()->comment('是否需要帮助'),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('article_category');
    }
}
