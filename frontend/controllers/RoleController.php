<?php
namespace frontend\controllers;
use yii\rest\ActiveController;
use Yii;
use yii\filters\Cors;
use common\models\Role;



class RoleController extends ActiveController{

public $modelClass= Role::class;

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
            'Access-Control-Allow-Credentials' => true,
        ],
    ];

    // 🔥 rudisha JWT (middleware yako)
    $auth['except'] = ['options']; // muhimu
    $behaviors['authenticator'] = $auth;

    return $behaviors;
}




}