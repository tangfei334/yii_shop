<?php

namespace backend\controllers;

use backend\models\AuthItem;
use yii\helpers\ArrayHelper;

class RoleController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //1  创建对象
        $auth=\Yii::$app->authManager;
        //2 找到所有角色
        $model=$auth->getRoles();
        return $this->render('index',compact('model'));
    }
    public function actionAdd(){
        //创建对象
        $models=new AuthItem();
        //1.创建auth对象
        $auth=\Yii::$app->authManager;
        //得到所有权限
        $pers=$auth->getPermissions();
        $persArr=ArrayHelper::map($pers,'name','description');
//        var_dump($persArr);exit;
        $request=\Yii::$app->request;
        //判断提交方式
        if($request->isPost){
            $models->load($request->post());
            if($models->validate()){
//
//                var_dump($models->permissions);exit;
//                if($models->save()){
//                 return $this->redirect(['index']);
//                }
                //创建角色
                $role=$auth->createRole($models->name);
                //设置描述
                $role->description=$models->description;
                //角色入库
                $auth->add($role);
                //给角色添加权限 是个数组 必须循环
                //判断
                if($models->permissions){
                    foreach ($models->permissions as $perName){
                        //通过权限名称找到对象
                        $per=$auth->getPermission($perName);
//                    给角色添加权限 父子 父子关系
                        $auth->addChild($role,$per);

                    }
                }

                //提示
                \Yii::$app->session->setFlash('success','角色'.$models->name.'添加成功');
                //刷新
                return $this->redirect(['index']);


            }
        }







        return $this->render('add',compact('models','persArr'));
    }
    //角色编辑
    public function actionEdit($name){
        //创建对象
        $models=AuthItem::findOne($name);
        //1.创建auth对象
        $auth=\Yii::$app->authManager;
        //得到所有权限
        $pers=$auth->getPermissions();
        $persArr=ArrayHelper::map($pers,'name','description');
        //得到当前角色对应的所有权限
        $rolePers=$auth->getPermissionsByRole($name);
//        var_dump($rolePers);exit;
        $models->permissions=array_keys($rolePers);
        $request=\Yii::$app->request;
        //判断提交方式
        if($request->isPost){
            $models->load($request->post());
            if($models->validate()){
//
//                var_dump($models->permissions);exit;
//                if($models->save()){
//                 return $this->redirect(['index']);
//                }
                //编辑角色
                $role=$auth->getRole($models->name);
                //设置描述
                $role->description=$models->description;
                //编辑角色
                $auth->update($models->name,$role);
                //编辑之前 删除当前角色对应的权限
                $auth->removeChildren($role);
                //给角色添加权限 是个数组 必须循环
                //判断
                if($models->permissions){
                    foreach ($models->permissions as $perName){
                        //通过权限名称找到对象
                        $per=$auth->getPermission($perName);
//                    给角色添加权限 父子 父子关系
                        $auth->addChild($role,$per);

                    }
                }

                //提示
                \Yii::$app->session->setFlash('success','角色'.$models->name.'编辑成功');
                //刷新
                return $this->redirect(['index']);


            }
        }







        return $this->render('edit',compact('models','persArr'));
    }
    public function actionDel($name){
        //1 创建 auth对象
        $auth=\Yii::$app->authManager;
        //2 找到权限
        $role=$auth->getRole($name);
        //3
        if($auth->remove($role)){

            \Yii::$app->session->setFlash('success','删除成功');

            return $this->redirect(['index']);
        }


    }

}
