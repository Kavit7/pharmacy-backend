<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "medicine_uses".
 *
 * @property int $id
 * @property string $uuid
 * @property int|null $medicine_id
 * @property int|null $use_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property Medicines $medicine
 * @property User $updatedBy
 * @property Uses $use
 */
class MedicineUses extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medicine_uses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['medicine_id', 'use_id', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['uuid'], 'required'],
            [['medicine_id', 'use_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['uuid'], 'string', 'max' => 100],
            [['uuid'], 'unique'],
            [['medicine_id', 'use_id'], 'unique', 'targetAttribute' => ['medicine_id', 'use_id']],
            [['medicine_id'], 'exist', 'skipOnError' => true, 'targetClass' => Medicines::class, 'targetAttribute' => ['medicine_id' => 'id']],
            [['use_id'], 'exist', 'skipOnError' => true, 'targetClass' => Uses::class, 'targetAttribute' => ['use_id' => 'id']],
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
            'use_id' => Yii::t('app', 'Use ID'),
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
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * Gets query for [[Use]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUse()
    {
        return $this->hasOne(Uses::class, ['id' => 'use_id']);
    }

}
