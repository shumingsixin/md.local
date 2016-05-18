<?php

class PatientBookingForm extends EFormModel {

    public $patient_id;
    public $patient_name;
    public $expected_doctor;
    public $expected_hospital;
    public $expected_dept;
    public $creator_id;
    public $creator_name;
    public $status;
    public $travel_type;
    public $detail;
    public $user_agent;
    public $remark;
    public $options_travel_type;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('patient_id, creator_id, status, travel_type', 'required'),
            array('patient_id, creator_id, status, travel_type', 'numerical', 'integerOnly' => true),
            array('user_agent', 'length', 'max' => 20),
            array('expected_doctor', 'length', 'max' => 200),
            array('detail', 'length', 'max' => 1000),
            array('remark', 'length', 'max' => 500),
            array('expected_doctor, expected_dept, expected_hospital, patient_name, creator_name, doctor_name', 'safe'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'patient_id' => '患者',
            'creator_id' => '创建者',
            'status' => '状态',
            'travel_type' => '出行方式',
            'expected_doctor' => '期望医生',
            'expected_hospital' => '期望医院',
            'expected_dept' => '期望科室',
            'detail' => '细节',
            'remark' => '备注',
        );
    }

    public function initModel(PatientBooking $model = null) {
        if (isset($model)) {
            $attributes = $model->getAttributes();
            $this->setAttributes($attributes, true);
            $this->scenario = $model->scenario;
        } else {
            $this->status = PatientBooking::BK_STATUS_NEW;
        }

        $this->loadOptions();
    }

    public function loadOptions() {
        $this->loadOptionsTravelType();
    }

    public function loadOptionsTravelType() {
        if (is_null($this->options_travel_type)) {
            $this->options_travel_type = StatCode::getOptionsBookingTravelType();
        }
        return $this->options_travel_type;
    }

    public function setPatientId($v) {
        $this->patient_id = $v;
    }

    public function setCreatorId($v) {
        $this->creator_id = $v;
    }

    public function setStatusNew() {
        $this->status = PatientBooking::BK_STATUS_NEW;
    }

}
