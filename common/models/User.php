<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $uuid
 * @property string $fname
 * @property string|null $mname
 * @property string $lname
 * @property string|null $phone
 * @property string|null $email
 * @property int $role_id
 * @property string|null $national_id
 * @property int|null $pharmacy_id
 * @property int|null $status_id
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string|null $password_reset_expires_at
 * @property string|null $last_password_change_at
 * @property int|null $failed_login_attempts
 * @property string|null $last_failed_login_at
 * @property string|null $account_locked_until
 * @property string|null $deleted_at
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property ActivityLog[] $activityLogs
 * @property ActivityLog[] $activityLogs0
 * @property Alert[] $alerts
 * @property Alert[] $alerts0
 * @property Alert[] $alerts1
 * @property BlacklistedEntity[] $blacklistedEntities
 * @property CommissionConfig[] $commissionConfigs
 * @property CommissionConfig[] $commissionConfigs0
 * @property User $createdBy
 * @property DosageForm[] $dosageForms
 * @property DosageForm[] $dosageForms0
 * @property FraudLog[] $fraudLogs
 * @property FraudLog[] $fraudLogs0
 * @property FraudRule[] $fraudRules
 * @property FraudRule[] $fraudRules0
 * @property FraudType[] $fraudTypes
 * @property FraudType[] $fraudTypes0
 * @property Manufacturer[] $manufacturers
 * @property Manufacturer[] $manufacturers0
 * @property MedicineBrand[] $medicineBrands
 * @property MedicineBrand[] $medicineBrands0
 * @property MedicineCategory[] $medicineCategories
 * @property MedicineCategory[] $medicineCategories0
 * @property MedicineSideEffect[] $medicineSideEffects
 * @property MedicineSideEffect[] $medicineSideEffects0
 * @property MedicineUse[] $medicineUses
 * @property MedicineUse[] $medicineUses0
 * @property Medicine[] $medicines
 * @property Medicine[] $medicines0
 * @property OrderItem[] $orderItems
 * @property OrderItem[] $orderItems0
 * @property Order[] $orders
 * @property Order[] $orders0
 * @property Order[] $orders1
 * @property PaymentLog[] $paymentLogs
 * @property PaymentMethod[] $paymentMethods
 * @property PaymentMethod[] $paymentMethods0
 * @property PaymentTransaction[] $paymentTransactions
 * @property PaymentTransaction[] $paymentTransactions0
 * @property PaymentTransaction[] $paymentTransactions1
 * @property PayoutRequest[] $payoutRequests
 * @property PayoutRequest[] $payoutRequests0
 * @property PayoutRequest[] $payoutRequests1
 * @property PayoutTransaction[] $payoutTransactions
 * @property Pharmacy[] $pharmacies
 * @property Pharmacy[] $pharmacies0
 * @property Pharmacy $pharmacy
 * @property PharmacyMedicine[] $pharmacyMedicines
 * @property PharmacyMedicine[] $pharmacyMedicines0
 * @property PharmacyWallet[] $pharmacyWallets
 * @property PharmacyWallet[] $pharmacyWallets0
 * @property PlatformEarning[] $platformEarnings
 * @property Refund[] $refunds
 * @property Refund[] $refunds0
 * @property Refund[] $refunds1
 * @property RiskLevel[] $riskLevels
 * @property RiskLevel[] $riskLevels0
 * @property Role $role
 * @property Role[] $roles
 * @property Role[] $roles0
 * @property SideEffect[] $sideEffects
 * @property SideEffect[] $sideEffects0
 * @property Status $status
 * @property Status[] $statuses
 * @property Status[] $statuses0
 * @property User $updatedBy
 * @property UserAddress[] $userAddresses
 * @property UserAddress[] $userAddresses0
 * @property UserAddress[] $userAddresses1
 * @property User[] $users
 * @property User[] $users0
 * @property Use[] $uses
 * @property Use[] $uses0
 * @property WalletTransactionType[] $walletTransactionTypes
 * @property WalletTransactionType[] $walletTransactionTypes0
 * @property WalletTransaction[] $walletTransactions
 * @property Ward[] $wards
 * @property Ward[] $wards0
 * @property WorkflowAction[] $workflowActions
 * @property WorkflowAction[] $workflowActions0
 * @property Workflow[] $workflows
 * @property Workflow[] $workflows0
 * @property Workflow[] $workflows1
 * @property Workflow[] $workflows2
 */
