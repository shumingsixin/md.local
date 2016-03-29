<?php

class PatientInfoForm extends EFormModel {

    public $id;
    public $creator_id;
    public $name;
    public $birth_year;
    public $birth_month;
    public $gender;
    public $mobile;
    public $country_id;
    public $state_id;
    public $city_id;
    public $options_gender;
    public $options_state;
    public $options_city;
    public $disease_name;
    public $disease_detail;
    public $model;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('creator_id, name, birth_year, birth_month , gender, mobile, country_id, state_id, city_id, disease_name, disease_detail', 'required'),
            array('creator_id, gender, birth_year, birth_month ,country_id, state_id, city_id', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 50),
            array('mobile', 'length', 'max' => 50),
            array('disease_name', 'length', 'max' => 50),
            array('disease_detail', 'length', 'max' => 1000),
            array('id', 'safe'),
        );
    }

    public function initModel(PatientInfo $model = null) {
        if (isset($model)) {
            $this->model = $model;
            $this->scenario = $model->scenario;
            $attributes = $model->getAttributes();
            // set safe attributes.
            $this->setAttributes($attributes, true);
        }
        $this->country_id = 1;   // default country is China.
        $this->loadOptions();
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
            'birth_month' => '出生月份',
            'gender' => '性别',
            'mobile' => '患者联系方式',
            'country_id' => '所在国家',
            'state_id' => '所在省份',
            'city_id' => '所在城市',
            'disease_name' => '疾病诊断',
            'disease_detail' => '病史描述',
        );
    }

    public function loadOptions() {
        $this->loadOptionsGender();
        $this->loadOptionsState();
        $this->loadOptionsCity();
    }

    public function loadOptionsGender() {
        if (is_null($this->options_gender)) {
            $this->options_gender = StatCode::getOptionsGender();
        }
        return $this->options_gender;
    }

    public function loadOptionsState() {
        if (is_null($this->options_state)) {
            $this->options_state = CHtml::listData(RegionState::model()->getAllByCountryId($this->country_id), 'id', 'name');
        }
        return $this->options_state;
    }

    public function loadOptionsCity() {
        if (is_null($this->state_id)) {
            $this->options_city = array();
        } else {
            $this->options_city = CHtml::listData(RegionCity::model()->getAllByStateId($this->state_id), 'id', 'name');
        }
        return $this->options_city;
    }

}
