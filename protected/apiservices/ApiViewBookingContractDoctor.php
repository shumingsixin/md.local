<?php

class ApiViewBookingContractDoctor extends EApiViewService {

    private $patientId;
    private $creatorId;
    private $doctorId;
    private $patientMgr;
    private $doctor;
    private $patient;

    public function __construct($patientId, $creatorId, $doctorId) {
        parent::__construct();
        $this->patientId = $patientId;
        $this->creatorId = $creatorId;
        $this->doctorId = $doctorId;
        $this->patientMgr = new PatientManager();
        $this->doctor = null;
        $this->patient = null;
    }

    protected function createOutput() {
        $this->output = array(
            'status' => self::RESPONSE_OK,
            'errorCode' => 0,
            'errorMsg' => 'success',
            'results' => $this->results,
        );
    }

    protected function loadData() {
        $this->loadDoctor();
        $this->loadPatienInfo();
    }

    //调用model层方法
    private function loadPatienInfo() {
        $model = $this->patientMgr->loadPatientInfoByIdAndCreateorId($this->patientId, $this->creatorId, null);
        if (isset($model)) {
            $this->setPatientInfo($model);
        }
        $this->results->patient = $this->patient;
    }

    //查询到的数据过滤
    private function setPatientInfo(PatientInfo $model) {
        $data = new stdClass();
        $data->id = $model->getId();
        $data->name = $model->getName();
        $data->age = $model->getAge();
        $data->ageMonth = $model->getAgeMonth();
        $data->gender = $model->getGender();
        $this->patient = $data;
    }

    private function loadDoctor() {
        $doctor = Doctor::model()->getById($this->doctorId);
        if (isset($doctor)) {
            $this->setDoctor($doctor);
        }
        $this->results->doctor = $this->doctor;
    }

    private function setDoctor(Doctor $model) {
        $data = new stdClass();
        $data->name = $model->getName();
        $data->deptName = $model->getHpDeptName();
        $data->hospitalName = $model->getHospitalName();
        $this->doctor = $data;
    }

}
