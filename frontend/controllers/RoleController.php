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

    // 🔥 THEN parent behaviors
    return array_merge(
        $behaviors,
        parent::behaviors()
    );
}

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



}