<?php

class ApiViewPatientBooking extends EApiViewService {

    private $bookingId;
    private $creatorId;
    private $patientMgr;
    private $booking;

    public function __construct($bookingId, $creatorId) {
        parent::__construct();
        $this->bookingId = $bookingId;
        $this->creatorId = $creatorId;
        $this->booking = null;
        $this->patientMgr = new PatientManager();
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
        $this->loadBooking();
    }

    private function loadBooking() {
        $model = $this->patientMgr->loadPatientBookingByIdAndCreatorId($this->id, $this->creatorId, null, array('pbPatient'));
        if (isset($model)) {
            $this->setPatientBooking($model);
        }
        $this->results->booking = $this->booking;
    }

    private function setBooking(PatientBooking $model) {
        $data = new stdClass();
        $data->id = $model->getId();
        $data->refNo = $model->getRefNo();
        $data->travelType = $model->getTravelType();
        $data->expected_doctor = $model->getExpectedDoctor();
        $data->detail = $model->getDetail(false);
        $patient = $model->getPatient();
        $data->patientId = $patient->getId();
        $data->patientName = $model->getName();
        $data->age = $model->getAge();
        $data->ageMonth = $model->getAgeMonth();
        $data->cityName = $model->getCityName();
        $data->gender = $model->getGender();
        $data->diseaseName = $model->getDiseaseName();
        $data->diseaseDetail = $model->getDiseaseDetail();
        $this->booking = $data;
    }

}
