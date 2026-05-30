<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "status".
 *
 * @property int $id
 * @property string $status_name
 * @property string $status_type
 * @property string|null $color_code
 * @property int|null $display_order
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property OrderItem[] $orderItems
 * @property Order[] $orders
 * @property PaymentLog[] $paymentLogs
 * @property PaymentTransaction[] $paymentTransactions
 * @property PayoutRequest[] $payoutRequests
 * @property PayoutTransaction[] $payoutTransactions
 * @property Pharmacy[] $pharmacies
 * @property PharmacyMedicine[] $pharmacyMedicines
 * @property Refund[] $refunds
 * @property User $updatedBy
 * @property User[] $users
 * @property Workflow[] $workflows
 */
class Status extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color_code', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['display_order'], 'default', 'value' => 0],
            [['status_name', 'status_type'], 'required'],
            [['display_order', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['status_name', 'status_type'], 'string', 'max' => 50],
            [['color_code'], 'string', 'max' => 7],
            [['status_name'], 'unique'],
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
            'status_name' => Yii::t('app', 'Status Name'),
            'status_type' => Yii::t('app', 'Status Type'),
            'color_code' => Yii::t('app', 'Color Code'),
            'display_order' => Yii::t('app', 'Display Order'),
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
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['status_id' => 'id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['status_id' => 'id']);
    }

    /**
     * Gets query for [[PaymentLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentLogs()
    {
        return $this->hasMany(PaymentLog::class, ['status_id' => 'id']);
    }

    /**
     * Gets query for [[PaymentTransactions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentTransactions()
    {
        return $this->hasMany(PaymentTransaction::class, ['status_id' => 'id']);
    }

    /**
     * Gets query for [[PayoutRequests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayoutRequests()
    {
        return $this->hasMany(PayoutRequest::class, ['status_id' => 'id']);
    }

    /**
     * Gets query for [[PayoutTransactions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayoutTransactions()
    {
        return $this->hasMany(PayoutTransaction::class, ['status_id' => 'id']);
    }

    /**
     * Gets query for [[Pharmacies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPharmacies()
    {
        return $this->hasMany(Pharmacy::class, ['status_id' => 'id']);
    }

    /**
     * Gets query for [[PharmacyMedicines]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPharmacyMedicines()
    {
        return $this->hasMany(PharmacyMedicine::class, ['status_id' => 'id']);
    }

    /**
     * Gets query for [[Refunds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRefunds()
    {
        return $this->hasMany(Refund::class, ['status_id' => 'id']);
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
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['status_id' => 'id']);
    }

    /**
     * Gets query for [[Workflows]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorkflows()
    {
        return $this->hasMany(Workflow::class, ['status_id' => 'id']);
    }

}
