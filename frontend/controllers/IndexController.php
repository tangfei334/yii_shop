<?php

namespace frontend\controllers;

use backend\models\Category;
use backend\models\Goods;

class IndexController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionList($id){
        //通过分类ID  找到当前分类对象
      $cate=Category::findOne($id);
        //通过当前分类找到所有子孙
        $soncate=Category::find()->where(['tree'=>$cate->tree])->andWhere(['>=','left',$cate->left])->andWhere(['<=','right',$cate->right])->asArray()->all();
//        var_dump($soncate);exit;
        //得到挡墙分类的商品;
        $goods=Goods::find()->where(['goods_category_id'=>$id])->asArray()->all();
        //通过二维数组换成一位数组
        $cateIds=array_column($soncate,'id');
//        var_dump($cateIds);exit;
        //得到当前分类的所有商品
        $goods=Goods::find()->where(['in','goods_category_id',$cateIds])->all();

        return $this->render('list',compact('goods'));
    }

}
