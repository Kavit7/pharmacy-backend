<?php
namespace common\components;


use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class JwtHelper {
    
private static $key="SECRET_PHARMACY_0024";

public static function generateToken($user){
    $payload=[
        "iat"=>time(),
        "exp"=>time()+3600,
        "data"=>[
            "id"=>$user->id,
            "role"=>$user->role->role_name,
            "email" => $user->email,
        ]
    ];
    return JWT::encode($payload,self::$key,'HS256');
}


public static function validateToken($token){
  try{
    JWT::decode($token,new Key(self::$key,'HS256'));
    
  }
  catch(\Exception $e){
    return null;
  }


}


}