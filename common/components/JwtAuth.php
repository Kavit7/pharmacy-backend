<?php
namespace common\components;  // 🔥 common, si commmon

use yii\filters\auth\AuthMethod;
use Yii;
use common\components\JwtHelper;
use common\models\User;

class JwtAuth extends AuthMethod
{
    public function authenticate($user, $request, $response)
    {
        $authHeader = $request->headers->get('Authorization');
        if (!$authHeader && isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $authHeader = trim($_SERVER['HTTP_AUTHORIZATION']);
        }
        if (!$authHeader && function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
            if (!empty($headers['Authorization'])) {
                $authHeader = trim($headers['Authorization']);
            }
        }

        if (!$authHeader) {
            Yii::warning('JWT auth failed: missing Authorization header', 'jwt');
            return null;
        }

        if (!preg_match('/^Bearer\s+(\S+)$/i', trim($authHeader), $matches)) {
            Yii::warning('JWT auth failed: malformed Authorization header', 'jwt');
            return null;
        }

        $token = $matches[1];
        if (empty($token)) {
            Yii::warning('JWT auth failed: empty bearer token', 'jwt');
            return null;
        }

        $decoded = JwtHelper::validateToken($token);
        if (!$decoded) {
            Yii::warning('JWT auth failed: invalid or expired token', 'jwt');
            return null;
        }

        if (!isset($decoded->data->id)) {
            Yii::warning('JWT auth failed: token missing user id', 'jwt');
            return null;
        }

        $userId = $decoded->data->id;
        $userModel = User::findIdentity($userId);
        if (!$userModel) {
            Yii::warning("JWT auth failed: no user found for id {$userId}", 'jwt');
            return null;
        }

        // ensure the user component has the authenticated identity
        $user->setIdentity($userModel);
        Yii::info("JWT auth succeeded for user id {$userId}", 'jwt');

        return $userModel;
    }
}