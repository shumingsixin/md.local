<?php

/**
 * This is the model class for table "sales_payment".
 *
 * The followings are the available columns in table 'sales_payment':
 * @property integer $id
 * @property string $uid
 * @property string $ping_charge_id
 * @property integer $order_id
 * @property integer $user_id
 * @property string $pay_channel
 * @property string $channel_trade_no
 * @property integer $payment_status
 * @property string $bill_amount
 * @property string $bill_currency
 * @property string $bill_date
 * @property string $paid_amount
 * @property string $paid_date
 * @property string $subject
 * @property string $description
 * @property string $buyer_account
 * @property string $user_host_ip
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 */
class SalesPayment extends EActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'sales_payment';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('uid', 'required'),
            array('order_id, user_id, payment_status', 'numerical', 'integerOnly' => true),
            array('uid', 'length', 'max' => 32),
            array('channel_trade_no, subject, description, buyer_account', 'length', 'max' => 100),
            array('ping_charge_id', 'length', 'max' => 50),
            array('pay_channel', 'length', 'max' => 30),
            array('bill_amount, paid_amount', 'length', 'max' => 10),
            array('bill_currency', 'length', 'max' => 3),
            array('user_host_ip', 'length', 'max' => 15),
            array('bill_date, paid_date, date_created, date_updated, date_deleted', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, uid, order_id, user_id, ping_charge_id, pay_channel, channel_trade_no, bill_amount, bill_currency, bill_date, paid_amount, paid_date, subject, description, payment_status, user_host_ip, date_created, date_updated, date_deleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'paymentOrder' => array(self::BELONGS_TO, 'SalesOrder', 'order_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'uid' => 'Uid',
            'ping_charge_id' => 'Ping Charge',
            'order_id' => 'Order',
            'user_id' => 'User',
            'pay_channel' => 'Pay Channel',
            'channel_trade_no' => 'Channel Trade Number',
            'payment_status' => 'Payment Status',
            'bill_amount' => 'Bill Amount',
            'bill_currency' => 'Bill Currency',
            'bill_date' => 'Bill Date',
            'paid_amount' => 'Paid Amount',
            'paid_date' => 'Paid Date',
            'subject' => 'Subject',
            'description' => 'Description',
            'buyer_account' => 'Buyer Account',
            'user_host_ip' => 'User Host Ip',
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
        $criteria->compare('ping_charge_id', $this->ping_charge_id, true);
        $criteria->compare('order_id', $this->order_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('pay_channel', $this->pay_channel, true);
        $criteria->compare('channel_trade_no', $this->channel_trade_no, true);
        $criteria->compare('bill_amount', $this->bill_amount, true);
        $criteria->compare('bill_currency', $this->bill_currency, true);
        $criteria->compare('bill_date', $this->bill_date, true);
        $criteria->compare('paid_amount', $this->paid_amount, true);
        $criteria->compare('paid_date', $this->paid_date, true);
        $criteria->compare('subject', $this->subject, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('payment_status', $this->payment_status);
        $criteria->compare('buyer_account', $this->buyer_account, true);
        $criteria->compare('user_host_ip', $this->user_host_ip, true);
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
     * @return SalesPayment the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function initFromOrder(SalesOrder $order, $channel) {
        $this->order_id = $order->id;
        $this->user_id = $order->user_id;
        $this->uid = strRandom();
        $this->bill_amount = $order->final_amount;
        $this->bill_currency = 'RMB';
        $this->bill_date = new CDbExpression('NOW()');
        $this->payment_status = 0;
        $this->pay_channel = $channel;
    }
    
    public function initPaymentByOrder($order, $channel) {
        $this->order_id = $order->id;
        $this->user_id = $order->userId;
        $this->uid = strRandom();
        $this->bill_amount = $order->finalAmount;
        $this->bill_currency = 'RMB';
        $this->bill_date = new CDbExpression('NOW()');
        $this->payment_status = 0;
        $this->pay_channel = $channel;
    }

    /** getter and setter * */
    public function getBillAmount() {
        return $this->bill_amount;
    }

    public function getUid() {
        return $this->uid;
    }

    public function getBuyerAccount() {
        return $this->buyer_account;
    }

    public function setPingChargeId($v) {
        $this->ping_charge_id = $v;
    }

    public function setChannelTradeNo($v) {
        $this->channel_trade_no = $v;
    }

    public function setPaymentStatus($v) {
        $this->payment_status = $v;
    }

    public function setBuyerAccount($v) {
        $this->buyer_account = $v;
    }
    
    public function setPaidAmount($v) {
        $this->paid_amount = $v;
    }
    
    public function setPaidDate($v) {
        $this->paid_date = $v;
    }

}
