<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/31
 * Time: 11:51
 */

namespace frontend\components;


use frontend\models\Car;
use yii\base\Component;
use yii\web\Cookie;

class shopCart extends Component
{
    public $cart;
    public function __construct(array $config = [])
    {
        $getCookie=\Yii::$app->request->cookies;
//            //得到原来的车的数据
        $this->cart=$getCookie->getValue('cart',[]);
        parent::__construct($config);
    }

    public function add($id,$num){

//        array_key_exists($id,$this->cart);
        if(array_key_exists($id,$this->cart)){
            //已经存下 累加
            $this->cart[$id]+=$num;
        }else{
            $this->cart[$id]=(int)$num;
        }
        return $this;

    }
    //保存
    public function save(){
//        caoz创建cookie对象
            $setCookie=\Yii::$app->response->cookies;
            $cookie=new Cookie([
                'name'=>'cart',
                'value' => $this->cart,
                'expire' => time()+3600*24*30*12
            ]);

            //2 设置cookie对象添加cookie
            $setCookie->add($cookie);
    }
    //修改
    public function update($id,$num){
        //修改对应的数据
        if ($this->cart[$id]){
            $this->cart[$id] = $num;
        }
        return $this;
    }
    //删除
    public function del($id){
        //删除当前数据
        unset($this->cart[$id]);
        return $this;
    }
    public function get(){
        return $this->cart;
    }
    //同步到数据库
    public function dbSyn(){
        //当前用户
       $userId = \Yii::$app->user->id;
       foreach ($this->cart as $goodsId=>$num){
           //判断当前用户当前de 商品有没有存在
           $cartDb=Car::findOne(["goods_id"=>$goodsId,'user_id'=>$userId]);
           if ($cartDb){
               //+ 修改操作
               $cartDb->amount+=$num;
               // $cart->save();
           }else{
               //创建对象
               $cartDb=new Car();
               //赋值
               $cartDb->goods_id=$goodsId;
               $cartDb->num=$num;
               $cartDb->user_id=$userId;
           }
           //保存
           $cartDb->save();
       }
       return $this;

    }
    public function flush(){
        //清空本地购物车
        $this->cart=[];
        return $this;
    }

}