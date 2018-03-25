<?php

namespace backend\controllers;

use backend\models\AuthItem;

class PermissionController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model=AuthItem::find()->all();
       return $this->render('index',compact('model'));
    }


    public function actionAdd(){
        //创建对象
        $models=new AuthItem();
        $request=\Yii::$app->request;
        //判断提交方式
        if($request->isPost){
            $models->load($request->post());
            if($models->validate()){
//                if($models->save()){
//                 return $this->redirect(['index']);
//                }  //1.创建auth对象
                $auth=\Yii::$app->authManager;
                //创建权限
                $per=$auth->createPermission($models->name);
                //设置描述
                $per->description=$models->description;
                //权限入库
                $auth->add($per);
                //提示
                \Yii::$app->session->setFlash('success','权限'.$models->name.'添加成功');
                //刷新
                return $this->refresh();


            }
        }







        return $this->render('add',compact('models'));
    }
    public function actionEdit($name){
        //创建对象
        $models=AuthItem::findOne($name);
        $request=\Yii::$app->request;
        //判断提交方式
        if($request->isPost){
            $models->load($request->post());
            if($models->validate()){
//                if($models->save()){
//                 return $this->redirect(['index']);
//                }  //1.创建auth对象
                $auth=\Yii::$app->authManager;
                //创建权限
                $per=$auth->createPermission($models->name);
                //设置描述
                $per->description=$models->description;
                //权限入库
                if($auth->update($models->name,$per)){
                    //提示
                    \Yii::$app->session->setFlash('success','权限'.$models->name.'添加成功');
                    //刷新
                    return $this->refresh();

                }



            }else{

                var_dump($models->errors);
            }
        }







        return $this->render('edit',compact('models'));
    }
    //权限删除
    public function actionDel($name){
        //1 创建 auth对象
        $auth=\Yii::$app->authManager;
        //2 找到权限
        $per=$auth->getPermission($name);
        //3
        if($auth->remove($per)){

            \Yii::$app->session->setFlash('success','删除成功');

            return $this->redirect(['index']);
        }


    }

}
