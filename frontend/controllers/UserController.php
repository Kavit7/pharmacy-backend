<?php

namespace frontend\controllers;

use yii\filters\Cors;
use yii\rest\ActiveController;
use common\models\User;
use Yii;
use Ramsey\Uuid\Uuid;
use common\models\Role;

class UserController extends ActiveController
{
    public $modelClass = User::class;

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


 public function actions(){

       $actions= parent::actions();
       
       unset($actions['create']);


       return $actions;
 
 }

  public function actionCreate(){
      
      $model= new User();
      

      if ($model->load(Yii::$app->request->bodyParams,'')){

         if (empty($model->uuid)){
            $model->uuid=Uuid::uuid4()->toString();
         }
         $model->fname=strtolower($model->fname);
         $model->lname=strtolower($model->lname);
         $model->mname=strtolower($model->mname);
        if (empty($model->role_id)) {
           $role = Role::find()
            ->select('id')
             ->where(['role_name' => 'patient'])
             ->one();
             if ($role) {
             $model->role_id = $role->id;
                 } else {
             throw new \Exception("Patient role not found");
            }
}
          

         
         $model->password_hash= Yii::$app->security->generatePasswordHash($model->password_hash);
         $model->created_by= Yii::$app->user->id ?? null;
         $model->updated_by= Yii::$app->user->id ?? null;
          

         if ($model->save()){

          return [
        'success' => true,
        'message' => 'User Created Successfully',
        'data' => $model
            ];
            
         } 
         else {
             return [
                'success'=>false,
                'errors'=>$model->errors,
                'message' => 'Failed to create user',
             ];
         
         }               
      }




  
  }
}