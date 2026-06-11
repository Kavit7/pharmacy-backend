<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "medicine_side_effects".
 *
 * @property int $id
 * @property string $uuid
 * @property int|null $medicine_id
 * @property int|null $side_effect_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property Medicines $medicine
 * @property SideEffects $sideEffect
 * @property User $updatedBy
 */
class MedicineSideEffects extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medicine_side_effects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['medicine_id', 'side_effect_id', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['uuid'], 'required'],
            [['medicine_id', 'side_effect_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['uuid'], 'string', 'max' => 100],
            [['uuid'], 'unique'],
            [['medicine_id', 'side_effect_id'], 'unique', 'targetAttribute' => ['medicine_id', 'side_effect_id']],
            [['medicine_id'], 'exist', 'skipOnError' => true, 'targetClass' => Medicines::class, 'targetAttribute' => ['medicine_id' => 'id']],
            [['side_effect_id'], 'exist', 'skipOnError' => true, 'targetClass' => SideEffects::class, 'targetAttribute' => ['side_effect_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'uuid' => Yii::t('app', 'Uuid'),
            'medicine_id' => Yii::t('app', 'Medicine ID'),
            'side_effect_id' => Yii::t('app', 'Side Effect ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[Medicine]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedicine()
    {
        return $this->hasOne(Medicines::class, ['id' => 'medicine_id']);
    }

    /**
     * Gets query for [[SideEffect]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSideEffect()
    {
        return $this->hasOne(SideEffects::class, ['id' => 'side_effect_id']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

}
