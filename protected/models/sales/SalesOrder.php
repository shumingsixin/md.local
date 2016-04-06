<?php

/**
 * This is the model class for table "sales_order".
 *
 * The followings are the available columns in table 'sales_order':
 * @property integer $id
 * @property string $ref_no
 * @property integer $user_id
 * @property string $bk_ref_no
 * @property integer $bk_id
 * @property integer $bk_type
 * @property string $crm_no
 * @property string $subject
 * @property string $description
 * @property string $ping_id
 * @property string $order_type
 * @property integer $is_paid
 * @property string $date_open
 * @property string $date_closed
 * @property string $created_by
 * @property string $total_amount
 * @property integer $discount_percent
 * @property string $discount_amount
 * @property string $final_amount
 * @property string $currency
 * @property string $bd_code
 * @property string $patient_name
 * @property string $patient_mobile
 * @property string $patient_age
 * @property string $patient_identity
 * @property string $patient_state
 * @property string $patient_city
 * @property string $patient_adress
 * @property string $disease_name
 * @property string $disease_detail
 * @property string $expected_doctor_name
 * @property string $expected_hospital_name
 * @property string $expected_hp_dept_name
 * @property string $creator_doctor_name
 * @property string $creator_hospital_name
 * @property string $creator_dept_name
 * @property string $final_doctor_name
 * @property string $final_doctor_hospital
 * @property string $final_time
 * @property string $customer_request
 * @property string $customer_intention
 * @property string $customer_type
 * @property string $customer_diversion
 * @property string $customer_agent
 * @property string $travel_type
 * @property string $admin_user_name
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 *
 * The followings are the available model relations:
 * @property SalesPayment[] $salesPayments
 */
