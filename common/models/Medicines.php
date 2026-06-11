<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "medicines".
 *
 * @property int $id
 * @property string $uuid
 * @property string $generic_name
 * @property string|null $description
 * @property int|null $category_id
 * @property int|null $branch_id
 * @property int|null $dosage_form_id
 * @property string|null $strength
 * @property int|null $manufacturer_id
 * @property string|null $deleted_at
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property MedicineCategories $category
 * @property User $createdBy
 * @property DosageForms $dosageForm
 * @property Manufacturers $manufacturer
 * @property MedicineSideEffects[] $medicineSideEffects
 * @property MedicineUses[] $medicineUses
 * @property OrderItems[] $orderItems
 * @property PharmacyMedicines[] $pharmacyMedicines
 * @property SideEffects[] $sideEffects
 * @property User $updatedBy
 * @property Uses[] $uses
 */
class Medicines extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medicines';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'category_id', 'branch_id', 'dosage_form_id', 'strength', 'manufacturer_id', 'deleted_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['uuid', 'generic_name'], 'required'],
            [['description'], 'string'],
            [['category_id', 'branch_id', 'dosage_form_id', 'manufacturer_id', 'created_by', 'updated_by'], 'integer'],
            [['deleted_at', 'created_at', 'updated_at'], 'safe'],
            [['uuid', 'strength'], 'string', 'max' => 100],
            [['generic_name'], 'string', 'max' => 255],
            [['uuid'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => MedicineCategories::class, 'targetAttribute' => ['category_id' => 'id']],
            [['dosage_form_id'], 'exist', 'skipOnError' => true, 'targetClass' => DosageForms::class, 'targetAttribute' => ['dosage_form_id' => 'id']],
            [['manufacturer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Manufacturers::class, 'targetAttribute' => ['manufacturer_id' => 'id']],
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
            'generic_name' => Yii::t('app', 'Generic Name'),
            'description' => Yii::t('app', 'Description'),
            'category_id' => Yii::t('app', 'Category ID'),
            'branch_id' => Yii::t('app', 'Branch ID'),
            'dosage_form_id' => Yii::t('app', 'Dosage Form ID'),
            'strength' => Yii::t('app', 'Strength'),
            'manufacturer_id' => Yii::t('app', 'Manufacturer ID'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(MedicineCategories::class, ['id' => 'category_id']);
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
     * Gets query for [[DosageForm]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDosageForm()
    {
        return $this->hasOne(DosageForms::class, ['id' => 'dosage_form_id']);
    }

    /**
     * Gets query for [[Manufacturer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getManufacturer()
    {
        return $this->hasOne(Manufacturers::class, ['id' => 'manufacturer_id']);
    }

    /**
     * Gets query for [[MedicineSideEffects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedicineSideEffects()
    {
        return $this->hasMany(MedicineSideEffects::class, ['medicine_id' => 'id']);
    }

    /**
     * Gets query for [[MedicineUses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedicineUses()
    {
        return $this->hasMany(MedicineUses::class, ['medicine_id' => 'id']);
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItems::class, ['medicine_id' => 'id']);
    }

    /**
     * Gets query for [[PharmacyMedicines]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPharmacyMedicines()
    {
        return $this->hasMany(PharmacyMedicines::class, ['medicine_id' => 'id']);
    }

    /**
     * Gets query for [[SideEffects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSideEffects()
    {
        return $this->hasMany(SideEffects::class, ['id' => 'side_effect_id'])->viaTable('medicine_side_effects', ['medicine_id' => 'id']);
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
     * Gets query for [[Uses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUses()
    {
        return $this->hasMany(Uses::class, ['id' => 'use_id'])->viaTable('medicine_uses', ['medicine_id' => 'id']);
    }

}
