<?php

namespace backend\controllers;

use backend\models\Brand;
use backend\models\Category;
use backend\models\Goods;
use backend\models\GoodsIntro;
use backend\models\GoodsLogo;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\UploadedFile;

class GoodsController extends \yii\web\Controller
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
        $query=Goods::find();
        $minPrice=\Yii::$app->request->get('minPrice');
        $maxPrice=\Yii::$app->request->get('maxPrice');
        $keyWord=\Yii::$app->request->get('keyWord');
        //加条件
        if($minPrice){
            $query->andWhere("shop_price>={$minPrice}");
        }
        if($maxPrice){
            $query->andWhere("shop_price<={$maxPrice}");
        }if($keyWord){
            $query->andWhere("name like '%{$keyWord}%' or sn like '%{$keyWord}%'");
        }

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
        $models=new Goods();
        $intro=new GoodsIntro();
        //取到分类的数据
        $category=Category::find()->all();
//        var_dump($brands);exit;
        $categoryArr=ArrayHelper::map($category,'id','name');
        //取得品牌数据
        $brand=Brand::find()->all();
        $brandArr=ArrayHelper::map($brand,'id','name');
        $request=\Yii::$app->request;
        if($request->isPost){
            //绑定数据
            $models->load($request->post());
            // 绑定商品详情
            $intro->load($request->post());
            //后台验证
            if($models->validate() && $intro->validate()){
//                $models->create_time=time();

                //判断sn又没有值
                if(!$models->sn){
                    $datyTime=strtotime(date('Ymd'));
//                    var_dump($datyTime);exit;
                    //找出当日的商品数量
                    $count=Goods::find()->where(['>','create_time',$datyTime])->count();
                    //加一
                    $count+=1;
                    $countStr='0000'.$count;
                    //取到后面5位
                    $countStr=substr($countStr,-5);
                    // 赋值
                    $models->sn=date('Ymd').$count+1;
//                    var_dump($models->sn);exit;
                }
                //保存数据
                if($models->save()){

                   //操作商品内容
                    $intro->goods_id=$models->id;
                    $intro->save();

                    //多图操作   循环imgs
                  // var_dump($models->imgs);exit;
                    foreach ($models->imgs as $img){


                        $logo=new GoodsLogo();
                        //赋值
                        $logo->goods_id=$models->id;
                        $logo->path=$img;
                        //保存
                        $logo->save();


                    }
                    //提示
                    \Yii::$app->session->setFlash('success','商品添加成功');
                    return $this->redirect(['index']);
                }
            }else{

                var_dump($models->errors);exit;
            }
        }
//        return $this->render('add',compact('models','categoryArr','brandArr');
        return $this->render('add',compact('models','categoryArr','brandArr','intro'));

    }
    public function actionEdit($id){
        $models=Goods::findOne($id);
        $intro=GoodsIntro::findOne(['goods_id'=>$id]);
        //取到分类的数据
        $category=Category::find()->all();
//        var_dump($brands);exit;
        $categoryArr=ArrayHelper::map($category,'id','name');
        //取得品牌数据
        $brand=Brand::find()->all();
        $brandArr=ArrayHelper::map($brand,'id','name');
        $request=\Yii::$app->request;
        if($request->isPost){
            //绑定数据
            $models->load($request->post());
            // 绑定商品详情
            $intro->load($request->post());
            //后台验证
            if($models->validate() && $intro->validate()){
//                $models->create_time=time();

                //判断sn又没有值
                if(!$models->sn){
                    $datyTime=strtotime(date('Ymd'));
//                    var_dump($datyTime);exit;
                    //找出当日的商品数量
                    $count=Goods::find()->where(['>','create_time',$datyTime])->count();
                    //加一
                    $count+=1;
                    $countStr='0000'.$count;
                    //取到后面5位
                    $countStr=substr($countStr,-5);
                    // 赋值
                    $models->sn=date('Ymd').$count+1;
//                    var_dump($models->sn);exit;
                }
                //保存数据
                if($models->save()){

                    //操作商品内容
                    $intro->goods_id=$models->id;
                    $intro->save();

                    //多图操作   循环imgs
                    // var_dump($models->imgs);exit;
                    GoodsLogo::deleteAll(['goods_id'=>$id]);
                    foreach ($models->imgs as $img){


                        $logo=new GoodsLogo();
                        //赋值
                        $logo->goods_id=$models->id;
                        $logo->path=$img;
                        //保存
                        $logo->save();


                    }
                    //提示
                    \Yii::$app->session->setFlash('success','商品编辑成功');
                    return $this->redirect(['index']);
                }
            }else{

                var_dump($models->errors);exit;
            }
        }
        //从数据库中找出当前商品对应的所有图片
        $images=GoodsLogo::find()->where(['goods_id'=>$id])->asArray()->all();
        $images=array_column($images,'path');
//        var_dump($images);exit;
        $models->imgs=$images;


        //显示视图
        return $this->render('add',compact('models','categoryArr','brandArr','intro'));

    }
    public function actionDel($id){

        $models=Goods::findOne($id)->delete();
        $intro=GoodsIntro::findOne(['goods_id'=>$id])->delete();
        $logo=GoodsLogo::deleteAll(['goods_id'=>$id]);


        if($models && $intro && $logo){
            \Yii::$app->session->setFlash('success','删除成功');
            return $this->redirect(['index']);
        }
    }
    //图片上传LOGO
    public function actionUp(){
//      var_dump($_FILES);exit;
        \Yii::$app->params['uploadType'];
        $imgFile = UploadedFile::getInstanceByName('file');
//        var_dump($imgFile);

        if($imgFile!==null){
            //拼路径
            $imgPath="images/".time().'.'.$imgFile->extension;
            //移动文件
            if ($imgFile->saveAs($imgPath,false)) {
                $yes=[
                    'code'=>0,
                    'url'=>'/'.$imgPath,
                    'attachment'=>$imgPath
                ];
                //返回json数据
                return Json::encode($yes);
            }else{
                //错误
                $result=[
                    'code'=>1,
                    'msg'=>'error'
                ];

                return Json::encode($result);
            }
        }

    }


}
