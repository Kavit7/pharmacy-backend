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
  $behaviors = parent::behaviors(); // 🔥 muhimu sana

    // 🔥 toa authenticator kwanza
    if (isset($behaviors['authenticator'])) {
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);
    } else {
        $auth = [
            'class' => \common\components\JwtAuth::class,
        ];
    }

    // 🔥 weka CORS
    $behaviors['corsFilter'] = [
        'class' => \yii\filters\Cors::class,
        'cors' => [
            'Origin' => ['http://localhost:5173'],
            'Access-Control-Request-Method' => ['GET','POST','PUT','DELETE','OPTIONS'],
            'Access-Control-Request-Headers' => [
                'Authorization',
                'Content-Type',
                'X-Requested-With',
                'Accept',
                'Origin'
            ],
            // 'Access-Control-Allow-Credentials' => true,
        ],
    ];

    // 🔥 rudisha JWT (middleware yako)
    $auth['except'] = ['options']; // muhimu
    $behaviors['authenticator'] = $auth;

    return $behaviors;
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