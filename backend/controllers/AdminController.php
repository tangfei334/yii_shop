<?php

namespace backend\controllers;

use backend\models\Admin;
use backend\models\LoginForm;
use function Sodium\compare;

class AdminController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionAdd(){

        $models=new Admin();
        //判断提交方式
        $request=\Yii::$app->request;
        if($request->isPost){
            //绑定数据
            $models->load($request->post());
            //后台验证
            if($models->validate()){
                if($models->save()){

                    return $this->redirect(['index']);
                }
            }else{

                var_dump($models->errors);exit;
            }


        }



        return $this->render('add',compact('models'));
    }

    /**
     * @return string
     */
//    public function actionLogin(){
//         //生成一个表单模型
//        $models=new LoginForm();
//        return $this->render('login',compact('models'));
//    }


}
