<?php

namespace backend\controllers;

use backend\models\Article;
use backend\models\ArticleCategory;
use backend\models\ArticleDetail;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

class ArticleController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ]
        ];
    }
    public function actionIndex()
    {
        //获取数据
        $query=Article::find();
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
        $models=new Article();
        $content=new ArticleDetail();
//        var_dump($content);exit;
        //取到分类的数据
        $cates=ArticleCategory::find()->all();
        //把二维数组转换成一维
        $catesArr=ArrayHelper::map($cates,'id','name');

        $request=\Yii::$app->request;
        if ($request->isPost) {
            //绑定数据
            $models->load($request->post());
            //后台验证
            if($models->validators){
                //保存数据
                 if($models->save()){
                     //文章内容数据的绑定
                      $content->load($request->post());
                  //验证
                     if($content->validate()){
                         $content->article_id=$models->id;
                         //保存内容
                          if($content->save()){

                              return $this->redirect(['index']);
                          }else{

                              var_dump( $content->errors);exit;
                          }

                     }

                 }

            }else{

                var_dump($models->errors);exit;
            }
        }

        return $this->render('add',compact('models','catesArr','content'));
    }
    public function actionEdit($id){
        $models=Article::findOne($id);
        $content=new ArticleDetail();
//        var_dump($content);exit;
        //取到分类的数据
        $cates=ArticleCategory::find()->all();
        //把二维数组转换成一维
        $catesArr=ArrayHelper::map($cates,'id','name');

        $request=\Yii::$app->request;
        if ($request->isPost) {
            //绑定数据
            $models->load($request->post());
            //后台验证
            if($models->validators){
                //保存数据
                if($models->save()){
                    //文章内容数据的绑定
                    $content->load($request->post());
                    //验证
                    if($content->validate()){
                        $content->article_id=$models->id;
                        //保存内容
                        if($content->save()){

                            return $this->redirect(['index']);
                        }else{

                            var_dump( $content->errors);exit;
                        }

                    }

                }

            }else{

                var_dump($models->errors);exit;
            }
        }

        return $this->render('add',compact('models','catesArr','content'));
    }
    public function actionDel($id){
        $models=Article::findOne($id)->delete();
        return $this->redirect(['index']);
    }

}
