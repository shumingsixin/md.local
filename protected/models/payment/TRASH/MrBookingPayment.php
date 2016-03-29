<?php

/**
 * This is the model class for table "mr_booking_payment".
 *
 * The followings are the available columns in table 'mr_booking_payment':
 * @property integer $id
 * @property string $uid
 * @property integer $booking_id
 * @property integer $user_id
 * @property integer $is_paid
 * @property integer $pay_method
 * @property integer $status
 * @property string $bill_amount
 * @property string $bill_currency
 * @property string $bill_date
 * @property string $paid_amount
 * @property string $paid_currency
 * @property string $paid_date
 * @property string $subject
 * @property string $description
 * @property string $request_url
 * @property string $date_request
 * @property string $return_data
 * @property string $notify_data
 * @property string $vendor_trade_no
 * @property string $vendor_trade_status
 * @property string $error_code
 * @property string $error_msg
 * @property string $date_return
 * @property string $date_notify
 * @property string $remark
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 *
 * The followings are the available model relations:
 * @property MedicalRecordBooking $booking
 * @property User $user
 */
class MrBookingPayment extends EActiveRecord {

    const PAY_METHOD_ALIPAY = 1;
    const PAY_METHOD_WEIXIN = 2;
    const PAY_METHOD_CREDITCARD = 3;
    const STATUS_PENDING = 1;
    const STATUS_PAID = 2;
    const STATUS_CANCELLED = 8;
    const STATUS_FAILED = 9;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'mr_booking_payment';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('uid, booking_id, user_id, pay_method, status, bill_amount, bill_currency, bill_date', 'required'),
            array('booking_id, user_id, is_paid, pay_method, status', 'numerical', 'integerOnly' => true),
            array('uid', 'length', 'is' => 32),
            array('bill_amount, paid_amount', 'length', 'max' => 13),
            array('bill_currency, paid_currency', 'length', 'is' => 3),
            array('subject, description, remark', 'length', 'max' => 100),
            array('request_url, return_data, notify_data, error_msg', 'length', 'max' => 1024),
            array('user_host_ip', 'length', 'max' => 15),
            array('vendor_trade_status, error_code', 'length', 'max' => 45),
            array('vendor_trade_no', 'length', 'max' => 64),
            array('paid_date, date_request, date_return, user_host_ip, date_notify, date_created, date_updated, date_deleted', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, uid, booking_id, user_id, is_paid, pay_method, status, bill_amount, bill_currency, bill_date, paid_amount, paid_currency, paid_date, subject, description, request_url, error_code, error_msg, remark, date_created, date_updated, date_deleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'mrbpBooking' => array(self::BELONGS_TO, 'MedicalRecordBooking', 'booking_id'),
            'mrbpUser' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'uid' => 'Uid',
            'booking_id' => 'Booking',
            'user_id' => 'User',
            'is_paid' => 'Is Paid',
            'pay_method' => 'Pay Method',
            'status' => 'Status',
            'bill_amount' => 'Bill Amount',
            'bill_currency' => 'Bill Currency',
            'bill_date' => 'Bill Date',
            'paid_amount' => 'Paid Amount',
            'paid_currency' => 'Paid Currency',
            'paid_date' => 'Paid Date',
            'subject' => 'Subject',
            'description' => 'Description',
            'request_url' => 'Request Url',
            'error_code' => 'Error Code',
            'error_msg' => 'Error Msg',
            'remark' => 'Remark',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
            'date_deleted' => 'Date Deleted',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('uid', $this->uid, true);
        $criteria->compare('booking_id', $this->booking_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('is_paid', $this->is_paid);
        $criteria->compare('pay_method', $this->pay_method);
        $criteria->compare('status', $this->status);
        $criteria->compare('bill_amount', $this->bill_amount, true);
        $criteria->compare('bill_currency', $this->bill_currency, true);
        $criteria->compare('bill_date', $this->bill_date, true);
        $criteria->compare('paid_amount', $this->paid_amount, true);
        $criteria->compare('paid_currency', $this->paid_currency, true);
        $criteria->compare('paid_date', $this->paid_date, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('request_url', $this->request_url, true);
        $criteria->compare('error_code', $this->error_code, true);
        $criteria->compare('error_msg', $this->error_msg, true);
        $criteria->compare('remark', $this->remark, true);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('date_updated', $this->date_updated, true);
        $criteria->compare('date_deleted', $this->date_deleted, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MrBookingPayment the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeValidate() {
        $this->_createUID();
        return parent::beforeValidate();
    }

    public function initModel($model) {
        if ($model instanceof MedicalRecordBooking) {
            $this->booking_id = $model->getId();
            $this->user_id = $model->getUserId();
            $this->bill_amount = $model->getTotalPrice();
            $this->bill_currency = $model->getCurrency();
            $this->subject = $model->getSubject();
            $this->description = $model->getSubject();
        }        
        $this->status = self::STATUS_PENDING;
        $this->is_paid = 0;
        $this->bill_date = new CDbExpression("NOW()");
        $this->_createUID();
    }

    public function getOptionsPayMethod() {
        return array(
            self::PAY_METHOD_ALIPAY => Yii::t('payment', '支付宝'),
            self::PAY_METHOD_WEIXIN => Yii::t('payment', '微信支付'),
            self::PAY_METHOD_CREDITCARD => Yii::t('payment', '信用卡')
        );
    }

    public function getOptionsStatus() {
        return array(
            self::STATUS_PENDING => Yii::t('payment', '等待付款'),
            self::STATUS_PAID => Yii::t('payment', '已付款'),
            self::STATUS_CANCELLED => Yii::t('payment', '已取消'),
            self::STATUS_FAILED => Yii::t('payment', '付款失败')
        );
    }

    private function _createUID() {
        if (is_null($this->uid)) {
            $this->uid = substr(str_shuffle(md5(rand())), 0, 32);
        }
    }

    /*     * ****** Query Methods ******* */

    public function getByUID($uid, $with = null) {
        return $this->getByAttributes(array('uid' => $uid), $with);
    }

    /*     * ****** Accessors ******* */

    public function getUser() {
        return $this->mrbpUser;
    }

    public function getBooking() {
        return $this->mrbpBooking;
    }

    public function getUID() {
        return $this->uid;
    }

    public function getBookingId() {
        return $this->booking_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getPayMethod() {
        $options = $this->getOptionsPayMethod();
        if (isset($options[$this->pay_method])) {
            return $options[$this->pay_method];
        } else {
            return null;
        }
    }

    public function getStatus() {
        $options = $this->getOptionsStatus();
        if (isset($options[$this->status])) {
            return $options[$this->status];
        } else {
            return null;
        }
    }

    public function setStatusPaid() {
        $this->status = self::STATUS_PAID;
    }

    public function getBillAmount() {
        return $this->bill_amount;
    }

    public function getBillCurrency() {
        return $this->bill_currency;
    }

    public function getBillDate() {
        return $this->bill_date;
    }

    public function getPaidAmount() {
        return $this->paid_amount;
    }

    public function setPaidAmount($v) {
        $this->paid_amount = $v;
    }

    public function getPaidCurrency() {
        return $this->paid_currency;
    }

    public function setPaidCurrency($v) {
        $this->paid_currency = $v;
    }

    public function getPaidDate() {
        return $this->paid_date;
    }

    public function setPaidDate($v) {
        if ($v == 'now') {
            $v = new CDbExpression("NOW()");
        }
        $this->paid_date = $v;
    }

    public function getSubject() {
        return $this->subject;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getRequestUrl() {
        return $this->request_url;
    }

    public function setRequestUrl($v) {
        $this->request_url = $v;
    }

    public function getDateRequest() {
        return $this->date_request;
    }

    public function setDateRequest($v) {
        if ($v == 'now') {
            $v = new CDbExpression("NOW()");
        }
        $this->date_request = $v;
    }

    public function getReturnData() {
        return $this->return_data;
    }

    public function setReturnData($v) {
        $this->return_data = $v;
    }

    public function getDateReturn() {
        return $this->date_return;
    }

    public function setDateReturn($v) {
        if ($v == 'now') {
            $v = new CDbExpression("NOW()");
        }
        $this->date_return = $v;
    }

    public function getNotifyData() {
        return $this->notify_data;
    }

    public function setNotifyData($v) {
        $this->notify_data = $v;
    }

    public function getDateNotify() {
        return $this->date_notify;
    }

    public function setDateNotify($v) {
        if ($v == 'now') {
            $v = new CDbExpression("NOW()");
        }
        $this->date_notify = $v;
    }

    public function getVendorTradeNo() {
        return $this->vendor_trade_no;
    }

    public function setVendorTradeNo($v) {
        $this->vendor_trade_no = $v;
    }

    public function getVendorTradeStatus() {
        return $this->vendor_trade_status;
    }

    public function setVendorTradeStatus($v) {
        $this->vendor_trade_status = $v;
    }

    public function getErrorCode() {
        return $this->error_code;
    }

    public function setErrorCode($v) {
        $this->error_code = $v;
    }

    public function getErrorMsg() {
        return $this->error_msg;
    }

    public function setErrorMsg($v) {
        $this->error_msg = $v;
    }

    public function getRemark() {
        return $this->remark;
    }

    public function setRemark($v) {
        return $this->remark = $v;
    }

}
