<?php

/**
 * This is the model class for table "sales_payment_data".
 *
 * The followings are the available columns in table 'sales_payment_data':
 * @property integer $id
 * @property integer $payment_id
 * @property string $request_url
 * @property string $request_data
 * @property string $date_request
 * @property string $return_data
 * @property string $date_return
 * @property string $notify_data
 * @property string $date_notify
 * @property string $vendor_trade_no
 * @property string $vendor_trade_status
 * @property string $error_code
 * @property string $error_msg
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 */
class SalesPaymentData extends EActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'sales_payment_data';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('payment_id', 'numerical', 'integerOnly' => true),
            array('request_url, error_msg', 'length', 'max' => 1024),
            array('request_data, return_data, notify_data', 'length', 'max' => 4096),
            array('vendor_trade_no', 'length', 'max' => 64),
            array('vendor_trade_status, error_code', 'length', 'max' => 45),
            array('date_request, date_return, date_notify, date_created, date_updated, date_deleted', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, payment_id, request_url, date_request, return_data, date_return, notify_data, date_notify, vendor_trade_no, vendor_trade_status, error_code, error_msg, date_created, date_updated, date_deleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'payment_id' => 'Payment',
            'request_url' => 'Request Url',
            'request_data' => 'Request Data',
            'date_request' => 'Date Request',
            'return_data' => 'Return Data',
            'date_return' => 'Date Return',
            'notify_data' => 'Notify Data',
            'date_notify' => 'Date Notify',
            'vendor_trade_no' => 'Vendor Trade No',
            'vendor_trade_status' => 'Vendor Trade Status',
            'error_code' => 'Error Code',
            'error_msg' => 'Error Msg',
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
        $criteria->compare('payment_id', $this->payment_id);
        $criteria->compare('request_url', $this->request_url, true);
        $criteria->compare('request_data', $this->request_data, true);
        $criteria->compare('date_request', $this->date_request, true);
        $criteria->compare('return_data', $this->return_data, true);
        $criteria->compare('date_return', $this->date_return, true);
        $criteria->compare('notify_data', $this->notify_data, true);
        $criteria->compare('date_notify', $this->date_notify, true);
        $criteria->compare('vendor_trade_no', $this->vendor_trade_no, true);
        $criteria->compare('vendor_trade_status', $this->vendor_trade_status, true);
        $criteria->compare('error_code', $this->error_code, true);
        $criteria->compare('error_msg', $this->error_msg, true);
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
     * @return SalesPaymentData the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function initFromPayment(SalesPayment $payment, $requestData) {
        $this->payment_id = $payment->id;
        $this->date_request = new CDbExpression('NOW()');
        $this->request_data = $requestData;
    }

    /** getters and setters * */
    public function setRequestData($v) {
        $this->request_data = $v;
    }

    public function setReturnData($v) {
        $this->return_data = $v;
    }

    public function setDateReturn($v) {
        $this->date_return = $v;
    }

    public function setNotifyData($v) {
        $this->notify_data = $v;
    }

    public function setDateNotify($v) {
        $this->date_notify = $v;
    }

    public function setErrorCode($v) {
        $this->error_code = $v;
    }

    public function setErrorMsg($v) {
        $this->error_msg = $v;
    }

}
