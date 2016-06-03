<?php

/**
 * This is the model class for table "doctor".
 *
 * The followings are the available columns in table 'doctor':
 * @property integer $id
 * @property string $fullname
 * @property string $mobile
 * @property integer $hospital_id
 * @property string $faculty
 * @property integer $state_id
 * @property integer $city_id
 * @property string $medical_title
 * @property string $academic_title
 * @property integer $gender
 * @property string $disease_specialty
 * @property string $surgery_specialty
 * @property string $search_keywords
 * @property string $description
 * @property integer $role
 * @property string $honour
 * @property string $email
 * @property string $password
 * @property string $salt
 * @property string $password_raw
 * @property string $wechat
 * @property string $tel
 * @property integer $display_order
 * @property string $date_activated
 * @property string $date_verified
 * @property string $last_login_time
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 *
 * The followings are the available model relations:
 * @property DoctorAvatar[] $doctorAvatars
 * @property MedicalRecordAssignment[] $medicalRecordAssignments
 */
class Doctor extends EActiveRecord {

//    const GENDER_MALE = 1;
//    const GENDER_FEMALE = 2;
    const M_TITLE_ZHUREN = 1;
    const M_TITLE_ZHUREN_ASSOC = 2;
    const M_TITLE_ZHUZHI = 3;
    const M_TITLE_ZHUYUANYISHI = 4;
    const A_TITLE_PROF = 1;
    const A_TITLE_PROF_ASSOC = 2;
    const A_TITLE_NONE = 9;
    const ROLE_DOCTOR = 1;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'doctor';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, fullname, medical_title', 'required'),
            array('hospital_id, hp_dept_id, gender, role, display_order, state_id, city_id', 'numerical', 'integerOnly' => true),
            array('name, fullname, hospital_name, hp_dept_name, faculty, medical_title, academic_title, password_raw, wechat, tel', 'length', 'max' => 45),
            array('mobile', 'length', 'max' => 11),
            array('disease_specialty, surgery_specialty,specialty, avatar_url', 'length', 'max' => 200),
            array('description', 'length', 'max' => 500),
            array('email, search_keywords', 'length', 'max' => 100),
            array('password', 'length', 'max' => 64),
            array('salt', 'length', 'max' => 40),
//            array('honour', 'length', 'max' => 1500),
//            array('career_exp', 'length', 'max' => 1000),
            array('date_activated, date_verified, last_login_time, date_created, date_updated, date_deleted', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, fullname, mobile, hospital_id, faculty, medical_title, academic_title, gender, state_id, city_id, disease_specialty, surgery_specialty, description, email,wechat, tel, display_order, date_activated, date_verified, last_login_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'doctorAvatar' => array(self::HAS_ONE, 'DoctorAvatar', 'doctor_id'),
            'doctorCerts' => array(self::HAS_MANY, 'DoctorCert', 'doctor_id'),
            'doctorExpertTeam' => array(self::HAS_ONE, 'ExpertTeam', 'leader_id'),
            //'medicalRecordAssignments' => array(self::HAS_MANY, 'MedicalRecordAssignment', 'doctor_id'),
            'doctorHospital' => array(self::BELONGS_TO, 'Hospital', 'hospital_id'),
            'doctorHpDept' => array(self::BELONGS_TO, 'HospitalDepartment', 'hp_dept_id'),
            'doctorState' => array(self::BELONGS_TO, 'RegionState', 'state_id'),
            'doctorCity' => array(self::BELONGS_TO, 'RegionCity', 'city_id'),
            'doctorFaculties' => array(self::MANY_MANY, 'Faculty', 'faculty_doctor_join(faculty_id, doctor_id)'),
            'doctorDiseases' => array(self::MANY_MANY, 'Disease', 'disease_doctor_join(disease_id, doctor_id)'),
                //'doctorFacultyJoin' => array(self::HAS_MANY, 'FacultyDoctorJoin', 'doctor_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => Yii::t('doctor', '姓名（展示）'),
            'fullname' => Yii::t('doctor', '姓名'),
            'mobile' => Yii::t('doctor', '手机'),
            'is_contracted' => Yii::t('doctor', '是否签约'),
            'state_id' => Yii::t("doctor", "省份"),
            'city_id' => Yii::t("doctor", "城市"),
            'hospital_id' => Yii::t('doctor', '所属医院'),
            'hospital_name' => Yii::t('doctor', '所属医院'),
            'hp_dept_id' => Yii::t('doctor', '所属科室'),
            'hp_dept_name' => Yii::t('doctor', '所属科室'),
            'faculty' => Yii::t('doctor', '科室'),
            'title' => Yii::t('doctor', '职称'),
            'medical_title' => Yii::t('doctor', '临床职称'),
            'academic_title' => Yii::t('doctor', '学术职称'),
            'gender' => Yii::t('doctor', '性别'),
            'disease_specialty' => Yii::t('doctor', '擅长疾病'),
            'surgery_specialty' => Yii::t('doctor', '擅长手术'),
            'specialty' => Yii::t('doctor', '关联疾病'),
            'search_keywords' => Yii::t('doctor', '搜索关键词'),
            'career_exp' => Yii::t('doctor', '执业经历'),
            'description' => Yii::t('doctor', '擅长描述'),
            'role' => Yii::t('doctor', '角色'),
            'honour' => Yii::t('doctor', '荣誉'),
            'email' => Yii::t('doctor', '邮箱'),
            'password' => Yii::t("doctor", "登录密码"),
            'salt' => 'Salt',
            'password_raw' => 'Password Raw',
            'wechat' => Yii::t('doctor', '微信'),
            'tel' => Yii::t('doctor', '电话（座机）'),
            'display_order' => 'Display Order',
            'date_activated' => 'Date Activated',
            'date_verified' => 'Date Verified',
            'last_login_time' => 'Last Login Time',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('fullname', $this->fullname, true);
        $criteria->compare('mobile', $this->mobile, true);
        $criteria->compare('hospital_id', $this->hospital_id);
        $criteria->compare('hospital_name', $this->hospital_name, true);
        $criteria->compare('hp_dept_name', $this->hp_dept_name, true);
        $criteria->compare('faculty', $this->faculty, true);
        $criteria->compare('medical_title', $this->medical_title, true);
        $criteria->compare('academic_title', $this->academic_title, true);
        $criteria->compare('gender', $this->gender);
        $criteria->compare('disease_specialty', $this->disease_specialty, true);
        $criteria->compare('surgery_specialty', $this->surgery_specialty, true);
        $criteria->compare('search_keywords', $this->search_keywords, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('role', $this->role, true);
        $criteria->compare('wechat', $this->wechat, true);
        $criteria->compare('tel', $this->tel, true);
        $criteria->compare('display_order', $this->display_order);
        $criteria->compare('date_activated', $this->date_activated, true);
        $criteria->compare('date_verified', $this->date_verified, true);
        $criteria->compare('last_login_time', $this->last_login_time, true);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('date_updated', $this->date_updated, true);
        $criteria->compare('date_deleted', $this->date_deleted, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    //去掉不为空字段的空格
    protected function trimAttributes() {
        return array('name', 'fullname', 'description');
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Doctor the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function afterFind() {
        // convert json string to array.
        if (!is_null($this->honour)) {
            $this->honour = explode('#', $this->honour);
        }
        return parent::afterFind();
    }

//    public function beforeSave() {
//        if (is_array($this->honour)) {
//            // convert array to json string.
//            $this->honour = CJSON::encode($this->honour);
//        }
//        return parent::beforeSave();
//    }

    /*     * ****** Public Methods ******* */

    public function prepareNewModel() {
        $this->_createSalt();
        $this->_createPassword();
    }

    /*     * ****** Private Methods ******* */

    private function _createSalt() {
        $this->salt = $this->_strRandom(40);
    }

    private function _createPassword() {
        $this->setPassword($this->_encryptPassword($this->password_raw));
    }

    public function _encryptPassword($password, $salt = null) {
        if ($salt === null) {
            return ($this->_encrypt($password . $this->salt));
        } else {
            return ($this->_encrypt($password . $salt));
        }
    }

    private function _encrypt($value) {
        return hash('sha256', $value);
    }

    // Max length supported is 62.
    private function _strRandom($length = 40) {
        $chars = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        shuffle($chars);
        $ret = implode(array_slice($chars, 0, $length));

        return ($ret);
    }

    public function getByDoctorId($doctor_id) {
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.date_deleted is NULL');
        $criteria->compare('doctor_id', $doctor_id);
        $criteria->limit = 1;
        return $this->find($criteria);
    }

    public function getByDiseaseId($diseaseId, $doctor_id) {
        $criteria = new CDbCriteria;
        $criteria->join = 'left join disease_doctor_join b on (t.`id`=b.`doctor_id`)';
        $criteria->addCondition('t.date_deleted is NULL');
        $criteria->addNotInCondition('doctor_id', array($doctor_id));
        $criteria->compare('b.disease_id', $diseaseId);
        $criteria->limit = 3;
        return $this->findAll($criteria);
    }

    /*     * ****** Display Methods ******* */

    public function getAbsUrlAvatar($thumbnail = false) {
        if ($this->has_remote == 1) {
            return $this->remote_domain . $this->remote_file_key;
        }
        if (isset($this->avatar_url) && $this->avatar_url != '') {
            $url = $this->avatar_url;
            if (strStartsWith($url, 'http')) {
                // $url is already an absolute internet url.
                return $url;
            } else {
                // append 'http://domain.com' to the head of $url.
                return $this->getRootUrl() . $url;
            }
        } else {
            //default doctor avatar image.
            return 'http://mingyihz.oss-cn-hangzhou.aliyuncs.com/d/doctor_default155x155.jpg';
        }
    }

    public function getRootUrl() {
        if (isset($this->base_url) && ($this->base_url != '')) {
            return $this->base_url;
        } else {
            return Yii::app()->getBaseUrl(true) . '/';
        }
    }

    public function getHospitalName() {
        return $this->hospital_name;
        /*
          if (isset($this->hospital_name)) {
          return $this->hospital_name;
          } elseif (isset($this->doctorHospital)) {
          return $this->doctorHospital->getName();
          } else {
          return '';
          }
         *  
         */
    }

    public function getOptionsMedicalTitle() {
        return array(
            self::M_TITLE_ZHUREN => '主任医师',
            self::M_TITLE_ZHUREN_ASSOC => '副主任医师',
            self:: M_TITLE_ZHUZHI => '主治医师',
            self:: M_TITLE_ZHUYUANYISHI => '住院医师'
        );
    }

    /**
     * @NOTE do not use this method.
     * @return string
     */
    public function getTitle() {
        return $this->getMedicalTitle();
    }

    public function getMedicalTitle() {
        $options = $this->getOptionsMedicalTitle();
        if (isset($options[$this->medical_title]))
            return $options[$this->medical_title];
        else
            return '';
    }

    public function getOptionsAcademicTitle() {
        return array(
            self::A_TITLE_PROF => '教授',
            self::A_TITLE_PROF_ASSOC => '副教授',
            self::A_TITLE_NONE => '无'
        );
    }

    public function getAcademicTitle() {
        $options = $this->getOptionsAcademicTitle();
        if (isset($options[$this->academic_title]))
            return $options[$this->academic_title];
        else
            return '';
    }

    public function getOptionsGender() {
        return array(
            StatCode::GENDER_MALE => '男',
            StatCode::GENDER_FEMALE => '女'
        );
    }

    public function getGender($text = true) {
        if ($text) {
            $options = $this->getOptionsGender();
            if (isset($options[$this->gender]))
                return $options[$this->gender];
            else
                return '';
        }else {
            return $this->gender;
        }
    }

    /*     * ****** Accessors ******* */

    public function getDoctorState() {
        return $this->doctorState;
    }

    public function getDoctorCity() {
        return $this->doctorCity;
    }

    public function getDoctorExpertTeam() {
        return $this->doctorExpertTeam;
    }

    public function getHospital() {
        return $this->doctorHospital;
    }

    public function getHpDept() {
        return $this->doctorHpDept;
    }

    public function getFaculties() {
        return $this->doctorFaculties;
    }

    public function getDiseases() {
        return $this->doctorDiseases;
    }

    public function getName() {
        return $this->name;
    }

    public function getStateId() {
        return $this->state_id;
    }

    public function getCityId() {
        return $this->city_id;
    }

    public function getFullname() {
        return $this->fullname;
    }

    public function getStateName() {
        
    }

    public function getCityName() {
        
    }

    public function getMobile() {
        return $this->mobile;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($v) {
        $this->password = $v;
    }

    public function getHospitalId() {
        return $this->hospital_id;
    }

    /**
     * returns doctor's facutly in the hospital, NOT referring to Faculty model.
     * @return string $faculty.
     */
    public function getFaculty() {
        return $this->faculty;
    }

    public function getHpDeptId() {
        return $this->hp_dept_id;
    }

    public function getHpDeptName() {
        return $this->hp_dept_name;
        /*
          if (isset($this->hp_dept_name) && $this->hp_dept_name != '') {
          return $this->hp_dept_name;
          } elseif (isset($this->doctorHpDept)) {
          return $this->doctorHpDept->getName();
          } else {
          return null;
          }
         * 
         */
    }

    //TODO: remove this.
    public function getDiseaseSpecialty() {
        return $this->disease_specialty;
    }

    //TODO: remove this.
    public function getSurgerySpecialty() {
        return $this->surgery_specialty;
    }

    public function getDescription($ntext = false) {
        return $this->getTextAttribute($this->description, $ntext);
    }

    public function getHonourList() {
        return $this->honour;
    }

    public function getDateCreated($format = null) {
        return $this->getDateAttribute($this->date_created, $format);
    }

    public function getDoctorDiseases() {
        return $this->doctorDiseases;
    }

    public function getIsContracted() {
        return $this->is_contracted;
    }

    public function getIsExpteam() {
        return isset($this->expteam_id) ? 1 : 0;
    }

    public function getExpteamId() {
        return $this->expteam_id;
    }

    public function getCareerExp() {
        return $this->career_exp;
    }

    public function getFileUploadRootPath() {
        return Yii::app()->params['doctorAvatar'];
    }

    /**
     * gets the file upload path of given foler name.
     * @param type $folderName
     * @return type 
     */
    public function getFileUploadPath($folderName = null) {
        if ($folderName === null) {
            return $this->getFileUploadRootPath();
        } else {
            return ($this->getFileUploadRootPath() . $folderName);
        }
    }

    /**
     * get File System Path
     *
     * @param string        	
     * @return string
     */
    public function getFileSystemUploadPath($folderName = null) {
        return (Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . $this->getFileUploadPath($folderName));
    }

    public function getBaseUrl() {
        return Yii::app()->getBaseUrl(true) . '/';
    }

    public function getReasons() {
        $data = array();
        isset($this->reason_one) && $data[] = $this->reason_one;
        isset($this->reason_two) && $data[] = $this->reason_two;
        isset($this->reason_three) && $data[] = $this->reason_three;
        isset($this->reason_four) && $data[] = $this->reason_four;
        return $data;
    }

}
