<?php
namespace commmon\components;
use yii\filter\auth\AuthMethod;
use Yii;
use common\components\JwtHelper;
use common\models\User;


class JwtAuth extends AuthMethod{

private static $key="SECRET_PHARMACY_0024";
   public function authenticate($user,$request,$response){
     $authHeader=$request->headers->get('Authorization');
 if ($authHeader && preg_match('/Bearer\s(\S+)',$authHeader,$matches)){
    $token =$matches[1];
       $decoded= JwtHelper::validateToken($token);
       return User::findOne($decoded->data->id);
 }

     
   }
    
} 