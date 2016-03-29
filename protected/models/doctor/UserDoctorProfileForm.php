<?php

class UserDoctorProfileForm extends EFormModel {

    public $id;
    public $user_id;
    public $name;
    public $hospital_name;
    public $hp_dept_name;
    public $country_id;
    public $state_id;
    public $city_id;
    public $clinical_title;
    public $academic_title;
    public $terms;
    public $options_c_title;
    public $options_a_title;
    public $options_state;
    public $options_city;
    public $model;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('name, country_id, state_id, city_id, hospital_name, hp_dept_name, clinical_title, academic_title', 'required', 'message' => '请输入{attribute}'),
            array("terms", "required", "message" => "请同意{attribute}"),
            array('user_id, country_id, state_id, city_id, clinical_title, academic_title, terms', 'numerical', 'integerOnly' => true),
            array('name, clinical_title, academic_title, hospital_name, hp_dept_name', 'length', 'max' => 45),
        );
    }

    public function initModel(UserDoctorProfile $doctor = null) {
        if (isset($doctor)) {
            $this->model = $doctor;
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

            //$this->attributes = $attributes;
            $this->setAttributes($attributes, true);

            $this->scenario = $doctor->scenario;
        } else {
            // $this->model = new Doctor();
            $this->country_id = 1;   // default country is China.
        }
        $this->loadOptions();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => '真实姓名',
            'state_id' => '所在省份',
            'city_id' => '所在城市',
            'hospital_name' => '所属医院',
            'hp_dept_name' => '所属科室',
            'clinical_title' => '临床职称',
            'academic_title' => '学术职称',
            'terms' => '在线服务条款',
        );
    }

    public function loadOptions() {
        //    $this->loadOptionsHospital();
        //    $this->loadOptionsGender();
        $this->loadOptionsClinicalTitle();
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

    public function loadOptionsClinicalTitle() {
        if (is_null($this->options_c_title)) {
            $this->options_c_title = StatCode::getOptionsClinicalTitle();
        }
        return $this->options_c_title;
    }

    public function loadOptionsAcademicTitle() {
        if (is_null($this->options_a_title)) {
            $this->options_a_title = StatCode::getOptionsAcademicTitle();
        }
        return $this->options_a_title;
    }

    public function loadOptionsState() {
        if (is_null($this->options_state)) {
            $this->options_state = CHtml::listData(RegionState::model()->getAllByCountryId($this->country_id), 'id', 'name');
        }
        return $this->options_state;
    }

    public function loadOptionsCity() {
        // if (is_null($this->options_city)) {
        if (is_null($this->state_id)) {
            $this->options_city = array();
        } else {
            $this->options_city = CHtml::listData(RegionCity::model()->getAllByStateId($this->state_id), 'id', 'name');
        }
        //  }
        return $this->options_city;
    }

    /*     * ****** Accessors ******* */

    public function getMobile() {
        return $this->mobile;
    }

}
