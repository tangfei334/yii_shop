<?php

namespace backend\controllers;

use backend\models\Category;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;

class CategoryController extends \yii\web\Controller
{

    public function actionIndex()
    {
        $query = Category::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        $models=Category::find()->all();
        return $this->render('index',compact('dataProvider'));
    }
    public function actionAdd(){
        $models=new Category();
        //查出所以分类
        $model=Category::find()->asArray()->all();
//        var_dump($models);exit;
        //追加一个一级分类
         $model[]=['id'=>0,'name'=>'一级分类','parent_id'];
         //转换成json格式
        $modelJson=Json::encode($model);
//        var_dump($modelsJson);exit;
        $request=\Yii::$app->request;
        if($request->isPost){
            //绑定数据
            $models->load($request->post());
            //后台验证
            if ($models->validate()) {
                //如果parent_id=0 添加一级分类
                if($models->parent_id==0){
                    //创建一个一级分类
                    $models->makeRoot();
                    \Yii::$app->session->setFlash('success','创建一级分类:'.$models->name.'成功');
                    return  $this->refresh();
                }else{
//                    添加子类、找到父级的对象
                    $modelsParent=Category::findOne($models->parent_id);
//                    var_dump($modelsParent);exit;
                    //把新的分类加入到父类中
                    $models->prependTo($modelsParent);

                    \Yii::$app->session->setFlash('success',"创建{$modelsParent->name}级分类的子分类:".$models->name.'成功');
                    //刷新
                    return  $this->refresh();

                }

            }else{
                //打印错误
                 var_dump($models->errors);exit;
            }
        }


        return $this->render('add',compact('models','modelJson'));
    }
    public function actionUpdate($id){
        $models=Category::findOne($id);
        //查出所以分类
        $model=Category::find()->asArray()->all();
//        var_dump($models);exit;
        //追加一个一级分类
        $model[]=['id'=>0,'name'=>'一级分类','parent_id'];
        //转换成json格式
        $modelJson=Json::encode($model);
//        var_dump($modelsJson);exit;
        $request=\Yii::$app->request;
        if($request->isPost){
            //绑定数据
            $models->load($request->post());
            //后台验证
            if ($models->validate()) {
                //如果parent_id=0 添加一级分类
                if($models->parent_id==0){
                    //创建一个一级分类
                    $models->makeRoot();
                    \Yii::$app->session->setFlash('success','创建一级分类:'.$models->name.'成功');
                    return  $this->refresh();
                }else{
//                    添加子类、找到父级的对象
                    $modelsParent=Category::findOne($models->parent_id);
//                    var_dump($modelsParent);exit;
                    //把新的分类加入到父类中
                    $models->prependTo($modelsParent);

                    \Yii::$app->session->setFlash('success',"创建{$modelsParent->name}级分类的子分类:".$models->name.'成功');
                    //刷新
                    return  $this->refresh();

                }

            }else{
                //打印错误
                var_dump($models->errors);exit;
            }
        }


        return $this->render('add',compact('models','modelJson'));
    }
    public function actionDelete($id){
        $model=Category::findOne($id)->delete();
        \Yii::$app->session->setFlash('success','删除数据成功');
        return $this->redirect(['index']);
    }

}
