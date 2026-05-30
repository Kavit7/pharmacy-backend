<?php
namespace frontend\controllers;
use yii\filters\Cors;
use yii\rest\Controller;
use common\models\User;
use Yii;
use common\components\JwtHelper;

class AuthController extends Controller{

public function behaviors()
{
    $behaviors = [];

    // 🔥 FIRST: CORS
    $behaviors['corsFilter'] = [
        'class' => \yii\filters\Cors::class,
        'cors' => [
            'Origin' => ['*'],
            'Access-Control-Request-Method' => ['GET','POST','PUT','DELETE','OPTIONS'],
            'Access-Control-Allow-Headers' => ['*'],
        ],
    ];
       $behaviors['authenticator'] = [
        'class' => \common\components\JwtAuth::class,
        'except' => ['login', 'signup', 'options'], // public routes
    ];

    // 🔥 THEN parent behaviors
    return array_merge(
        $behaviors,
        parent::behaviors()
    );
}

    // 🔥 FIX OPTIONS 405
  public function beforeAction($action)
{
    if (Yii::$app->request->isOptions) {
        Yii::$app->response->statusCode = 200;
        Yii::$app->response->headers->set('Access-Control-Allow-Origin', '*');
        Yii::$app->response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        Yii::$app->response->headers->set('Access-Control-Allow-Headers', '*');
        return false;
    }

    return parent::beforeAction($action);
}

public function actionLogin(){
            
     $data = Yii::$app->request->post();
     
     $user = User::findOne(['email'=>$data['email']]);
     
     if ($user && Yii::$app->security->validatePassword($data['password'],$user->password_hash)){

       $token = JwtHelper::generateToken($user);


       return [
        'status'=>true,
        'token'=>$token,
        'message'=>'Logged in'
       ];
        
     }

     return [
        'status'=>false,
        'message'=>"Invalid  Password or Email",
     ];

}

}