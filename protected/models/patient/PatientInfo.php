<?php

/**
 * This is the model class for table "patient_info".
 *
 * The followings are the available columns in table 'patient_info':
 * @property integer $id
 * @property integer $creator_id
 * @property string $name
 * @property string $mobile
 * @property integer $birth_year
 * @property integer $birth_month
 * @property integer age
 * @property integer age_month
 * @property integer $gender
 * @property integer $country_id
 * @property integer $state_id
 * @property interger $state_name
 * @property integer $city_id
 * @property integer $city_name
 * @property string $disease_name
 * @property string $disease_detail
 * @property string $remark
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 */
class PatientInfo extends EActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'patient_info';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('creator_id, name, birth_year,birth_month, gender, country_id, state_id, city_id', 'required'),
            array('creator_id, gender, country_id, state_id, birth_month, city_id', 'numerical', 'integerOnly' => true),
            array('name, disease_name', 'length', 'max' => 50),
            array('state_name, city_name', 'length', 'max' => 20),
            array('disease_detail', 'length', 'max' => 1000),
            array('remark', 'length', 'max' => 500),
            array('mobile', 'length', 'max' => 50),
            array('date_created, date_updated, date_deleted, disease_name,disease_detail', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, creator_id, name, birth_year, gender, date_created, date_updated, date_deleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            //'patientMR' => array(self::HAS_ONE, 'PatientMR', 'patient_id'), // @DELETE
            'patientMRFiles' => array(self::HAS_MANY, 'PatientMRFile', 'patient_id'),
            'patientBookings' => array(self::HAS_MANY, 'PatientBooking', 'patient_id'),
            'patientCreator' => array(self::BELONGS_TO, 'User', 'creator_id'),
            'patientCountry' => array(self::BELONGS_TO, 'RegionCountry', 'country_id'),
            'patientState' => array(self::BELONGS_TO, 'RegionState', 'state_id'),
            'patientCity' => array(self::BELONGS_TO, 'RegionCity', 'city_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'creator_id' => '所属医生',
            'name' => '姓名',
            'birth_year' => '出生年份',
            'birth_year' => '出生月份',
            'age' => '年龄',
            'age_month' => '年龄余下的月数',
            'gender' => '性别',
            'mobile' => '手机号码',
            'country_id' => '所在国家',
            'state_id' => '所在省份',
            'state_name' => '所在省份',
            'city_id' => '所在城市',
            'city_name' => '所在城市',
            'disease_name' => '疾病诊断',
            'disease_detail' => '病史描述',
            'remark' => '备注',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
            'date_deleted' => 'Date Deleted',
        );
    }

    protected function trimAttributes(){
        return array('name', 'disease_name');
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
        $criteria->compare('creator_id', $this->creator_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('mobile', $this->mobile, true);
        $criteria->compare('birth_year', $this->birth_year);
        $criteria->compare('birth_month', $this->birth_month);
        $criteria->compare('age', $this->age);
        $criteria->compare('age_month', $this->age_month);
        $criteria->compare('gender', $this->gender);
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
     * @return PatientInfo the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getByIdAndCreatorId($id, $creatorId, $attributes = '*', $with = null, $options = null) {
        return $this->getByAttributes(array('id' => $id, 'creator_id' => $creatorId), $with, $options);
    }

    //查询患者列表
    public function getAllByCreateorId($creatorId, $attributes = '*', $with = null, $options = null) {
        return $this->getAllByAttributes(array('t.creator_id' => $creatorId), $with, $options);
    }

    /*     * ****** Accessors ******* */

    public function getCreator() {
        return $this->patientCreator;
    }

    public function getPatientMR() {
        return $this->patientMR;
    }

    public function getMR() {
//        $model = new Patient();
//        $model->setAttributes(array('id'=>$this->getId(),'disease_name'=>$this->getDiseaseName(),'disease_detail'=>$this->getDiseaseDetail()));
//        return  $model;
    }

    public function getMRFiles() {
        return $this->patientMRFiles;
    }

    public function getCreatorId() {
        return $this->creator_id;
    }

    public function getBookings() {
        return $this->patientBookings;
    }

    public function getStateName() {
        if (strIsEmpty($this->state_name) === false) {
            return $this->state_name;
        } elseif (isset($this->patientState)) {
            return $this->patientState->getName();
        } else {
            return '';
        }
    }

    public function getCityName() {
        if (strIsEmpty($this->city_name) === false) {
            return $this->city_name;
        } elseif (isset($this->patientCity)) {
            return $this->patientCity->getName();
        } else {
            return '';
        }
    }

    public function getDateCreated($format = 'm-d') {
        $date = new DateTime($this->date_created);
        return $date->format($format);
    }

    public function getName() {
        return $this->name;
    }

    public function getBirthYear() {
        return $this->birth_year;
    }

    public function getBirthMonth() {
        return $this->birth_month;
    }

    public function setBirthYear($v) {
        if ($v < 150) {
            // 年龄
            $yearNow = date('Y');
            $this->birth_year = $yearNow - $v;
        } else {
            // 出生年份
            $this->birth_year = $v;
        }
    }

    public function setAge() {
        $timeStart = $this->getBirthYear() . '-' . $this->getBirthMonth();
        $timeStart = date_create($timeStart);
        $timeEnd = date_create(date('Y-m'));
        $interval = date_diff($timeStart, $timeEnd);
        $this->age = $interval->y;
        $this->age_month = $interval->m;
    }

    public function getAge() {
        return $this->age;
    }

    public function getAgeMonth() {
        if (is_null($this->age_month)) {
            return 0;
        }
        return $this->age_month;
    }

    public function getGender($text = true) {
        if ($text) {
            $options = StatCode::getOptionsGender();
            if (isset($options[$this->gender]))
                return $options[$this->gender];
            else
                return '';
        }else {
            return $this->gender;
        }
    }

    public function getMobile(){
        return $this->mobile;
    }

    public function getDiseaseName() {
        return $this->disease_name;
    }

    public function getDiseaseDetail($ntext = true) {
        return $this->getTextAttribute($this->disease_detail, $ntext);
    }

    public function getRemark($ntext = true) {
        return $this->getTextAttribute($this->remark, $ntext);
    }


}
