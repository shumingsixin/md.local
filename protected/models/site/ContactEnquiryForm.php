<?php

class ContactEnquiryForm extends EFormModel {

    public $name;
    public $mobile;
    public $age;
    public $faculty_id;
    public $patient_condition;
    public $options_age;
    public $options_faculty;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, mobile, patient_condition', 'required', 'message' => '请输入{attribute}'),
            array('age, faculty_id', 'required', 'message' => '请选择{attribute}'),
            array('age, faculty_id', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 45),
            array('mobile', 'EValidators.PhoneNumber', 'type' => PhoneNumber::MOBILE_CHINA),
            array('age', 'numerical', 'min' => 1, 'tooSmall' => '请输入正确的{attribute}'),
            array('patient_condition', 'length', 'max' => 200),
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
            'name' => Yii::t('mr', '患者姓名'),
            'mobile' => Yii::t('mr', '手机号码'),
            'age' => Yii::t('mr', '患者年龄'),
            'faculty_id' => Yii::t('mr', '科室'),
            'patient_condition' => Yii::t('mr', '病情描述'),
            'acess_agent' => 'Acess Agent',
            'user_ip' => 'User Ip',
            'user_agent' => 'User Agent',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
            'date_deleted' => 'Date Deleted',
        );
    }

    public function initModel(ContactEnquiry $contactEnquiry=null) {
        if (isset($mrBooking)) {
            $this->id = $contactEnquiry->id;
            $this->name = $contactEnquiry->name;
            $this->age = $contactEnquiry->age;
            $this->mobile = $contactEnquiry->mobile;
            $this->faculty_id = $contactEnquiry->faculty_id;
            $this->patient_condition = $contactEnquiry->patient_condition;
        }
        $this->loadOptions();
    }

    public function loadOptions() {
        $this->loadOptionsAge();
        $this->loadOptionsFaculty();
    }

    public function loadOptionsAge() {
        if (arrayNotEmpty($this->options_age) === false) {
            $this->options_age = array();
            for ($i = 1; $i < 100; $i++) {
                $this->options_age[$i] = $i;
            }
        }
        return $this->options_age;
    }

    public function loadOptionsFaculty() {
        if (arrayNotEmpty($this->options_faculty) === false) {
            $this->options_faculty = CHtml::listData(Faculty::model()->getAllByAttributes(array('is_active' => 1)), 'id', 'name');
        }
        return $this->options_faculty;
    }

}