<?php

namespace backend\controllers;

use backend\models\Brand;
use yii\data\Pagination;
use yii\web\UploadedFile;

class BrandController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //获取数据
        $query=Brand::find();
        //数据的总条数 每页显示多少条 当前页
        $conunt=$query->count(); // 得到总的条数
        //创建一个分页对象
        $page= new Pagination([
           'pageSize' => 2, //每页显示条数
            'totalCount' => $conunt,  //总条数
        ]);
        //查数据
        $model=$query->offset($page->offset)->limit($page->limit)->all();


        return $this->render('index',compact("model",'page'));
    }

    /**
     * @return string
     */
    public function actionAdd(){

        $models=new Brand();
        $request=\Yii::$app->request;
        //搬到提交方式
        if($request->isPost){
            $imgPath="";
            //绑定数据
            $models->load($request->post());
            //图片的验证
            //1 ，得到图片
            $models->img=UploadedFile::getInstance($models,'img');
//            var_dump($models);exit;
            if($models->img!==null){

                //2.上传到路径
                $imgPath="images/".time().".".$models->img->extension;
//            var_dump($imgPath);exit;

                //3
                $models->img->saveAs($imgPath,false);
            }

//            var_dump($models);exit;
            //后台验证
            if($models->validate()){
                $models->logo=$imgPath;
                if($models->save(false)){
                    //提交
                    \Yii::$app->session->setFlash('success','添加成功');
                    return $this->redirect(['index']);
                }
            }else{

                //打印错误信息
                var_dump($models->errors);exit;
            }



        }

        return $this->render("add",compact("models"));
    }
    public function actionEdit($id){

       $models=Brand::findOne($id);
        $request=\Yii::$app->request;
        //搬到提交方式
        if($request->isPost){
            $imgPath="";
            //绑定数据
            $models->load($request->post());
            //图片的验证
            //1 ，得到图片
            $models->img=UploadedFile::getInstance($models,'img');
//            var_dump($models);exit;
            if($models->img!==null){

                //2.上传到路径
                $imgPath="images/".time().".".$models->img->extension;
//            var_dump($imgPath);exit;

                //3
                $models->img->saveAs($imgPath,false);
            }

//            var_dump($models);exit;
            //后台验证
            if($models->validate()){

                //图片回线  三元
//                $models->logo=$imgPath?:$models->logo;

                if($imgPath){
                    $models->logo=$imgPath;
                }
               ;
                if($models->save(false)){
                    \Yii::$app->session->setFlash('success','编辑成功');
                    return $this->redirect(['index']);
                }
            }else{

                //打印错误信息
                var_dump($models->errors);exit;
            }



        }

        return $this->render("add",compact("models"));
    }
    public function actionDel($id){
        $models=Brand::findOne($id)->delete();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(["index"]);
    }

}
