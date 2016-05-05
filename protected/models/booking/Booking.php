<?php

/**
 * This is the model class for table "booking2".
 *
 * The followings are the available columns in table 'booking2':
 * @property integer $id
 * @property string $ref_no
 * @property integer $user_id
 * @property string $mobile
 * @property string $contact_name
 * @property string $contact_email
 * @property integer $bk_status
 * @property integer $bk_type
 * @property integer $doctor_id
 * @property string $doctor_name
 * @property integer $expteam_id
 * @property string $expteam_name
 * @property integer $city_id
 * @property integer $hospital_id
 * @property string $hospital_name
 * @property integer $hp_dept_id
 * @property string $hp_dept_name
 * @property string $disease_name
 * @property string $disease_detail
 * @property string $date_start
 * @property string $date_end
 * @property string $appt_date  
 * @property string $remark
 * @property string is_corporate
 * @property string user_agent
 * @property string corporate_name
 * @property string corp_staff_rel
 * @property string $submit_via;
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 *
 * The followings are the available model relations:
 * @property Doctor $doctor
 * @property ExpertTeam $expteam
 * @property Hospital $hospital
 * @property HospitalDepartment $hpDept
 * @property RegionCity $city
 * @property User $user
 */
class Booking extends EActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'booking';
    }

    //预约页面分页行数
    const BOOKING_PAGE_SIZE = 10;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ref_no, mobile, bk_status, bk_type', 'required'),
            array('doctor_user_id, user_id, bk_status, bk_type, doctor_id, expteam_id, city_id, hospital_id, hp_dept_id, is_corporate, doctor_accept', 'numerical', 'integerOnly' => true),
            array('ref_no', 'length', 'is' => 14),
            array('mobile', 'length', 'is' => 11),
            array('contact_name, doctor_name, expteam_name, hospital_name, hp_dept_name, disease_name, corporate_name, corp_staff_rel, user_agent', 'length', 'max' => 50),
            array('contact_email', 'length', 'max' => 100),
            array('disease_detail, doctor_opinion', 'length', 'max' => 1000),
            array('remark', 'length', 'max' => 500),
            array('submit_via', 'length', 'max' => 10),
            array('date_start, date_end, appt_date, date_created, date_updated, date_deleted, user_agent,is_commonweal,booking_service_id', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, ref_no, user_id, mobile, contact_name, contact_email, bk_status, bk_type, doctor_id, doctor_name, expteam_id, expteam_name, city_id, hospital_id, hospital_name, hp_dept_id, hp_dept_name, disease_name, disease_detail, date_start, date_end, appt_date, remark, submit_via, date_created, date_updated, date_deleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'bkDoctor' => array(self::BELONGS_TO, 'Doctor', 'doctor_id'),
            'bkExpertTeam' => array(self::BELONGS_TO, 'ExpertTeam', 'expteam_id'),
            'bkHospital' => array(self::BELONGS_TO, 'Hospital', 'hospital_id'),
            'bkHpDept' => array(self::BELONGS_TO, 'HospitalDepartment', 'hp_dept_id'),
            'bkCity' => array(self::BELONGS_TO, 'RegionCity', 'city_id'),
            'bkOwner' => array(self::BELONGS_TO, 'User', 'user_id'),
            'bkFiles' => array(self::HAS_MANY, 'BookingFile', 'booking_id'),
            'countFiles' => array(self::STAT, "BookingFile", 'booking_id'),
            'pbOrder' => array(self::HAS_MANY, 'SalesOrder', 'bk_id'),
            'bkComment' => array(self::HAS_MANY, 'Comment', 'bk_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'ref_no' => '预约号',
            'user_id' => '用户',
            'mobile' => '手机号',
            'contact_name' => '患者姓名',
            'contact_email' => '邮箱',
            'bk_status' => '状态',
            'bk_type' => '种类',
            'doctor_id' => '医生',
            'doctor_name' => '医生姓名',
            'expteam_id' => '专家团队',
            'expteam_name' => '专家团队',
            'city_id' => '城市',
            'hospital_id' => '医院',
            'hospital_name' => '医院名称',
            'hp_dept_id' => '科室',
            'hp_dept_name' => '科室名称',
            'disease_name' => '疾病诊断',
            'disease_detail' => '病情',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'appt_date' => 'Appt Date',
            'user_agent' => '数据来源',
            'remark' => 'Remark',
            'is_corporate' => '是否是企业用户',
            'corporate_name' => '企业名称',
            'corp_staff_rel' => '与患者的关系',
            'submit_via' => 'Submit Via',
            'date_created' => '创建日期',
            'date_updated' => 'Date Updated',
            'date_deleted' => 'Date Deleted',
            'expertBooked' => '所约专家'
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
        $criteria->compare('mobile', $this->mobile, true);
        $criteria->compare('contact_name', $this->contact_name, true);
        $criteria->compare('contact_email', $this->contact_email, true);
        $criteria->compare('bk_status', $this->bk_status);
        $criteria->compare('bk_type', $this->bk_type);
        $criteria->compare('doctor_id', $this->doctor_id);
        $criteria->compare('doctor_name', $this->doctor_name, true);
        $criteria->compare('expteam_id', $this->expteam_id);
        $criteria->compare('expteam_name', $this->expteam_name, true);
        $criteria->compare('city_id', $this->city_id);
        $criteria->compare('hospital_id', $this->hospital_id);
        $criteria->compare('hospital_name', $this->hospital_name, true);
        $criteria->compare('hp_dept_id', $this->hp_dept_id);
        $criteria->compare('hp_dept_name', $this->hp_dept_name, true);
        $criteria->compare('disease_name', $this->disease_name, true);
        $criteria->compare('disease_detail', $this->disease_detail, true);
        $criteria->compare('date_start', $this->date_start, true);
        $criteria->compare('date_end', $this->date_end, true);
        $criteria->compare('appt_date', $this->appt_date, true);
        $criteria->compare('remark', $this->remark, true);
        $criteria->compare('is_corporate', $this->is_corporate, true);
        $criteria->compare('corporate_name', $this->corporate_name, true);
        $criteria->compare('corp_staff_rel', $this->corp_staff_rel, true);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('date_updated', $this->date_updated, true);
        $criteria->compare('date_deleted', $this->date_deleted, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * 根据bookingid查询数据
     * @param type $BookingIds
     * @param type $with
     * @return type
     */
    public function getAllByIds($BookingIds, $attr = null, $with = null, $options = null) {
        $criteria = new CDbCriteria;
        if (is_array($with)) {
            $criteria->with = $with;
        }
        //$criteria->join = 'LEFT JOIN `booking_file` bookingFile ON (t.id=bookingFile.booking_id)';
        $criteria->addCondition('t.date_deleted is NULL');
        $criteria->addInCondition('t.id', $BookingIds);
        return $this->findAll($criteria);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Booking the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeValidate() {
        $this->createRefNumber();
        return parent::beforeValidate();
    }

    public function beforeSave() {

        return parent::beforeSave();
    }

    /*     * ****** Query Methods ******* */

    public function getByRefNo($refno) {
        return $this->getByAttributes(array('ref_no' => $refno));
    }

    public function getByIdAndUserId($id, $userId, $with = null) {
        return $this->getByAttributes(array('id' => $id, 'user_id' => $userId), $with);
    }

    public function getByIdAndUser($id, $userId, $mobile, $with = null) {
        $criteria = new CDbCriteria();
        $criteria->addCondition("t.date_deleted is NULL");
        $criteria->addCondition("t.id=:id AND (t.user_id=:userId OR t.mobile=:mobile)");
        $criteria->params = array(":id" => $id, ":userId" => $userId, ":mobile" => $mobile);
        $criteria->distinct = true;
        if (isset($with) && is_array($with))
            $criteria->with = $with;
        return $this->find($criteria);
    }

    public function getAllByUserIdOrMobile($userId, $mobile, $with = null, $options = null) {
        $criteria = new CDbCriteria();
        $criteria->join = 'LEFT JOIN comment c ON (t.`id` = c.`bk_id` AND c.`bk_type` =' . StatCode::TRANS_TYPE_BK . ')';
        $criteria->distinct = true;
        $criteria->compare("t.user_id", $userId, false, 'AND');
        $criteria->compare("t.mobile", $mobile, false, 'OR');
        $criteria->addCondition("t.date_deleted is NULL");
        if (isset($with) && is_array($with))
            $criteria->with = $with;
        if (isset($options['offset']))
            $criteria->offset = $options['offset'];
        if (isset($options['limit']))
            $criteria->limit = $options['limit'];
        if (isset($options['order']))
            $criteria->order = $options['order'];

        return $this->findAll($criteria);
    }

    //根据上级医生用户id查询患者预约
    public function getAllByDoctorUserId($doctorUserId) {
        return $this->getAllByAttributes(array('doctor_user_id' => $doctorUserId));
    }

    //根据上级医生用户id和bookingid查询预约详情
    public function getByIdAndDoctorUserId($id, $doctorUserId) {
        return $this->getByAttributes(array('id' => $id, 'doctor_user_id' => $doctorUserId));
    }

    public function getCountByUserIdOrMobile($userId, $mobile) {
        $criteria = new CDbCriteria();
        $criteria->compare("t.user_id", $userId, false, 'AND');
        $criteria->compare("t.mobile", $mobile, false, 'OR');
        $criteria->addCondition("t.date_deleted is NULL");
        $this->count($criteria);
    }

    public function setIsCorporate($v = 1) {
        $this->is_corporate = $v;
    }

    public function getOptionsStatus() {
        return StatCode::getOptionsBookingStatus();
        /*
          return array(
          self::STATUS_NEW => Yii::t('booking', '新'),
          self::STATUS_CONFIRMED => Yii::t('booking', '已确认'),
          self::STATUS_PAID => Yii::t('booking', '已付款'),
          self::STATUS_CANCELLED => Yii::t('booking', '已取消'),
          );
         */
    }

    public function getStatusText() {
        return StatCode::getBookingStatus($this->bk_status);
        /*
          $options = $this->getOptionsStatus();
          if (isset($options[$this->status])) {
          return $options[$this->status];
          } else {
          return '未知';
          }
         */
    }

    public function getOptionsBookingType() {
        return StatCode::getOptionsBookingType();
        /*
          return array(
          //    self::BOOKING_TYPE_FACULTY => "科室",
          self::BOOKING_TYPE_DOCTOR => "医生",
          self::BOOKING_TYPE_EXPERTTEAM => "专家团队",
          //    self::BOOKING_TYPE_HOSPITAL => "医院"
          );
         */
    }

    public function getBookingTypeText() {
        $options = $this->getOptionsBookingType();
        if (isset($options[$this->bk_type])) {
            return $options[$this->bk_type];
        } else {
            return "未知";
        }
    }

    public static function getOptionsBookingStatus() {
        return array(
            StatCode::BK_STATUS_NEW => '待付预约金',
            StatCode::BK_STATUS_PROCESSING => '安排专家中',
//            StatCode::BK_STATUS_CONFIRMED_DOCTOR => '专家已确认',
//            StatCode::BK_STATUS_PATIENT_ACCEPTED => '患者已接受',
            StatCode::BK_STATUS_SERVICE_UNPAID => '待付咨询费',
            StatCode::BK_STATUS_SERVICE_PAIDED => '待评价',
            StatCode::BK_STATUS_PROCESS_DONE => '跟进结束',
            StatCode::BK_STATUS_DONE => '已评价',
            StatCode::BK_STATUS_INVALID => '无效',
            StatCode::BK_STATUS_CANCELLED => '已取消'
        );
    }

    public function getBookingStatus() {
        $options = self::getOptionsBookingStatus();
        if (isset($options[$this->bk_status])) {
            return $options[$this->bk_status];
        } else {
            return null;
        }
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

    public function hasBookingTarget() {
        return (empty($this->booking_target) === false);
    }

    /*     * ****** Private Methods ******* */

    private function createRefNumber() {
        if ($this->isNewRecord) {
            $flag = true;
            while ($flag) {
                $refNumber = $this->getRefNumberPrefix() . date("ymd") . str_pad(mt_rand(0, 999999), 6, "0", STR_PAD_LEFT);
                if ($this->exists('t.ref_no =:refno', array(':refno' => $refNumber)) == false) {
                    $this->ref_no = $refNumber;
                    $flag = false;
                }
            }
        }
    }

    /**
     * Return ref_no prefix charactor based on bk_type
     * default 'AA' is an eception charactor
     * @return string
     */
    private function getRefNumberPrefix() {
        switch ($this->bk_type) {
            case StatCode::BK_TYPE_DOCTOR :
                return "DR";
            case StatCode::BK_TYPE_EXPERTTEAM :
                return "ET";
            case StatCode::BK_TYPE_QUICKBOOK :
                return "QB";
            case StatCode::BK_TYPE_DEPT :
                return "HP";
            default:
                return "AA";
        }
    }

    /*     * ****** Accessors ******* */

    public function getComment() {
        return $this->bkComment;
    }

    public function getExpertBooked() {
        if ($this->bk_type == StatCode::BK_TYPE_EXPERTTEAM) {
            return $this->getExpertteam();
        } elseif ($this->bk_type == StatCode::BK_TYPE_DOCTOR) {
            return $this->getDoctor();
        } else {
            return null;
        }
    }

    public function getExpertNameBooked() {
        if ($this->getExpertBooked() !== null) {
            return $this->getExpertBooked()->getName();
        } else {
            return '';
        }
    }

    public function getOwner() {
        return $this->bkOwner;
    }

    public function getBkFiles() {
        return $this->bkFiles;
    }

    public function getDoctor() {
        return $this->bkDoctor;
    }

    public function getExpertTeam() {
        return $this->bkExpertTeam;
    }

    public function getHospital() {
        return $this->bkHospital;
    }

    public function getHpDept() {
        return $this->bkHpDept;
    }

    public function getCity() {
        return $this->bkCity;
    }

    public function getRefNo() {
        return $this->ref_no;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getMobile() {
        return $this->mobile;
    }

    public function getContactName() {
        return $this->contact_name;
    }

    public function getBkStatus() {
        return self::getBookingStatus($this->bk_status);
    }

    public function setBkStatus($v) {
        $this->bk_status = $v;
    }

    public function getBookingType() {
        return StatCode::getBookingType($this->bk_type);
    }

    public function setDoctorAccept($v) {
        $this->doctor_accept = $v;
    }

    public function setDoctorOpinion($v) {
        $this->doctor_opinion = $v;
    }

    public function getDoctorName() {
        if (strIsEmpty($this->doctor_name) === false) {
            return $this->doctor_name;
        } elseif (isset($this->doctor_id) && $this->getDoctor() !== null) {
            return $this->getDoctor()->getName();
        } else {
            return '';
        }
    }

    public function getExpertteamId() {
        return $this->expteam_id;
    }

    public function getExpertteamName() {
        if (strIsEmpty($this->expteam_name) === false) {
            return $this->expteam_name;
        } elseif (isset($this->expteam_id) && $this->getExpertTeam() !== null) {
            return $this->getExpertTeam()->getName();
        } else {
            return '';
        }
    }

    public function getHospitalName() {
        if (strIsEmpty($this->hospital_name) === false) {
            return $this->hospital_name;
        } elseif (isset($this->hospital_id) && $this->getHospital() !== null) {
            return $this->getHospital()->getName();
        } else {
            return '';
        }
    }

    public function getHpDeptName() {
        if (strIsEmpty($this->hp_dept_name) === false) {
            return $this->hp_dept_name;
        } elseif (isset($this->hp_dept_id) && $this->getHpDept() !== null) {
            return $this->getHpDept()->getName();
        } else {
            return '';
        }
    }

    public function getDiseaseName() {
        return $this->disease_name;
    }

    public function getDiseaseDetail($ntext = true) {
        return $this->getTextAttribute($this->disease_detail, $ntext);
    }

    public function getDateStart($format = null) {
        return $this->getDateAttribute($this->date_start, $format);
    }

    public function getDateEnd($format = null) {
        return $this->getDateAttribute($this->date_end, $format);
    }

    public function getApptDate($format = null) {
        return $this->getDatetimeAttribute($this->appt_date, $format);
    }

    public function getRemark($ntext = true) {
        return $this->getTextAttribute($this->remark, $ntext);
    }

    public function getIsCorporate() {
        return $this->is_corporate;
    }

    public function getCorporateName() {
        return $this->corporate_name;
    }

    public function getCorpStaffRef() {
        return $this->corp_staff_rel;
    }

    public function getUserAgent() {
        return $this->user_agent;
    }

}
