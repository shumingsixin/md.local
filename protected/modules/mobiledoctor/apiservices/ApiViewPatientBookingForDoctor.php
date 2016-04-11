<?php

class ApiViewPatientBookingForDoctor extends EApiViewService {

    private $doctorId;
    private $id;
    private $patientMgr;
    private $patientBooking;
    private $patientInfo;

    //初始化类的时候将参数注入

    public function __construct($id, $doctorId) {
        parent::__construct();
        $this->id = $id;
        $this->doctorId = $doctorId;
        $this->patientMgr = new PatientManager();
    }

    protected function loadData() {
        // load PatientBooking by doctorId.
        $this->loadPatientBookings();
    }

    //返回的参数
    protected function createOutput() {
        if (is_null($this->output)) {
            $this->output = array(
                'status' => self::RESPONSE_OK,
                'errorCode' => 0,
                'errorMsg' => 'success',
                'results' => array('patientBooking' => $this->patientBooking, 'patientInfo' => $this->patientInfo),
            );
        }
    }

    //调用model层方法
    private function loadPatientBookings() {
        $attributes = null;
        $with = array('pbPatient');
        $model = $this->patientMgr->loadPatientBookingByIdAndDoctorId($this->id, $this->doctorId, $attributes, $with);
        if (isset($model)) {
            $this->setPatientBooking($model);
        }
    }

    //查询到的数据过滤
    private function setPatientBooking(PatientBooking $model) {
        $data = new stdClass();
        $data->id = $model->getId();
        $data->refNo = $model->getRefNo();
        $data->creatorId = $model->getCreatorId();
        $data->status = $model->getStatus();
        $data->statusCode = $model->getStatus(false);
        $data->expected_doctor = $model->getExpectedDoctor();
        $data->travelType = $model->getTravelType();
        $data->detail = $model->getDetail(false);
        $data->dateCreated = $model->getDateCreated();
        $data->dateUpdated = $model->getDateUpdated('Y年m月d日 h:i');
        $data->csExplain = $model->getCsExplain();
        $data->doctorOpinion = $model->getDoctorOpinion();
        $data->doctorAccept = $model->getDoctorAccept();
        $patient = $model->getPatient();
        if (isset($patient)) {
            $this->setPatient($patient);
        } else {
            $this->patientInfo = null;
        }
        $this->patientBooking = $data;
    }

    private function setPatient(PatientInfo $model) {
        $data = new stdClass();
        $data->id = $model->getId();
        $data->creatorId = $model->getCreatorId();
        $data->name = $model->getName();
        $data->age = $model->getAge();
        $data->ageMonth = $model->getAgeMonth();
        $data->gender = $model->getGender();
        $data->placeState = $model->getStateName();
        $data->placeCity = $model->getCityName();
        $data->diseaseName = $model->getDiseaseName();
        $data->diseaseDetail = $model->getDiseaseDetail(true);
        $this->patientInfo = $data;
    }

}
