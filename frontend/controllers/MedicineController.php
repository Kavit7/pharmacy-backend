<?php
namespace frontend\controllers;
use common\models\Manufacturers;
use common\models\MedicineBrands;
use common\models\MedicineCategories;
use common\models\Medicines;
use common\models\DosageForms;
use common\models\User;
use yii\filters\Cors;
use Yii;
use yii\rest\Controller;
use Ramsey\Uuid\Uuid;
use common\components\JwtHelper;
class MedicineController extends Controller{
    
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


public function actionSyncLookup()
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $currentUserId = $this->getCurrentUserId();
    if (!$currentUserId) {
        return [
            'status' => false,
            'message' => 'Unauthorized. No authenticated user found.',
        ];
    }

    $data = Yii::$app->request->bodyParams;
    $result = [];

    // 🔥 map tables
    $tables = [
        'categories' => [MedicineCategories::class, 'category_name'],
        'manufacturers' => [Manufacturers::class, 'manufacturer_name'],
        'dosage_forms' => [DosageForms::class, 'form_name'],
        'brands' => [MedicineBrands::class, 'brand_name'],
    ];

    foreach ($tables as $key => [$modelClass, $column]) {
        $map = [];

        if (!isset($data[$key])) {
            continue;
        }

        foreach ($data[$key] as $value) {
            $name = strtolower(trim($value));
            if (!$name) {
                continue;
            }

            // 🔥 check if exists
            $existing = $modelClass::find()
                ->where(["LOWER($column)" => $name])
                ->one();

            if (!$existing) {
                $new = new $modelClass();
                $new->$column = $name;
                if (empty($new->uuid)) {
                    $new->uuid = Uuid::uuid4()->toString();
                }
                $new->created_by = $currentUserId;
                $new->updated_by = $currentUserId;

                if (!$new->save()) {
                    return [
                        'status' => false,
                        'message' => 'Save failed',
                        'model' => $modelClass,
                        'data' => $new->attributes,
                        'errors' => $new->errors,
                    ];
                }

                $map[$name] = $new->id;
            } else {
                $map[$name] = $existing->id;
            }
        }

        $result[$key] = $map;
    }

    Yii::warning('Decoded user ID--: ' . $currentUserId, 'jwt');
    return [
        'status' => true,
        'data' => $result,
        'identity' => $currentUserId,
    ];
}

protected function getCurrentUserId()
{
    if (!Yii::$app->user->isGuest) {
        return Yii::$app->user->id;
    }

    $headers = Yii::$app->request->headers;
    $authHeader = $headers->get('Authorization') ?: $headers->get('authorization');
    if (!$authHeader && isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $authHeader = trim($_SERVER['HTTP_AUTHORIZATION']);
    }
    if (!$authHeader && isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
        $authHeader = trim($_SERVER['REDIRECT_HTTP_AUTHORIZATION']);
    }

    if (!$authHeader || !preg_match('/^Bearer\s+(\S+)$/i', trim($authHeader), $matches)) {
        Yii::warning('MedicineController auth fallback failed: missing or malformed Authorization header', 'jwt');
        return null;
    }

    $decoded = JwtHelper::validateToken($matches[1]);
    if (!$decoded || empty($decoded->data->id)) {
        Yii::warning('MedicineController auth fallback failed: invalid token or missing id', 'jwt');
        return null;
    }

    $user = User::findIdentity($decoded->data->id);
    if (!$user) {
        Yii::warning('MedicineController auth fallback failed: user not found for id ' . $decoded->data->id, 'jwt');
        return null;
    }

    Yii::$app->user->login($user, 0);
    return $user->id;
}

public function actionSaveMedicine()
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $currentUserId = $this->getCurrentUserId();
    if (!$currentUserId) {
        return [
            'status' => false,
            'message' => 'Unauthorized. No authenticated user found.',
        ];
    }

    $data = Yii::$app->request->bodyParams;
    $savedIds = [];

    foreach ($data as $row) {
        // check if exist
        $exists = Medicines::find()
            ->where([
                'generic_name' => $row['generic_name'],
                'strength' => $row['strength'],
                'manufacturer_id' => $row['manufacturer_id'],
            ])
            ->exists();

        if ($exists) {
            continue;
        }

        $new = new Medicines();
        if (empty($new->uuid)) {
            $new->uuid = Uuid::uuid4()->toString();
        }

       $new->generic_name = $row['generic_name'] ?? null;
       $new->strength = $row['strength'] ?? null;
       $new->description = $row['description'] ?? null;
       $new->manufacturer_id = $row['manufacturer_id'] ?? null;
       $new->dosage_form_id = $row['dosage_form_id'] ?? null;
       $new->branch_id = $row['branch_id'] ?? null; // pia fix hapa
       $new->category_id = $row['category_id'] ?? null;
       $new->created_by = $currentUserId;
       $new->updated_by = $currentUserId;

        if (!$new->save()) {
            return [
                'status' => false,
                'message' => 'Save failed',
                'errors' => $new->errors,
            ];
        }

        $savedIds[] = $new->id;
    }

    return [
        'status' => true,
        'savedIds' => $savedIds,
    ];
}

}