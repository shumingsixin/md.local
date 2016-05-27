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
        $with = array('pbPatient' => array('patientDAFiles'));
        $model = $this->patientMgr->loadPatientBookingByIdAndCreatorId($this->bookingId, $this->creatorId, null, $with);
        if (isset($model)) {
            $this->setBooking($model);
        }
        $this->results->booking = $this->booking;
    }

    private function setBooking(PatientBooking $model) {
        $data = new stdClass();
        $data->id = $model->getId();
        $data->refNo = $model->getRefNo();
        $data->travelType = $model->getTravelType();
        $data->expectedDoctor = $model->getExpectedDoctor();
        $data->detail = $model->getDetail(false);
        $patient = $model->getPatient();
        $data->patientId = $patient->getId();
        $data->patientName = $patient->getName();
        $data->age = $patient->getAge();
        $data->ageMonth = $patient->getAgeMonth();
        $data->cityName = $patient->getCityName();
        $data->gender = $patient->getGender();
        $data->diseaseName = $patient->getDiseaseName();
        $data->diseaseDetail = $patient->getDiseaseDetail();
        $this->booking = $data;
    }

}
