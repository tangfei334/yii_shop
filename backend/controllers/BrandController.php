<?php

namespace backend\controllers;

use backend\models\Brand;
use yii\data\Pagination;
use yii\helpers\Json;
use yii\web\UploadedFile;
use crazyfd\qiniu\Qiniu;
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
            //绑定数据
            $models->load($request->post());
//            var_dump($models);exit;
            //后台验证
            if($models->validate()){
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
            //绑定数据
            $models->load($request->post());
            //后台验证
            if($models->validate()){



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

    //upload图片的上传
    public function actionUpload()
    {
        switch (\Yii::$app->params['uploadType']){

            case '127.0.0.1':
                //通过name找到图片
                $fileobj = UploadedFile::getInstanceByName('file');
//        var_dump($file);
                //移动临时文件到web目录
                if ($fileobj !== null){
                    //拼路径
                    $filePath="images/".time().'.'.$fileobj->extension;

                    if ($fileobj->saveAs($filePath,false)) {
                        // 正确时， 其中 attachment 指的是保存在数据库中的路径，url 是该图片在web可访问的地址
//                {"code": 0, "url": "http://domain/图片地址", "attachment": "图片地址"}
                        $yes=[
                            'code'=>0,
                            'url'=>'/'.$filePath,
                            'attachment'=>$filePath
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
                //七牛
            case 'qiniu':
                $ak = 'g55WlYZmAcfjlQDw4CgilVkj-JiDkt6I7RtcPQM9';
                $sk = '2XVES6fEUq2aK14htnOjSVf-7cOFd-2RHfknBjcy';
                $domain = 'http://p5obj1i27.bkt.clouddn.com';//域名
                $bucket = 'php1108';//空间名称
                $zone = 'south_china';
                //创建七牛云对象
                $qiniu = new Qiniu($ak, $sk,$domain, $bucket,$zone);
                $key = time();
//        拼路径
                $key = $key.strtolower(strrchr($_FILES['file']['name'], '.'));
//        var_dump($key);exit;

                $qiniu->uploadFile($_FILES['file']['tmp_name'],$key);
//        var_dump($qiniu);exit;
                $url = $qiniu->getLink($key);


                $yes=[
                    'code'=>0,
                    'url'=>$url,
                    'attachment'=>$url,

                ];
                //返回json数据
                return Json::encode($yes);

        }

}




}