class User extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mname', 'phone', 'email', 'national_id', 'pharmacy_id', 'status_id', 'password_reset_token', 'password_reset_expires_at', 'last_password_change_at', 'last_failed_login_at', 'account_locked_until', 'deleted_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['failed_login_attempts'], 'default', 'value' => 0],
            [['uuid', 'fname', 'lname', 'role_id', 'password_hash'], 'required'],
            [['role_id', 'pharmacy_id', 'status_id', 'failed_login_attempts', 'created_by', 'updated_by'], 'integer'],
            [['password_reset_expires_at', 'last_password_change_at', 'last_failed_login_at', 'account_locked_until', 'deleted_at', 'created_at', 'updated_at'], 'safe'],
            [['uuid', 'fname', 'mname', 'lname'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 150],
            [['national_id'], 'string', 'max' => 50],
            [['password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['uuid'], 'unique'],
            [['phone'], 'unique'],
            [['email'], 'unique'],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['role_id' => 'id']],
            [['pharmacy_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pharmacy::class, 'targetAttribute' => ['pharmacy_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
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
            'fname' => Yii::t('app', 'Fname'),
            'mname' => Yii::t('app', 'Mname'),
            'lname' => Yii::t('app', 'Lname'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'),
            'role_id' => Yii::t('app', 'Role ID'),
            'national_id' => Yii::t('app', 'National ID'),
            'pharmacy_id' => Yii::t('app', 'Pharmacy ID'),
            'status_id' => Yii::t('app', 'Status ID'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'password_reset_expires_at' => Yii::t('app', 'Password Reset Expires At'),
            'last_password_change_at' => Yii::t('app', 'Last Password Change At'),
            'failed_login_attempts' => Yii::t('app', 'Failed Login Attempts'),
            'last_failed_login_at' => Yii::t('app', 'Last Failed Login At'),
            'account_locked_until' => Yii::t('app', 'Account Locked Until'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * Gets query for [[ActivityLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActivityLogs()
    {
        return $this->hasMany(ActivityLog::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[ActivityLogs0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActivityLogs0()
    {
        return $this->hasMany(ActivityLog::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Alerts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlerts()
    {
        return $this->hasMany(Alert::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Alerts0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlerts0()
    {
        return $this->hasMany(Alert::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Alerts1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlerts1()
    {
        return $this->hasMany(Alert::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[BlacklistedEntities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlacklistedEntities()
    {
        return $this->hasMany(BlacklistedEntity::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[CommissionConfigs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCommissionConfigs()
    {
        return $this->hasMany(CommissionConfig::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[CommissionConfigs0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCommissionConfigs0()
    {
        return $this->hasMany(CommissionConfig::class, ['updated_by' => 'id']);
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
     * Gets query for [[DosageForms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDosageForms()
    {
        return $this->hasMany(DosageForm::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[DosageForms0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDosageForms0()
    {
        return $this->hasMany(DosageForm::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[FraudLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFraudLogs()
    {
        return $this->hasMany(FraudLog::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[FraudLogs0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFraudLogs0()
    {
        return $this->hasMany(FraudLog::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[FraudRules]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFraudRules()
    {
        return $this->hasMany(FraudRule::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[FraudRules0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFraudRules0()
    {
        return $this->hasMany(FraudRule::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[FraudTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFraudTypes()
    {
        return $this->hasMany(FraudType::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[FraudTypes0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFraudTypes0()
    {
        return $this->hasMany(FraudType::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Manufacturers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getManufacturers()
    {
        return $this->hasMany(Manufacturer::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Manufacturers0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getManufacturers0()
    {
        return $this->hasMany(Manufacturer::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[MedicineBrands]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedicineBrands()
    {
        return $this->hasMany(MedicineBrand::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[MedicineBrands0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedicineBrands0()
    {
        return $this->hasMany(MedicineBrand::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[MedicineCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedicineCategories()
    {
        return $this->hasMany(MedicineCategory::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[MedicineCategories0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedicineCategories0()
    {
        return $this->hasMany(MedicineCategory::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[MedicineSideEffects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedicineSideEffects()
    {
        return $this->hasMany(MedicineSideEffect::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[MedicineSideEffects0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedicineSideEffects0()
    {
        return $this->hasMany(MedicineSideEffect::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[MedicineUses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedicineUses()
    {
        return $this->hasMany(MedicineUse::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[MedicineUses0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedicineUses0()
    {
        return $this->hasMany(MedicineUse::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Medicines]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedicines()
    {
        return $this->hasMany(Medicine::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Medicines0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedicines0()
    {
        return $this->hasMany(Medicine::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[OrderItems0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems0()
    {
        return $this->hasMany(OrderItem::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['patient_id' => 'id']);
    }

    /**
     * Gets query for [[Orders0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders0()
    {
        return $this->hasMany(Order::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Orders1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders1()
    {
        return $this->hasMany(Order::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[PaymentLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentLogs()
    {
        return $this->hasMany(PaymentLog::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[PaymentMethods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentMethods()
    {
        return $this->hasMany(PaymentMethod::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[PaymentMethods0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentMethods0()
    {
        return $this->hasMany(PaymentMethod::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[PaymentTransactions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentTransactions()
    {
        return $this->hasMany(PaymentTransaction::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[PaymentTransactions0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentTransactions0()
    {
        return $this->hasMany(PaymentTransaction::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[PaymentTransactions1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentTransactions1()
    {
        return $this->hasMany(PaymentTransaction::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[PayoutRequests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayoutRequests()
    {
        return $this->hasMany(PayoutRequest::class, ['approved_by' => 'id']);
    }

    /**
     * Gets query for [[PayoutRequests0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayoutRequests0()
    {
        return $this->hasMany(PayoutRequest::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[PayoutRequests1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayoutRequests1()
    {
        return $this->hasMany(PayoutRequest::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[PayoutTransactions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayoutTransactions()
    {
        return $this->hasMany(PayoutTransaction::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Pharmacies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPharmacies()
    {
        return $this->hasMany(Pharmacy::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Pharmacies0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPharmacies0()
    {
        return $this->hasMany(Pharmacy::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Pharmacy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPharmacy()
    {
        return $this->hasOne(Pharmacy::class, ['id' => 'pharmacy_id']);
    }

    /**
     * Gets query for [[PharmacyMedicines]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPharmacyMedicines()
    {
        return $this->hasMany(PharmacyMedicine::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[PharmacyMedicines0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPharmacyMedicines0()
    {
        return $this->hasMany(PharmacyMedicine::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[PharmacyWallets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPharmacyWallets()
    {
        return $this->hasMany(PharmacyWallet::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[PharmacyWallets0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPharmacyWallets0()
    {
        return $this->hasMany(PharmacyWallet::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[PlatformEarnings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlatformEarnings()
    {
        return $this->hasMany(PlatformEarning::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Refunds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRefunds()
    {
        return $this->hasMany(Refund::class, ['approved_by' => 'id']);
    }

    /**
     * Gets query for [[Refunds0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRefunds0()
    {
        return $this->hasMany(Refund::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Refunds1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRefunds1()
    {
        return $this->hasMany(Refund::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[RiskLevels]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRiskLevels()
    {
        return $this->hasMany(RiskLevel::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[RiskLevels0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRiskLevels0()
    {
        return $this->hasMany(RiskLevel::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
    }

    /**
     * Gets query for [[Roles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        return $this->hasMany(Role::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Roles0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoles0()
    {
        return $this->hasMany(Role::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[SideEffects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSideEffects()
    {
        return $this->hasMany(SideEffect::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[SideEffects0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSideEffects0()
    {
        return $this->hasMany(SideEffect::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    /**
     * Gets query for [[Statuses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatuses()
    {
        return $this->hasMany(Status::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Statuses0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatuses0()
    {
        return $this->hasMany(Status::class, ['updated_by' => 'id']);
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
     * Gets query for [[UserAddresses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserAddresses()
    {
        return $this->hasMany(UserAddress::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserAddresses0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserAddresses0()
    {
        return $this->hasMany(UserAddress::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[UserAddresses1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserAddresses1()
    {
        return $this->hasMany(UserAddress::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Users0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers0()
    {
        return $this->hasMany(User::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Uses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUses()
    {
        return $this->hasMany(Uses::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Uses0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUses0()
    {
        return $this->hasMany(Uses::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[WalletTransactionTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWalletTransactionTypes()
    {
        return $this->hasMany(WalletTransactionType::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[WalletTransactionTypes0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWalletTransactionTypes0()
    {
        return $this->hasMany(WalletTransactionType::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[WalletTransactions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWalletTransactions()
    {
        return $this->hasMany(WalletTransaction::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Wards]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWards()
    {
        return $this->hasMany(Ward::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Wards0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWards0()
    {
        return $this->hasMany(Ward::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[WorkflowActions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorkflowActions()
    {
        return $this->hasMany(WorkflowAction::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[WorkflowActions0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorkflowActions0()
    {
        return $this->hasMany(WorkflowAction::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Workflows]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorkflows()
    {
        return $this->hasMany(Workflow::class, ['requested_by' => 'id']);
    }

    /**
     * Gets query for [[Workflows0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorkflows0()
    {
        return $this->hasMany(Workflow::class, ['reviewed_by' => 'id']);
    }

    /**
     * Gets query for [[Workflows1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorkflows1()
    {
        return $this->hasMany(Workflow::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Workflows2]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorkflows2()
    {
        return $this->hasMany(Workflow::class, ['updated_by' => 'id']);
    }

}