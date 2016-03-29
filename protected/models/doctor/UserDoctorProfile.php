<?php

/**
 * This is the model class for table "user_doctor_profile".
 *
 * The followings are the available columns in table 'user_doctor_profile':
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $mobile
 * @property integer $gender
 * @property integer $hospital_id
 * @property string $hospital_name
 * @property integer $hp_dept_id
 * @property string $hp_dept_name
 * @property integer $clinical_title
 * @property integer $academic_title
 * @property integer $country_id
 * @property integer $state_id
 * @property string $state_name
 * @property integer $city_id
 * @property string $city_name
 * @property string $date_verified
 * @property integer $verified_by
 * @property string $preferred_patient
 * @property string $date_contracted
 * @property string $date_deleted
 * @property string $date_created
 * @property string $date_updated
 */
class UserDoctorProfile extends EActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user_doctor_profile';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, name, clinical_title', 'required'),
            array('user_id, gender, hospital_id, hp_dept_id, clinical_title, academic_title, country_id, state_id, city_id', 'numerical', 'integerOnly' => true),
            array('name, hospital_name, hp_dept_name, state_name, city_name', 'length', 'max' => 50),
            array('verified_by', 'length', 'max' => 20),
            array('mobile', 'length', 'max' => 11),
            array('date_verified, date_deleted, date_updated ,date_contracted, preferred_patient, date_terms_doctor', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, name, mobile, gender, hospital_id, hospital_name, hp_dept_id, hp_dept_name, clinical_title, academic_title, country_id, state_id, state_name, city_id, city_name, date_verified, verified_by, date_deleted, date_created, date_updated', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            //'udpCerts' => array(self::HAS_MANY, 'UserDoctorCert', 'doctor_id'),
            //'medicalRecordAssignments' => array(self::HAS_MANY, 'MedicalRecordAssignment', 'doctor_id'),
            'udpUser' => array(self::BELONGS_TO, 'User', 'user_id'),
            'udpHospital' => array(self::BELONGS_TO, 'Hospital', 'hospital_id'),
            'udpHpDept' => array(self::BELONGS_TO, 'HospitalDepartment', 'hp_dept_id'),
            'udpState' => array(self::BELONGS_TO, 'RegionState', 'state_id'),
            'udpCity' => array(self::BELONGS_TO, 'RegionCity', 'city_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => '用户',
            'name' => '姓名',
            'mobile' => '手机号',
            'gender' => '性别',
            'hospital_id' => '所属医院',
            'hospital_name' => '所属医院',
            'hp_dept_id' => '所属科室',
            'hp_dept_name' => '所属科室',
            'clinical_title' => '临床职称',
            'academic_title' => '学术职称',
            'country_id' => '国家',
            'state_id' => '省份',
            'state_name' => '省份名称',
            'city_id' => '城市',
            'city_name' => '城市名称',
            'date_verified' => '认证日期',
            'verified_by' => '认证人员',
            'preferred_patient' => '希望收到的病人/病历',
            'date_contracted' => '签约专家签约日期',
            'date_deleted' => 'Date Deleted',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
        );
    }

    public function beforeValidate() {
        if (is_null($this->country_id)) {
            $this->country_id = 1;
        }
        return parent::beforeValidate();
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
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('mobile', $this->mobile, true);
        $criteria->compare('gender', $this->gender);
        $criteria->compare('hospital_id', $this->hospital_id);
        $criteria->compare('hospital_name', $this->hospital_name, true);
        $criteria->compare('hp_dept_id', $this->hp_dept_id);
        $criteria->compare('hp_dept_name', $this->hp_dept_name, true);
        $criteria->compare('clinical_title', $this->clinical_title);
        $criteria->compare('academic_title', $this->academic_title);
        $criteria->compare('country_id', $this->country_id);
        $criteria->compare('state_id', $this->state_id);
        $criteria->compare('state_name', $this->state_name, true);
        $criteria->compare('city_id', $this->city_id);
        $criteria->compare('city_name', $this->city_name, true);
        $criteria->compare('date_verified', $this->date_verified, true);
        $criteria->compare('verified_by', $this->verified_by);
        $criteria->compare('date_contracted', $this->date_contracted);
        $criteria->compare('date_deleted', $this->date_deleted, true);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('date_updated', $this->date_updated, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserDoctorProfile the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //去掉不为空字段的空格
    protected function trimAttributes() {
        return array('name', 'hospital_name', 'hp_dept_name');
    }

    public function isVerified() {
        return $this->date_verified !== null;
    }

    /*     * ****** Query Methods ******* */

    //医生信息查询
    public function getByUserId($userId, $attributes = null, $with = null) {
        return $this->getByAttributes(array('user_id' => $userId), $with);
    }

    /*     * ****** Accessors ******* */

    public function getHospital() {
        return $this->udpHospital;
    }

    public function getHpDept() {
        return $this->udpHpDept;
    }

    public function getRegionState() {
        return $this->udpState;
    }

    public function getRegionCity() {
        return $this->udpCity;
    }

    public function getStateName() {
        if (strIsEmpty($this->state_name) === false) {
            return $this->state_name;
        } elseif ($this->getRegionState() !== null) {
            return $this->getRegionState()->getName();
        } else {
            return '';
        }
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getName() {
        return $this->name;
    }

    public function setMobile($mobile) {
        $this->mobile = $mobile;
    }

    public function getMobile() {
        return $this->mobile;
    }

    public function getGender($text = true) {
        if ($text) {
            return StatCode::getGender($this->gender);
        } else {
            return $this->gender;
        }
    }

    public function getHospitalId() {
        return $this->hospital_id;
    }

    public function getHospitalName() {
        if (strIsEmpty($this->hospital_name) === false) {
            return $this->hospital_name;
        } elseif ($this->getHospital() !== null) {
            return $this->getHospital()->getName();
        } else {
            return '';
        }
    }

    public function getHpDeptId() {
        return $this->hp_dept_id;
    }

    public function getHpDeptName() {
        if (strIsEmpty($this->hp_dept_name) === false) {
            return $this->hp_dept_name;
        } elseif ($this->getHpDept() !== null) {
            return $this->getHpDept()->getName();
        } else {
            return '';
        }
    }

    public function getCountryId() {
        return $this->country_id;
    }

    public function getStateId() {
        return $this->state_id;
    }

    public function getCityId() {
        return $this->city_id;
    }

    public function getCityName() {
        if (strIsEmpty($this->city_name) === false) {
            return $this->city_name;
        } elseif ($this->getRegionCity() !== null) {
            return $this->getRegionCity()->getName();
        } else {
            return '';
        }
    }

    public function getDateVerified() {
        return $this->getDatetimeAttribute($this->date_verified);
    }

    public function getVerifiedBy() {
        return $this->verified_by;
    }

    public function getDateContracted() {
        return $this->date_contracted;
    }

    public function getPreferredPatient() {
        return $this->preferred_patient;
    }

    public function getClinicalTitle($text = true) {
        if ($text) {
            return StatCode::getClinicalTitle($this->clinical_title);
        } else {
            return $this->clinical_title;
        }
    }

    public function getAcademictitle($text = true) {
        if ($text) {
            return StatCode::getAcademictitle($this->academic_title);
        } else {
            return $this->academic_title;
        }
    }

    public function setVerified() {
        $this->date_verified = new CDbExpression("NOW()");
    }

    public function unsetVerified() {
        $this->date_verified = NULL;
    }

    public function setVerifiedBy($v) {
        $this->verified_by = $v;
    }

    public function isContractDoctor() {
        return $this->date_contracted !== null;
    }

    public function isTermsDoctor() {
        return $this->date_terms_doctor !== null;
    }

}
