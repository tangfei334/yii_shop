<?php

namespace frontend\controllers;

use frontend\models\LoginForm;
use frontend\models\User;
use Mrgoon\AliSms\AliSms;
use yii\helpers\Json;

class UserController extends \yii\web\Controller
{
    //验证码
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength' => 3,
                'maxLength' => 3
            ],
        ];
    }
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return string
     */
    public function actionReg(){

        //判断是不是POST提交
        $request=\Yii::$app->request;
        if($request->isPost){
//            var_dump($request->post());exit;
//            exit('111');
            $user=new User();
            //给user绑定场景
            $user->setScenario('reg');

            //绑定数据
            $user->load($request->post());
            //后台验证
            if($user->validate()){

                $user->auth_key=\Yii::$app->security->generateRandomString();
                $user->password_hash=\Yii::$app->security->generatePasswordHash($user->password);
                if($user->save()){
                    //跳转到登录页面
                    $result=[
                        'status'=>1,
                        'msg'=>'注册成功',
                        'data'=>"",
                    ];

                    return Json::encode($result);
                }
            }else{
                $result=[
                    'status'=>0,
                    'msg'=>'注册失败',
                    'data'=>$user->errors,

                ];
                return Json::encode($result);


            }
//            echo '<pre>';
//            var_dump($user);
//            //绑定数据
//            $user->load($request->post());
//
//            var_dump($user);exit;
//            $user->username=$request->post('username');
//            $user->password_hash=\Yii::$app->security->generatePasswordHash($request->post());
//            $user->email=$request->post('email');
//            $user->save();
        }



        return $this->render('reg');
    }
    public function actionSendSms($mobile){
        //1 生成验证码
        $code=rand(100000,999999);
        //2把验证码发送给mobile
        $config = [
            'access_key' => 'LTAIvBGGuaCruRlI',
            'access_secret' => 'sBUsvjn5mupeU3uK0Ctlu6dnkgutVQ',
            'sign_name' => '熊二',
        ];

//        $aliSms = new Mrgoon\AliSms\AliSms();
        $aliSms = new AliSms();
        $response = $aliSms->sendSms($mobile, 'SMS_128890053',['code'=>$code], $config);
//        var_dump($response);exit;
        if($response->Message=="OK"){
            //3 把code保存到Session中 把手机号等键值 验证码当值
            $session=\Yii::$app->session;


            //拿到session
            $session->set("tel_".$mobile,$code);

            return $code;

        }else{
            var_dump($response->Message);
        }



        //text


//        $session->set();


    }

    public function actionLogin(){
        $request=\Yii::$app->request;
        if($request->isPost){
           //创建对象
            $model=new User();
            $model->scenario='login';
            //绑定数据
            $model->load($request->post());
            //后台验证
            if($model->validate()) {
//                  1 先找到用户
                $user = User::findOne(['username' => $model->username]);
//                 var_dump($user);exit;
                //判断用户是否存在
                if ($user && \Yii::$app->security->validatePassword($model->password, $user->password_hash)) {
                    //登录
                    \Yii::$app->user->login($user, $model->rememberMe ? 3600 * 24 * 7 : 0);
                    return $this->redirect(['index']);

                } else {
                    echo '密码错误';exit;
                }

            }
            var_dump($model->errors);exit;
        }
        return $this->render('login');
    }
    public function actionLogout()
    {
        \Yii::$app->user->logout();

        return $this->redirect(['user/login']);
    }

}
