<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admin`.
 */
class m180320_132244_create_admin_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('admin', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->notNull()->comment('姓名')->unique(),
            'password'=>$this->string()->notNull()->comment('密码'),
            'salt'=>$this->integer()->notNull()->comment('盐'),
            'email'=>$this->string()->notNull()->comment('邮箱'),
            'token'=>$this->string()->comment('自动登录'),
            'token_create_time'=>$this->string()->notNull()->comment('令牌创建时间'),
            'add_time'=>$this->integer()->notNull()->comment('注册时间'),
            'last_login_time'=>$this->integer()->notNull()->comment('最后登录时间'),
            'last_login_ip'=>$this->string()->comment('最后登录ip'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('admin');
    }
}
