<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m180317_055937_create_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->notNull()->comment('文章标题'),
            'intro'=>$this->text()->notNull()->comment('文章内容'),
            'status'=>$this->smallInteger()->notNull()->comment('状态'),
            'sort'=>$this->integer()->notNull()->comment('排序'),
            'create_tome'=>$this->integer()->notNull()->comment('创建时间'),
            'update_time'=>$this->integer()->notNull()->comment('更新时间'),
            'article_category'=>$this->integer()->comment('分类ID'),
        ]);
        $this->createTable('article_detail', [
            'id' => $this->primaryKey(),
            'content'=>$this->text()->notNull()->comment('内容'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('article');
        $this->dropTable('article_detail');
    }
}
