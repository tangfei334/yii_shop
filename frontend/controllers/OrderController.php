<?php

namespace frontend\controllers;

use backend\models\Goods;
use frontend\models\Address;
use frontend\models\Car;
use frontend\models\Delivery;
use frontend\models\Order;
use frontend\models\OrderDetail;
use frontend\models\Pay;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class OrderController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if (\Yii::$app->user->isGuest){

            return $this->redirect(['/user/login','url'=>'order/index']);
        }


        //支付方式
        $pay=Pay::find()->all();
        //当前用户的地址对象
        $address=Address::find()->all();
        //当前用户的商品对象
        $carts=Car::find()->where(['user_id'=>\Yii::$app->user->id])->all();
        //取出所有送货方式
        $deliverys=Delivery::find()->all();
        //定义一个默认的运费
        $yunfei=Delivery::findOne(['status'=>1])->price;
        $cart=ArrayHelper::map($carts,'goods_id','amount');
        $goodIds=array_keys($cart);

        //取购物车的所有商品
        $goods=Goods::find()->where(['in','id',$goodIds])->all();
        $shopPrice=0;
        foreach ($goods as $good){
            $shopPrice+=$good->shop_price*$cart[$good->id];

        }
        $shopPrice=number_format($shopPrice,'2');

//        var_dump($shopPrice);exit;
        //用户id
        $userId=\Yii::$app->user->id;
        $request=\Yii::$app->request;
        if($request->isPost){
            $db = \Yii::$app->db;
            $transaction = $db->beginTransaction();//开启事务

            try {
                //创建一个订单对象
                $order=new Order();
                $addressId= $request->post('address_id');
                //取出当前用户地址
                $addresss=Address::findOne(['user_id'=>$userId,'id'=>$addressId]);
                //取出地址送货方式
                $deliveryId=$request->post('delivery');
                $delivery=Delivery::findOne($deliveryId);
                //取出支付方式
                $payId=$request->post("pay");
                $pays=Pay::findOne($payId);
                //给order赋值
                $order->user_id=$userId;
                $order->name=$addresss->name;
//            var_dump($order->name);exit;
                $order->province=$addresss->province;
                $order->city=$addresss->city;
                $order->county=$addresss->county;
                $order->detail_address=$addresss->address;
                $order->mobile=$addresss->mobile;

                //送货方式
                $order->delivery_id=$deliveryId;
                $order->delivery_name=$delivery->name;
//            var_dump($order->delivery_name);exit;
                $order->delivery_price=$delivery->price;
//            var_dump($delivery->price);exit;

                //支付方式
                $order->pay_id=$payId;
//            var_dump($order->pay_id);exit;
                $order->pay_name=$pays->name;

//            var_dump($order->pay_name);exit;
                //总价
                $order->price=$delivery->price+$shopPrice;
//            var_dump($order->price);exit;
                $order->status=1;
                //订单号
                $order->trade_no=date('ymdHis').rand(1000,9999);
                $order->create_time=time();
//            var_dump($goods);exit;
                //保存数据
                if($order->save()){
                    //循环商品 在入商品详情表
                    foreach ( $goods as $good){
                        //找出商品
                        $curGood=Goods::findOne($good->id);
                        //判断当前商品够不够
                        if($cart[$good->id]>$curGood->stock){

                            //抛出异常
                            throw new Exception('库存不足');

                        }
                        $order_detail=new OrderDetail();
                        //赋值
                        $order_detail->order_id=$order->id;
                        $order_detail->goods_id=$good->id;
                        $order_detail->amount=$cart[$good->id];
                        $order_detail->goods_name=$good->name;
                        $order_detail->logo=$good->logo;
                        $order_detail->price=$good->shop_price;
                        $order_detail->total_price=$good->shop_price*$order_detail->amount;
                        //保存数据
                        if ($order_detail->save()) {
                            $curGood->stock=$curGood->stock-$cart[$good->id];

//                       var_dump( $curGood->stock);exit;
                            $curGood->save(false);
                        }

                    }
                }

                $transaction->commit();//提交事务
                return Json::encode([
                    'status'=>1,
                    'msg'=>'订单提交成功'
                ]);

            } catch(Exception $e) {

                $transaction->rollBack();// 回滚
                return Json::encode([
                    'status'=>0,
                    'msg'=>$e->getMessage()
                ]);

                throw $e;
            }



        }



        return $this->render('index',compact('address','goods','cart','deliverys','yunfei','pay'));
    }

}
