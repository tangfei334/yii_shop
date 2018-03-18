<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $name 文章标题
 * @property string $intro 文章内容
 * @property int $status 状态
 * @property int $sort 排序
 * @property int $create_tome 创建时间
 * @property int $update_time 更新时间
 * @property int $article_category 分类ID
 */
class Article extends \yii\db\ActiveRecord
{

    public function rules()
    {
        return [
            [['name', 'intro', 'sort'], 'required'],
            [['status','category_id'],'safe'],
            [['name'],'unique']

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '文章标题',
            'intro' => '文章内容',
            'status' => '状态',
            'sort' => '排序',
            'create_tome' => '创建时间',
            'update_time' => '更新时间',
            'category_id' => '分类ID',
        ];
    }
    //一对一
    //分类
    public function getArticle(){

        return $this->hasOne(ArticleCategory::className(),['id'=>'category_id']);
    }
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['create_time', 'update_time'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['update_time'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                // 'value' => new Expression('NOW()'),
            ],
        ];
    }
}
