<?php

class ApiViewPatientBookingForDoctor extends EApiViewService {

    private $bkType;
    private $doctorId;
    private $id;
    private $patientMgr;
    private $booking;

    //初始化类的时候将参数注入

    public function __construct($id, $doctorId, $bkType) {
        parent::__construct();
        $this->id = $id;
        $this->bkType = $bkType;
        $this->doctorId = $doctorId;
        $this->patientMgr = new PatientManager();
    }

    protected function loadData() {
        if ($this->bkType == StatCode::TRANS_TYPE_PB) {
            $this->loadPatientBooking();
        } else {
            $this->loadBooking();
        }
        $this->results->booking = $this->booking;
    }

    //返回的参数
    protected function createOutput() {
        if (is_null($this->output)) {
            $this->output = array(
                'status' => self::RESPONSE_OK,
                'errorCode' => 0,
                'errorMsg' => 'success',
                'results' => $this->results
            );
        }
    }

    //调用model层方法
    private function loadPatientBooking() {
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
        $data->bkType = StatCode::TRANS_TYPE_PB;
        $data->expected_doctor = $model->getExpectedDoctor();
        $data->travelType = $model->getTravelType();
        $data->csExplain = $model->getCsExplain();
        $data->doctorOpinion = $model->getDoctorOpinion();
        $data->doctorAccept = $model->getDoctorAccept();
        $patient = $model->getPatient();
        if (isset($patient)) {
            $data->patientId = $model->getId();
            $data->patientName = $model->getName();
            $data->age = $model->getAge();
            $data->ageMonth = $model->getAgeMonth();
            $data->gender = $model->getGender();
            $data->placeState = $model->getStateName();
            $data->placeCity = $model->getCityName();
            $data->diseaseName = $model->getDiseaseName();
            $data->diseaseDetail = $model->getDiseaseDetail(true);
        }
        $this->booking = $data;
    }

    private function loadBooking() {
        $model = Booking::model()->getByIdAndDoctorUserId($this->id, $this->doctorId);
        if (isset($model)) {
            $data = new stdClass();
            $data->id = $model->getId();
            $data->bkType = StatCode::TRANS_TYPE_BK;
            $data->expected_doctor = $model->doctor_user_name;
            $data->csExplain = $model->getCsExplain();
            $data->doctorOpinion = $model->getDoctorOpinion();
            $data->doctorAccept = $model->getDoctorAccept();
            $data->patientName = $model->getContactName();
            $data->diseaseName = $model->getDiseaseName();
            $data->diseaseDetail = $model->getDiseaseDetail();
        }
        $this->booking = $data;
    }

}
