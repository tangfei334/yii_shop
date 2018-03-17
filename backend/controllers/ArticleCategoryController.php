<?php

namespace backend\controllers;

use backend\models\ArticleCategory;
use yii\data\Pagination;

class ArticleCategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //获取数据
        $query=ArticleCategory::find();
        //数据的总条数 每页显示多少条 当前页
        $conunt=$query->count(); // 得到总的条数
        //创建一个分页对象
        $page= new Pagination([
            'pageSize' => 2, //每页显示条数
            'totalCount' => $conunt,  //总条数
        ]);
        //查数据
        $model=$query->offset($page->offset)->limit($page->limit)->all();
        return $this->render('index',compact('model','page'));
    }

    public function actionAdd(){
        $models=new ArticleCategory();
         $request=\Yii::$app->request;
         if($request->isPost){
             //绑定数据
             $models->load($request->post());
             //后台验证
             if($models->validate()){
                 //保存数据
                 if($models->save()){
                     \Yii::$app->session->setFlash('success','');

                     return $this->redirect(['index']);
                 }

             }else{

                 //打印错误信息
                 var_dump($models->errors);exit;
             }

         }

        return $this->render('add',compact('models'));
    }
    public function actionEdit($id){
        $models=ArticleCategory::findOne($id);
        $request=\Yii::$app->request;
        if($request->isPost){
            //绑定数据
            $models->load($request->post());
            //后台验证
            if($models->validate()){
                //保存数据
                if($models->save()){

                    return $this->redirect(['index']);
                }

            }else{

                //打印错误信息
                var_dump($models->errors);exit;
            }

        }

        return $this->render('add',compact('models'));
    }
    public function actionDel($id){

        $model=ArticleCategory::findOne($id)->delete();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect('index');
    }

}
