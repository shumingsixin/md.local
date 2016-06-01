<?php

/**
 * This is the model class for table "patient_booking".
 *
 * The followings are the available columns in table 'patient_booking':
 * @property integer $id
 * @property integer $patient_id
 * @property String $patient_name
 * @property integer $doctor_id
 * @property String $dcotor_name
 * @property integer $creator_id
 * @property String $creator_name
 * @property integer $status
 * @property integer $travel_type
 * @property string $date_start
 * @property string $date_end
 * @property string $detail
 * @property integer is_deposit_paid
 * @property string $appt_date
 * @property string $date_confirm
 * @property string $remark
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 *
 * The followings are the available model relations:
 * @property PatientInfo $patient
 * @property User $creator
 */
class PatientBooking extends EActiveRecord {

    const BK_STATUS_NEW = 1;         // 待支付
    const BK_STATUS_PROCESSING = 2;   // 安排中    
    //const BK_STATUS_CONFIRMED_DOCTOR = 3;   // 已确认专家
    //const BK_STATUS_PATIENT_ACCEPTED = 4;   // 患者已接受
    const BK_STATUS_SERVICE_UNPAID = 5;   //待确认
    const BK_STATUS_SERVICE_PAIDED = 6;   // 上传出院小结
    //const BK_STATUS_INVALID = 7;        // 失效的
    const BK_STATUS_SURGER_DONE = 8;        // 已完成
    const BK_STATUS_CANCELLED = 9;          // 已取消

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'patient_booking';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('patient_id, creator_id, status, travel_type', 'required'),
            array('patient_id, creator_id, doctor_id, status, travel_type, operation_finished', 'numerical', 'integerOnly' => true),
            array('ref_no', 'length', 'is' => 14),
            array('user_agent, doctor_name, patient_name, creator_name', 'length', 'max' => 20),
            array('expected_doctor', 'length', 'max' => 200),
            array('expected_dept, expected_hospital', 'length', 'max' => 200),
            array('detail', 'length', 'max' => 1000),
            array('remark, cs_explain, doctor_opinion', 'length', 'max' => 500),
            array('expected_dept, expected_hospital, expected_doctor, appt_date, date_confirm, date_created, date_updated, date_deleted, date_start, date_end', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, ref_no, patient_id, patient_name, doctor_id, doctor_name, creator_id, creator_name, status, travel_type, date_start, date_end, detail, appt_date, date_confirm, remark, date_created, date_updated, date_deleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'pbPatient' => array(self::BELONGS_TO, 'PatientInfo', 'patient_id'),
            'pbCreator' => array(self::BELONGS_TO, 'User', 'creator_id'),
            'pbDoctor' => array(self::BELONGS_TO, 'User', 'doctor_id'),
            'pbOrder' => array(self::HAS_MANY, 'SalesOrder', 'bk_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'ref_no' => '预约号',
            'patient_id' => '患者',
            'patient_name' => '患者',
            'creator_id' => '创建者',
            'creator_name' => '创建者',
            'doctor_id' => '预约医生',
            'doctor_name' => '预约医生',
            'status' => '状态',
            'travel_type' => '出行方式',
            'date_start' => '开始日期',
            'date_end' => '结束日期',
            'detail' => '细节',
            'is_deposit_paid' => '是否支付定金',
            'appt_date' => '最终预约日期',
            'date_confirm' => '预约确认日期',
            'remark' => '备注',
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
        $criteria->compare('ref_no', $this->ref_no);
        $criteria->compare('patient_id', $this->patient_id);
        $criteria->compare('patient_name', $this->patient_name, true);
        $criteria->compare('doctor_id', $this->doctor_id);
        $criteria->compare('doctor_name', $this->doctor_name, true);
        $criteria->compare('creator_id', $this->creator_id);
        $criteria->compare('creator_name', $this->creator_name, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('travel_type', $this->travel_type);
        $criteria->compare('date_start', $this->date_start, true);
        $criteria->compare('date_end', $this->date_end, true);
        $criteria->compare('detail', $this->detail, true);
        $criteria->compare('appt_date', $this->appt_date, true);
        $criteria->compare('date_confirm', $this->date_confirm, true);
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
     * @return PatientBooking the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeValidate() {
        $this->createRefNumber();
        return parent::beforeValidate();
    }

    //查询创建者旗下所有的患者
    public function getAllByCreatorId($creatorId, $status, $attributes = '*', $with = null, $options = null) {
        if ($status == '0') {
            $array = array('t.creator_id' => $creatorId);
        } else {
            $array = array('t.creator_id' => $creatorId, 't.status' => $status);
        }
        return $this->getAllByAttributes($array, $with, $options);
    }

    //查询该创建者旗下的患者信息
    public function getByIdAndCreatorId($id, $creatorId, $attributes = '*', $with = null) {
        return $this->getByAttributes(array('id' => $id, 'creator_id' => $creatorId), $with);
    }

    //根据外键查询booking
    public function getByPatientId($patientId, $attributes = '*', $with = null) {
        return $this->getByAttributes(array('patient_id' => $patientId), $with);
    }

    //查询预约该医生的患者列表
    public function getAllByDoctorId($doctorId, $attributes = '*', $with = null, $options = null) {
        return $this->getAllByAttributes(array('t.doctor_id' => $doctorId), $with, $options);
    }

    //查询预约该医生的患者详细信息
    public function getByIdAndDoctorId($id, $doctorId, $attributes = '*', $with = null) {
        return $this->getByAttributes(array('id' => $id, 'doctor_id' => $doctorId), $with);
    }

    /*     * ****** Accessors ******* */

    public function getPatient() {
        return $this->pbPatient;
    }

    public function getCreator() {
        return $this->pbCreator;
    }

    public function getDoctor() {
        return $this->pbDoctor;
    }

    public function getOrder() {
        return $this->pbOrder;
    }

    public function getId() {
        return $this->id;
    }

    public function getRefNo() {
        return $this->ref_no;
    }

    public function getPatientId() {
        return $this->patient_id;
    }

    public function getCreatorId() {
        return $this->creator_id;
    }

    public function getDoctorId() {
        return $this->doctor_id;
    }

    public function getCreatorName() {
        return $this->creator_name;
    }

    public function getPatientName() {
        return $this->patient_name;
    }

    public function getDoctorName() {
        return $this->doctor_name;
    }

    public function getOptionsBkStatus() {
        return array(
            self::BK_STATUS_NEW => '待支付',
            self::BK_STATUS_PROCESSING => '安排中',
            //self::BK_STATUS_CONFIRMED_DOCTOR => '已确认专家',
            //    self::BK_STATUS_PATIENT_ACCEPTED => '患者已接受',
            self::BK_STATUS_SERVICE_UNPAID => '待确认',
            self::BK_STATUS_SERVICE_PAIDED => '传小结',
            self::BK_STATUS_SURGER_DONE => '已完成',
            self::BK_STATUS_CANCELLED => '已取消',
                //self::BK_STATUS_INVALID => '失效的'
        );
    }

    public function getStatus($text = true) {
        if ($text) {
            $options = self::getOptionsBkStatus();
            if (isset($options[$this->status])) {
                return $options[$this->status];
            } else {
                return StatCode::ERROR_UNKNOWN;
            }
        } else {
            return $this->status;
        }
    }

    public function getTitleBkStatus() {
        return array(
            self::BK_STATUS_NEW => '请您支付手术预约金',
            self::BK_STATUS_PROCESSING => '当前状态:安排专家中',
            self::BK_STATUS_SERVICE_UNPAID => '当前状态:待支付平台咨询费',
            self::BK_STATUS_SERVICE_PAIDED => '当前状态:待上传出院小结',
            self::BK_STATUS_SURGER_DONE => '感谢你协助完成了该例手术!',
        );
    }

    public function getStatusTitle() {
        $options = self::getTitleBkStatus();
        if (isset($options[$this->status])) {
            return $options[$this->status];
        } else {
            return StatCode::ERROR_UNKNOWN;
        }
    }

    public function getTravelType($text = true) {
        if ($text) {
            return StatCode::getBookingTravelType($this->travel_type);
        } else {
            return $this->travel_type;
        }
    }

    public function getDateStart($format = null) {
        return $this->getDateAttribute($this->date_start, $format);
    }

    public function getDateEnd($format = null) {
        return $this->getDateAttribute($this->date_end, $format);
    }

    public function getDetail($ntext = true) {
        return $this->getTextAttribute($this->detail, $ntext);
    }

    public function getApptdate($format = null) {
        return $this->getDateAttribute($this->appt_date, $format);
    }

    public function getDateConfirm($format = null) {
        return $this->getDatetimeAttribute($this->date_confirm, $format);
    }

    public function getRemark($ntext = true) {
        return $this->getTextAttribute($this->remark, $ntext);
    }

    public function getDoctorAccept() {
        return $this->doctor_accept;
    }

    public function getDoctorOpinion($ntext = true) {
        return $this->getTextAttribute($this->doctor_opinion, $ntext);
    }

    public function getCsExplain($ntext = true) {
        return $this->getTextAttribute($this->cs_explain, $ntext);
    }

    public function getIsDepositPaid($text = false) {
        if ($text) {
            return StatCode::getPaymentStatus($this->is_deposit_paid);
        } else {
            return $this->is_deposit_paid;
        }
    }

    public function getUserAgent() {
        return $this->user_agent;
    }

    public function getExpectedDoctor() {
        return $this->expected_doctor;
    }

    public function setStatus($v) {
        $this->status = $v;
    }

    public function setCreatorId($v) {
        $this->creator_id = $v;
    }

    public function setPatientId($v) {
        $this->patient_id = $v;
    }

    public function setDoctorId($v) {
        $this->doctor_id = $v;
    }

    public function setCreatorName($v) {
        $this->creator_name = $v;
    }

    public function setPatientName($v) {
        $this->patient_name = $v;
    }

    public function setDoctorName($v) {
        $this->doctor_name = $v;
    }

    public function setDoctorAccept($v) {
        $this->doctor_accept = $v;
    }

    public function setDoctorOpinion($v) {
        $this->doctor_opinion = $v;
    }

    /*     * ****** Private Methods ******* */

    private function createRefNumber() {
        if ($this->isNewRecord) {
            $flag = true;
            while ($flag) {
                $refNumber = 'PB' . date("ymd") . str_pad(mt_rand(0, 999999), 6, "0", STR_PAD_LEFT);
                if ($this->exists('t.ref_no =:refno', array(':refno' => $refNumber)) == false) {
                    $this->ref_no = $refNumber;
                    $flag = false;
                }
            }
        }
    }

}
