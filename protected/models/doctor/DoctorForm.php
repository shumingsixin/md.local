<?php

class DoctorForm extends EFormModel {

    public $id;
    public $password;
    public $password_repeat;
    public $name;
    public $fullname;
    public $mobile;
    public $hospital_id;
    public $hospital_name;
    public $hp_dept_id;
    public $hp_dept_name;
    public $faculty;
    public $country_id;
    public $state_id;
    public $city_id;
    public $medical_title;
    public $academic_title;
    public $gender;
    public $disease_specialty;
    public $surgery_specialty;
    public $search_keywords;
    public $description;
    public $email;
    public $tel;
    public $wechat;
    public $display_order;
    public $verify_code;
    public $options_hospital;
    public $options_gender;
    public $options_m_title;
    public $options_a_title;
    public $options_state;
    public $options_city;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('mobile,password, name, fullname, state_id, city_id, hospital_id, hospital_name, faculty, medical_title', 'required', 'message' => '请输入{attribute}'),
            array("gender", "required", "message" => "请选择{attribute}"),
            array('id, hospital_id, hp_dept_id, state_id, city_id, gender, medical_title, academic_title, display_order', 'numerical', 'integerOnly' => true),
            array('name, fullname, faculty, medical_title, academic_title, hospital_name, hp_dept_name, wechat, tel', 'length', 'max' => 45),
            array('mobile', 'length', 'is' => 11, 'message' => '请输入正确的11位中国手机号码'),
            array('mobile', 'numerical', 'integerOnly' => true, 'message' => '请输入正确的11位中国手机号码'),
            array('mobile', 'checkUnique'),
            array('password', 'length', 'min' => 4, 'max' => 40, 'tooShort' => '最短为4个字母或数字'),
            array('disease_specialty, surgery_specialty, description', 'length', 'max' => 200),
            array('email, search_keywords', 'length', 'max' => 100),
            array("hospital_name", "validateHospitalName"),
            array('verify_code', 'required', 'message' => '请输入{attribute}'),
            array('verify_code', 'length', 'is' => 6, 'message' => '{attribute}不正确'),
            array('verify_code', 'numerical', 'integerOnly' => true, 'message' => '{attribute}不正确'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array_merge(Doctor::model()->attributeLabels(), array(
            'verify_code' => "短信验证码"
        ));
    }

    public function beforeValidate() {
        if (is_null($this->name) || trim($this->name) == "") {
            $this->name = $this->fullname;
        }
        $this->hospital_id = 0; //TODO: re-implement hospital_id. - QP 2015-07-20
        return parent::beforeValidate();
    }

    public function checkUnique() {
        if (Doctor::model()->exists('mobile=:mobile', array(':mobile' => $this->mobile))) {
            $this->addError('mobile', $this->getAttributeLabel('mobile') . '已被注册');
        }
    }

    public function validateHospitalName() {
        if ($this->hospital_id == 0) {
            if (trim($this->hospital_name) == "") {
                $this->addError("hospital_name", "请输入" . $this->getAttributeLabel("hospital_name"));
            }
        }
    }

    public function initModel(Doctor $doctor = null) {
        if (isset($doctor)) {

            $attributes = $doctor->attributes;

            unset($attributes['date_created']);
            unset($attributes['date_updated']);
            unset($attributes['date_deleted']);
            unset($attributes['password']);
            unset($attributes['password_raw']);
            unset($attributes['salt']);
            unset($attributes['date_activated']);
            unset($attributes['date_verified']);
            unset($attributes['last_login_time']);

            $this->attributes = $attributes;

            $this->scenario = $doctor->scenario;
        } else {
            $this->country_id = 1;   // defaulty country is China.
        }

        $this->loadOptions();
    }

    public function loadOptions() {
        $this->loadOptionsHospital();
        $this->loadOptionsGender();
        $this->loadOptionsMedicalTitle();
        $this->loadOptionsAcademicTitle();
        $this->loadOptionsState();
        $this->loadOptionsCity();
    }

    public function loadOptionsHospital() {
        if (is_null($this->options_hospital)) {
            $this->options_hospital = CHtml::listData(Hospital::model()->getAll(null, array('order' => 't.name ASC')), 'id', 'name');
        }
        return $this->options_hospital;
    }

    public function loadOptionsGender() {
        if (is_null($this->options_gender)) {
            $this->options_gender = Doctor::model()->getOptionsGender();
        }
        return $this->options_gender;
    }

    public function loadOptionsMedicalTitle() {
        if (is_null($this->options_m_title)) {
            $this->options_m_title = Doctor::model()->getOptionsMedicalTitle();
        }
        return $this->options_m_title;
    }

    public function loadOptionsAcademicTitle() {
        if (is_null($this->options_a_title)) {
            $this->options_a_title = Doctor::model()->getOptionsAcademicTitle();
        }
        return $this->options_a_title;
    }

    public function loadOptionsState() {
        if (is_null($this->options_state)) {
            $this->options_state = CHtml::listData(RegionState::model()->getAllByCountryId($this->country_id), 'id', 'name_cn');
        }
        return $this->options_state;
    }

    public function loadOptionsCity() {
        if (is_null($this->state_id)) {
            $this->options_city = array();
        } else {
            $this->options_city = CHtml::listData(RegionCity::model()->getAllByStateId($this->state_id), 'id', 'name_cn');
        }
        return $this->options_city;
    }

    /*     * ****** Accessors ******* */

    public function getMobile() {
        return $this->mobile;
    }

    public function getVerifyCode() {
        return $this->verify_code;
    }

}
