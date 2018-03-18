<?php

namespace backend\models;

use backend\components\MenuQuery;
use creocoder\nestedsets\NestedSetsBehavior;
use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name 商品名称
 * @property int $left 左值
 * @property int $right 右值
 * @property int $deep 深度
 * @property string $intro 简介
 * @property int $tree 树
 * @property int $parent_id 父级ID
 */
class Category extends \yii\db\ActiveRecord
{
    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                 'treeAttribute' => 'tree',
                 'leftAttribute' => 'left',
                 'rightAttribute' => 'right',
                 'depthAttribute' => 'deep',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new MenuQuery(get_called_class());
    }






    public function rules()
    {
        return [
            [['name','intro'], 'required'],
            [['parent_id'],'safe']

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '商品名称',
            'left' => '左值',
            'right' => '右值',
            'deep' => '深度',
            'intro' => '简介',
            'tree' => '树',
            'parent_id' => '父级ID',
        ];
    }
}
