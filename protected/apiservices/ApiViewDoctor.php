<?php

class ApiViewDoctor extends EApiViewService {

    private $doctor_id;
    private $doctor;

    public function __construct($id) {
        parent::__construct();
        $this->doctor_id = $id;
        $this->doctor = null;
    }

    protected function loadData() {
        $this->loadDoctor();
    }

    protected function createOutput() {
        if (is_null($this->output)) {
            $this->output = array(
                'status' => self::RESPONSE_OK,
                'errorCode' => 0,
                "errorMsg" => "success",
                'results' => $this->results,
            );
        }
    }

    private function loadDoctor() {
        $doctor = Doctor::model()->getById($this->doctor_id);
        if (isset($doctor)) {
            $this->setDoctor($doctor);
        }
        $this->results->doctor = $this->doctor;
    }

    private function setDoctor(Doctor $model) {
        $data = new stdClass();
        $data->id = $model->getId();
        $data->name = $model->getName();
        $data->hospitalName = $model->getHospitalName();
        $data->mTitle = $model->getMedicalTitle();
        $data->aTitle = $model->getAcademicTitle();
        $data->imageUrl = $model->getAbsUrlAvatar();
        $data->hpDeptName = $model->getHpDeptName();
        $data->isContracted = $model->getIsContracted();
        $data->description = $model->getDescription();
        $data->careerExp = $model->getCareerExp();
        $data->honour = $model->getHonourList();
        $data->reasons = $model->getReasons();
        $this->doctor = $data;
    }

}
