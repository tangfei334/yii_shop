<?php

namespace frontend\controllers;

use frontend\models\Address;
use yii\helpers\Json;

class AddressController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $address=Address::find()->where(['user_id'=>\Yii::$app->user->id])->all();
        return $this->render('address',compact('address'));
    }
    public function actionAdd(){
        $address=new Address();
        $request=\Yii::$app->request;
        if ($request->isPost) {
            //绑定数据
             $address->load($request->post());
//            var_dump($aa);exit;
            //验证
            if($address->validate()){
                //给user_id赋值
                $address->user_id=\Yii::$app->user->id;
//                var_dump($address->user_id);exit;
                //判断 status
                if($address->status!=null){
                    Address::updateAll(['status'=>0],['user_id'=>$address->user_id]);
                    $address->status=1;
                }
                if($address->save()){
                    $result=[
                        'status'=>1,
                        'msg'=>'保存成功',
                        'data'=>"",
                    ];

                    return Json::encode($result);

                }
            }else{
                $result=[
                    'status'=>0,
                    'msg'=>'保存失败',
                    'data'=>$address->errors,

                ];
                return Json::encode($result);
            }

        }
        return $this->render('address');
    }

    public function actionDel($id){
        $address=Address::findOne(['id'=>$id,'user_id'=>\Yii::$app->user->id])->delete();
        if($address){
            return $this->redirect(['index']);
        }

    }

}