class SalesOrder extends EActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'sales_order';
    }

    //表示预约定金
    const ORDER_TYPE_DEPOSIT = 'deposit';   // 预约金
    const ORDER_TYPE_SERVICE = 'service';   // 咨询费
    const ORDER_AMOUNT_DEPOSIT = 1000;
    const ORDER_AMOUNT_SERVICE = 1000;
    const ORDER_UNPAIDED = 0;
    const ORDER_PAIDED = 1;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ref_no, date_open', 'required'),
            array('user_id, bk_id, bk_type, is_paid, discount_percent', 'numerical', 'integerOnly' => true),
            array('ref_no', 'length', 'max' => 16),
            array('bk_ref_no, order_type', 'length', 'max' => 20),
            array('crm_no, created_by, bd_code, patient_name, patient_mobile, patient_age, patient_identity, patient_state, patient_city, expected_doctor_name, expected_hospital_name, expected_hp_dept_name, creator_doctor_name, creator_hospital_name, creator_dept_name, final_doctor_name, final_doctor_hospital, final_time, customer_request, customer_intention, customer_type, customer_diversion, customer_agent, travel_type, admin_user_name', 'length', 'max' => 50),
            array('subject, disease_name', 'length', 'max' => 100),
            array('description', 'length', 'max' => 500),
            array('ping_id', 'length', 'max' => 30),
            array('total_amount, discount_amount, final_amount', 'length', 'max' => 10),
            array('currency', 'length', 'max' => 3),
            array('patient_adress, disease_detail', 'length', 'max' => 200),
            array('date_closed, date_created, date_updated, date_deleted', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, ref_no, user_id, bk_ref_no, bk_id, bk_type, crm_no, subject, description, ping_id, order_type, is_paid, date_open, date_closed, created_by, total_amount, discount_percent, discount_amount, final_amount, currency, bd_code, patient_name, patient_mobile, patient_age, patient_identity, patient_state, patient_city, patient_adress, disease_name, disease_detail, expected_doctor_name, expected_hospital_name, expected_hp_dept_name, creator_doctor_name, creator_hospital_name, creator_dept_name, final_doctor_name, final_doctor_hospital, final_time, customer_request, customer_intention, customer_type, customer_diversion, customer_agent, travel_type, admin_user_name, date_created, date_updated, date_deleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'salesPayments' => array(self::HAS_MANY, 'SalesPayment', 'order_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'ref_no' => 'Ref No',
            'user_id' => '买家用户id',
            'bk_ref_no' => 'Bk Ref No',
            'bk_id' => '预约的id,来自多个不同表',
            'bk_type' => '订单种类，对应多个不同的订单表。1=booking, 2=patient_booking',
            'crm_no' => '客服CRM单号',
            'subject' => 'Subject',
            'description' => 'Description',
            'ping_id' => 'Ping++ ID',
            'order_type' => 'deposit(订金),surgery(手术费),consultation(会诊费)',
            'is_paid' => '是否已付款',
            'date_open' => '开始日期',
            'date_closed' => '完结日期',
            'created_by' => '创建者用户名',
            'total_amount' => '总金额',
            'discount_percent' => '折扣百分比',
            'discount_amount' => '折扣金额',
            'final_amount' => '最终交易金额',
            'currency' => '交易货币',
            'bd_code' => '地推',
            'patient_name' => '病人姓名',
            'patient_mobile' => '病人手机号码',
            'patient_age' => '病人年龄',
            'patient_identity' => '病人身份证号',
            'patient_state' => '病人所在省份',
            'patient_city' => '病人所在市',
            'patient_adress' => '病人地址',
            'disease_name' => '病情诊断',
            'disease_detail' => '病情描述',
            'expected_doctor_name' => 'booking的医生',
            'expected_hospital_name' => '期望医院',
            'expected_hp_dept_name' => '期望科室',
            'creator_doctor_name' => 'patient_booking的推送医生',
            'creator_hospital_name' => '推送医生医院',
            'creator_dept_name' => '推送医生科室',
            'final_doctor_name' => '最终手术医生姓名',
            'final_doctor_hospital' => '最终医生的医院',
            'final_time' => '手术时间',
            'customer_request' => '客户需求',
            'customer_intention' => '客户意向',
            'customer_type' => '客服类型',
            'customer_diversion' => '客户导流',
            'customer_agent' => '客户来源',
            'travel_type' => '患者去或医生来',
            'admin_user_name' => '业务员',
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
        $criteria->compare('ref_no', $this->ref_no, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('bk_ref_no', $this->bk_ref_no, true);
        $criteria->compare('bk_id', $this->bk_id);
        $criteria->compare('bk_type', $this->bk_type);
        $criteria->compare('crm_no', $this->crm_no, true);
        $criteria->compare('subject', $this->subject, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('ping_id', $this->ping_id, true);
        $criteria->compare('order_type', $this->order_type, true);
        $criteria->compare('is_paid', $this->is_paid);
        $criteria->compare('date_open', $this->date_open, true);
        $criteria->compare('date_closed', $this->date_closed, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('total_amount', $this->total_amount, true);
        $criteria->compare('discount_percent', $this->discount_percent);
        $criteria->compare('discount_amount', $this->discount_amount, true);
        $criteria->compare('final_amount', $this->final_amount, true);
        $criteria->compare('currency', $this->currency, true);
        $criteria->compare('bd_code', $this->bd_code, true);
        $criteria->compare('patient_name', $this->patient_name, true);
        $criteria->compare('patient_mobile', $this->patient_mobile, true);
        $criteria->compare('patient_age', $this->patient_age, true);
        $criteria->compare('patient_identity', $this->patient_identity, true);
        $criteria->compare('patient_state', $this->patient_state, true);
        $criteria->compare('patient_city', $this->patient_city, true);
        $criteria->compare('patient_adress', $this->patient_adress, true);
        $criteria->compare('disease_name', $this->disease_name, true);
        $criteria->compare('disease_detail', $this->disease_detail, true);
        $criteria->compare('expected_doctor_name', $this->expected_doctor_name, true);
        $criteria->compare('expected_hospital_name', $this->expected_hospital_name, true);
        $criteria->compare('expected_hp_dept_name', $this->expected_hp_dept_name, true);
        $criteria->compare('creator_doctor_name', $this->creator_doctor_name, true);
        $criteria->compare('creator_hospital_name', $this->creator_hospital_name, true);
        $criteria->compare('creator_dept_name', $this->creator_dept_name, true);
        $criteria->compare('final_doctor_name', $this->final_doctor_name, true);
        $criteria->compare('final_doctor_hospital', $this->final_doctor_hospital, true);
        $criteria->compare('final_time', $this->final_time, true);
        $criteria->compare('customer_request', $this->customer_request, true);
        $criteria->compare('customer_intention', $this->customer_intention, true);
        $criteria->compare('customer_type', $this->customer_type, true);
        $criteria->compare('customer_diversion', $this->customer_diversion, true);
        $criteria->compare('customer_agent', $this->customer_agent, true);
        $criteria->compare('travel_type', $this->travel_type, true);
        $criteria->compare('admin_user_name', $this->admin_user_name, true);
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
     * @return SalesOrder the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function checkBookingExists() {
        $bkRefNo = trim($this->bk_ref_no);
        if (strIsEmpty($bkRefNo) === false) {
            $booking = AdminBooking::model()->getByAttributes(array('ref_no' => $bkRefNo));
            if (isset($booking)) {
                $this->setBkType(StatCode::TRANS_TYPE_AB);
                $this->setBkId($booking->id);
            } else {
                $booking = Booking::model()->getByAttributes(array('ref_no' => $bkRefNo));
                if (isset($booking)) {
                    $this->setBkType(StatCode::TRANS_TYPE_BK);
                    $this->setBkId($booking->id);
                } else {
                    $booking = PatientBooking::model()->getByAttributes(array('ref_no' => $bkRefNo));
                    if (isset($booking)) {
                        $this->setBkType(StatCode::TRANS_TYPE_PB);
                        $this->setBkId($booking->id);
                    } else {
                        $this->addError('bk_ref_no', '预约号不存在');
                    }
                }
            }
            $this->setBkRefNo($bkRefNo);
            $this->createRefNo2($bkRefNo);
        } else {
            $this->createRandomRefno();
        }
    }

    public function createRandomRefno() {
        $flag = true;
        while ($flag) {
            $refNumber = 'MY' . date("ymd") . str_pad(mt_rand(0, 999999), 6, "0", STR_PAD_LEFT);
            if ($this->exists('t.ref_no =:refno', array(':refno' => $refNumber)) == false) {
                $this->ref_no = $refNumber;
                $flag = false;
            }
        }
    }

    //查看预约单的支付情况
    public function getByBkIdAndBkTypeAndOrderType($bkId, $bkType, $orderType, $attributes, $with, $options) {
        return $this->getByAttributes(array('bk_id' => $bkId, 'bk_type' => $bkType, 'order_type' => $orderType), $with);
    }

    //查看预约单的所有支付情况
    public function getByBkIdAndBkType($bkId, $bkType, $attributes, $with, $options) {
        return $this->getAllByAttributes(array('bk_id' => $bkId, 'bk_type' => $bkType), $with);
    }

    //根据预约号查询支付情况
    public function getByRefNo($refNo) {
        return $this->getByAttributes(array('ref_no' => $refNo));
    }

    public function initFromBk($model) {
        $this->ref_no = $model->ref_no;
        $this->user_id = $model->user_id;
        $this->bk_id = $model->id;
        $this->bk_type = StatCode::TRANS_TYPE_BK;
        $this->is_paid = 0;
        $this->created_by = Yii::app()->user->id;
        $this->date_open = new DateTime();
    }

    //来自PatientBooking数据
    public function initSalesOrder($model) {
        $this->createRefNo($model->refNo, $model->id, $model->bk_type);
        $this->user_id = $model->user_id;
        $this->bk_id = $model->id;
        $this->bk_type = $model->bk_type;
        $this->is_paid = 0;
        $this->order_type = SalesOrder::ORDER_TYPE_DEPOSIT;
        $this->subject = $model->subject;
        $this->description = $model->description;
        $this->created_by = Yii::app()->user->id;
        $this->date_open = date('Y-m-d H:i:s');
        $this->setAmount($model->amount);
    }

    public function createRefNo($refNo, $bkId, $bkType) {
        $db = Yii::app()->db;
        $sql = "SELECT COUNT(*) FROM sales_order WHERE bk_id = " . $bkId . " AND bk_type = " . $bkType;
        $result = $db->createCommand($sql)->query();
        foreach ($result as $r) {
            $count = $r['COUNT(*)'] + 1;
        }
        if ($count < 10) {
            $count = '0' . $count;
        }
        $this->ref_no = $refNo . $count;
    }

    public function createRefNo2($bkrefno) {
        $db = Yii::app()->db;
        $sql = "SELECT COUNT(*) FROM sales_order WHERE bk_ref_no = '" . $bkrefno . "'";
        $result = $db->createCommand($sql)->query();
        foreach ($result as $r) {
            $count = $r['COUNT(*)'] + 1;
        }
        if ($count < 10) {
            $count = '0' . $count;
        }
        $this->ref_no = $bkrefno . $count;
    }

    public function setAmount($v) {
        //prepare for auto calculate amount
        //no discount now
        $this->final_amount = $v;
        $this->total_amount = $this->final_amount;
        $this->discount_percent = 0;
        $this->discount_amount = 0;
    }

    /** getters and setters * */
    public function getSubject() {
        return $this->subject;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setSubject($v) {
        $this->subject = $v;
    }

    public function setDescription($v) {
        $this->description = $v;
    }

    public function setIsPaid($v) {
        $this->is_paid = $v;
    }

    public function setDateOpen($v) {
        $this->date_open = $v;
    }

    public function setDateClosed($v) {
        $this->date_closed = $v;
    }

    public function setBkRefNo($v) {
        $this->bk_ref_no = $v;
    }

    public function getIsPaid($v = true) {
        if ($v) {
            return $this->is_paid == 1 ? '已支付' : '待支付';
        } else {
            return $this->is_paid;
        }
    }

    public function getRefNo() {
        return $this->ref_no;
    }

    public function getFinalAmount() {
        return $this->final_amount;
    }

    public function getOptionsOrderType() {
        return array(
            self::ORDER_TYPE_DEPOSIT => '预约金',
            self::ORDER_TYPE_SERVICE => '咨询费',
        );
    }

    public function getOrderType($text = true) {
        if ($text) {
            $options = self::getOptionsOrderType();
            if (isset($options[$this->order_type])) {
                return $options[$this->order_type];
            } else {
                return '咨询费';
            }
        } else {
            return $this->order_type;
        }
    }

    public function getOrderTypeDefaultAmount() {
        if ($this->order_type == self::ORDER_TYPE_DEPOSIT) {
            return self::ORDER_AMOUNT_DEPOSIT;
        } elseif ($this->order_type == self::ORDER_TYPE_SERVICE) {
            return self::ORDER_AMOUNT_SERVICE;
        } else {
            return 0;
        }
    }

    public function getBkId() {
        return $this->bk_id;
    }

    public function getBkType() {
        return $this->bk_type;
    }

    public function setBkId($v) {
        $this->bk_id = $v;
    }

    public function setBkType($v) {
        $this->bk_type = $v;
    }

    public function getBdCode() {
        return $this->bd_code;
    }

    public function setBdCode($v) {
        $this->bd_code = $v;
    }

    public function getPingId() {
        return $this->ping_id;
    }

    public function setPingId($v) {
        $this->ping_id = $v;
    }

    public function getDateClose($format = self::DB_FORMAT_DATETIME) {
        $date = new DateTime($this->date_closed);
        if ($date === false) {
            return null;
        } else
            return $date->format($format);
    }

}
