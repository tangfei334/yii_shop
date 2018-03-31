<?php

namespace frontend\controllers;

use backend\models\Goods;
use frontend\models\Car;
use function Sodium\add;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Cookie;

class GoodsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionDetail($id){
        $goods=Goods::findOne($id);


        return $this->render('detail',compact('goods'));
    }

    /**
     * @param $id商品id
     * @param $amount 商品数量
     * @return string
     *
     */
    public function actionAddCart($id,$amount)
    {
//        var_dump($id,$amount);
        //未登录保存cookie
        if(\Yii::$app->user->isGuest){
            //得到cookie对象

            $getCookie=\Yii::$app->request->cookies;
//            //得到原来的车的数据
            $cart=$getCookie->getValue('cart',[]);
//            //判断是否存在
//            var_dump( array_key_exists($id,$cart));exit;
            if(array_key_exists($id,$cart)){
                //已经存下 累加
                $cart[$id]+=$amount;
            }else{
                   $cart[$id]=(int)$amount;
            }
//            var_dump($cart);exit;

            //caoz创建cookie对象
            $setCookie=\Yii::$app->response->cookies;
            $cookie=new Cookie([
                'name'=>'cart',
                'value' => $cart
            ]);

            //2 设置cookie对象添加cookie
            $setCookie->add($cookie);

        }else{
            //  登录保存数据库
            $cart=new Car();
            $cart_goods=Car::find()->where(['goods_id'=>$id,'user_id'=>\Yii::$app->user->id])->one();
            if($cart_goods){
                $cart_goods->amount+=$amount;
                $cart_goods->save();
            }else{
                $cart->amount=$amount;
                $cart->goods_id=$id;
                $cart->user_id=\Yii::$app->user->id;
                $cart->save();
            }

        }

        return $this->redirect(['goods/cart-list']);
    }
    public function actionCartList(){
//        判断登录状态
        if(\Yii::$app->user->isGuest){
            //从cookie中取出购物车的数据
            $cart=\Yii::$app->request->cookies->getValue('cart',[]);
//            var_dump(array_key_exists($cart));exit;
//            var_dump(array_keys($cart));exit;

            $goodIds=array_keys($cart);
            //取购物车的所有商品
            $goods=Goods::find()->where(['in','id',$goodIds])->all();
//            var_dump($goods);exit;
        }else{
            //登录
            $carts=Car::find()->where(['user_id'=>\Yii::$app->user->id])->all();
            $cart=ArrayHelper::map($carts,'goods_id','amount');
            $goodIds=array_keys($cart);
            //取购物车的所有商品
            $goods=Goods::find()->where(['in','id',$goodIds])->all();


        }

//        return $this->render('list',compact('goods'));
        return $this->render('list',compact('goods','cart'));

    }
    public function actionUpdateCart($id,$amount){
        if(\Yii::$app->user->isGuest){
            $cart=\Yii::$app->request->cookies->getValue('cart',[]);
            //修改对应的数据
            $cart[$id]=$amount;
            //把cart存到购物车中

            $setCookie=\Yii::$app->response->cookies;
            $cookie=new Cookie([
                'name'=>'cart',
                'value' => $cart
            ]);

            //2 设置cookie对象添加cookie
            $setCookie->add($cookie);
        }else{
            //登录
            $cart_goods=Car::find()->where(['goods_id'=>$id,'user_id'=>\Yii::$app->user->id])->one();
            $cart_goods->amount=$amount;
            $cart_goods->save();

        }

    }
    public function actionDelCart($id){
        if(\Yii::$app->user->isGuest){
            $cart=\Yii::$app->request->cookies->getValue('cart',[]);
            //修改对应的数据
            unset($cart[$id]);
            //把cart存到购物车中

            $setCookie=\Yii::$app->response->cookies;
            $cookie=new Cookie([
                'name'=>'cart',
                'value' => $cart
            ]);

            //2 设置cookie对象添加cookie
            $setCookie->add($cookie);
            return Json::encode([
               'status'=>1,
                'msg'=>'删除成功'
            ]);
        }else{
            $cart_goods=Car::find()->where(['goods_id'=>$id,'user_id'=>\Yii::$app->user->id])->one();
            $cart_goods->delete();
            return Json::encode([
                'status'=>1,
                'msg'=>'删除成功'
            ]);
        }

    }
    public function actionTest()
    {
        $getCookie = \Yii::$app->request->cookies;
        var_dump($getCookie->getValue('cart'));
    }

}
