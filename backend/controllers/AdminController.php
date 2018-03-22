<?php

namespace backend\controllers;

use backend\models\Admin;
use backend\models\LoginForm;
use function Sodium\compare;
use yii\web\IdentityInterface;

class AdminController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $models=Admin::find()->all();
        return $this->render('index',compact('models'));
    }
    public function actionAdd(){

        $models=new Admin();
        $models->setScenario('add');
        //判断提交方式
        $request=\Yii::$app->request;
        if($request->isPost){
            //绑定数据
            $models->load($request->post());
            //后台验证
            if($models->validate()){
                 //密码加密
//                var_dump($models->password);exit;
                $models->password=\Yii::$app->security->generatePasswordHash($models->password);

                //设置令牌 32 wei
                $models->token=\Yii::$app->security->generateRandomString();
                if($models->save()){

                    return $this->redirect(['index']);
                }
            }else{

                var_dump($models->errors);exit;
            }


        }



        return $this->render('add',compact('models'));
    }
    public function actionEdit($id){

        $models=Admin::findOne($id);
        $models->setScenario('edit');
        $password=$models->password;
        //判断提交方式
        $request=\Yii::$app->request;
        if($request->isPost){
            //绑定数据
            $models->load($request->post());
            //后台验证
            if($models->validate()){
                //三元
                $models->password=$models->password?\Yii::$app->security->generatePasswordHash($models->password):$password;
                //密码加密
//                $models->password=\Yii::$app->security->generatePasswordHash($models->password);
                if($models->save()){

                    return $this->redirect(['index']);
                }
            }else{

                var_dump($models->errors);exit;

//                return $this->redirect(['admin/login']);
            }

        }
        $models->password=null;
        return $this->render('add',compact('models'));
    }
    public function actionDel($id){
        $models=Admin::findOne($id)->delete();

        return $this->redirect(['admin/index']);

    }


    public function actionLogin(){

        $model=new LoginForm();
        $request=\Yii::$app->request;
        if($request->isPost){
            //绑定数据
            $model->load($request->post());
            //后台验证
             if($model->validate()){
                 //通过用户名找打对象
                  $admin=Admin::findOne(['username'=>$model->username]);
                  //判断用户是否存在
                 if($admin){
//                     var_dump($admin->password);exit;
//                     var_dump(\Yii::$app->security->validatePassword($model->password,$admin->password));exit;
                     //验证密码
                     if(\Yii::$app->security->validatePassword($model->password,$admin->password)){
                       //  验证密码成功
                         \Yii::$app->user->login($admin,3600*24);
                         //设置登录时间
                         $admin->last_login_time=time();
                         //用户ip
                         $admin->last_login_ip=\Yii::$app->request->userIP;
                        // $admin->save();
                         //保存用户
                         if($admin->save()){
//                             echo 1;exit;
                             \Yii::$app->session->setFlash('success','登录成功');
                             return $this->redirect(['index']);
                         }

//var_dump($admin->errors);exit;
                     }else{
                         //密码错误
                         $model->addError('password','用户名或密码错误');
//                         return $this->redirect(['admin/login']);

                     }


                 }else{
                     //用户不存在
                     $model->addError('username','用户不存在');
                 }


             }else{

                 var_dump($model->errors);exit;

             }

        }
        return $this->render('login',compact('model'));
    }
//登录退出
    public function actionLogout()
    {
        \Yii::$app->user->logout();

        return $this->redirect(['admin/login']);
    }
}
