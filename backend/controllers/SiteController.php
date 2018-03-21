<?php
namespace backend\controllers;

use backend\models\Admin;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','captcha'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
//        if (!Yii::$app->user->isGuest) {
//            return $this->goHome();
//        }

//        $model = new LoginForm();
//        if ($model->load(Yii::$app->request->post()) && $model->login()) {
//            return $this->goBack();
//        } else {
//            $model->password = '';
//
//            return $this->render('login', [
//                'model' => $model,
//            ]);
//        }
        $model = new LoginForm();
//        var_dump($model);exit;
        $request=Yii::$app->request;
        if($request->isPost){
            //绑定数据
            $model->load($request->post());
//            var_dump($model->password);exit;
            //验证用户名
            $admin=Admin::find()->where(['username'=>$model->username])->one();
            if($admin){
                $pwd=Admin::find()->where(['password'=>$model->password])->one();

                $admin->last_login_ip=$_SERVER['REMOTE_ADDR'];
                $admin->last_login_time=time();
//                var_dump($admin->last_login_ip);exit;
              $admin->save();
                if($pwd){
                    Yii::$app->session->setFlash('success','登录成功');
                    return $this->redirect(['/admin/index']);
                }else{

                    return $this->redirect(['site/login']);
                }
            }else{

                return $this->redirect(['site/login']);
            }
        }
        return $this->render('login',compact('model'));
    }


    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
