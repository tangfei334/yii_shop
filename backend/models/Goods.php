<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "goods".
 *
 * @property int $id
 * @property string $name 商品名称
 * @property int $sn 商品货号
 * @property string $intro 简介
 * @property int $goods_category_id 商品分类
 * @property int $brand_id 品牌
 * @property string $make_price 市场价格
 * @property string $shop_price 本店价格
 * @property int $stock 库存
 * @property int $status 状态
 * @property int $create_time 录入时间
 */
class Goods extends \yii\db\ActiveRecord
{
    public $imgs;
    public function behaviors()
    {
        return [
            [

                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['create_time'],
//                        ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                // 'value' => new Expression('NOW()'),
            ],
        ];
    }


    public function rules()
    {
        return [
            [['name','goods_category_id','brand_id','make_price','shop_price','stock','status','logo','imgs'], 'required'],
            [['intro'],'safe'],

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
            'sn' => '商品货号',
            'img'=>' 图像',
            'intro' => '简介',
            'goods_category_id' => '商品分类',
            'brand_id' => '品牌',
            'make_price' => '市场价格',
            'shop_price' => '本店价格',
            'stock' => '库存',
            'status' => '状态',
            'create_time' => '录入时间',
        ];
    }
    public function getCategory(){


        return $this->hasOne(Category::className(),['id'=>'goods_category_id']);
    }
    public function getBrand(){
        return $this->hasOne(Brand::className(),['id'=>'brand_id']);
    }
    //得到商品详情
    public function getContent(){
        return $this->hasOne(GoodsIntro::className(),['goods_id'=>'id']);
    }
    //得到商品所有图片
    public function getImages(){

        return $this->hasMany(GoodsLogo::className(),['goods_id'=>'id']);
    }
}
