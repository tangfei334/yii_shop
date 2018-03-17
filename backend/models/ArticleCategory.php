<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article_category".
 *
 * @property int $id
 * @property string $name 名称
 * @property string $intro 简介
 * @property int $status 状态
 * @property int $sort 排序
 * @property int $is_help 是否需要帮助
 */
class ArticleCategory extends \yii\db\ActiveRecord
{
    public static $status=[0=>'上线',1=>'下线'];
    public static $is_help=[0=>'是',1=>'否'];
    public function rules()
    {
        return [
            [['name', 'intro', 'sort'], 'required'],
            [['status','is_help'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'intro' => '简介',
            'status' => '状态',
            'sort' => '排序',
            'is_help' => '是否需要帮助',
        ];
    }
}
