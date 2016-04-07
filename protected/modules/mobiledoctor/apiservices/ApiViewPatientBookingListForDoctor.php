<?php

class ApiViewPatientBookingListForDoctor extends EApiViewService {

    private $doctorId;  // User.id
    private $patientMgr;
    private $doneList;  // array
    private $processingList;  // array
    private $pagesize = 10;
    private $page = 1;

    //初始化类的时候将参数注入
    public function __construct($doctorId, $pagesize = 10, $page = 1) {
        parent::__construct();
        $this->doctorId = $doctorId;
        $this->pagesize = $pagesize;
        $this->page = $page;
        $this->patientMgr = new PatientManager();
        $this->processingList = array(); //处理中
        $this->doneList = array(); //已完成
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
                'results' => $this->results,
            );
        }
    }

    //调用model层方法
    private function loadPatientBookings() {
        $attributes = null;
        $with = array('pbPatient');
        $options = array('limit' => $this->pagesize, 'offset' => (($this->page - 1) * $this->pagesize), 'order' => 't.date_updated DESC');
        $models = $this->patientMgr->loadPatientBookingListByDoctorId($this->doctorId, $attributes, $with, $options);
        if (arrayNotEmpty($models)) {
            $this->setPatientBookings($models);
        }
        $this->results->processingList = $this->processingList;
        $this->results->doneList = $this->doneList;
    }

    public function loadCount() {
        return $this->patientMgr->loadPatientBookingNumberByDoctorId($this->doctorId);
    }

    //查询到的数据过滤
    private function setPatientBookings(array $models) {
        foreach ($models as $model) {
            $data = new stdClass();
            $data->id = $model->getId();
            $data->refNo = $model->getRefNo();
            $data->status = $model->getStatus();
            $data->date_start = $model->getDateStart();
            $data->date_end = $model->getDateEnd();
            $data->dateUpdated = $model->getDateUpdated('Y-m-d');
            $data->travelType = $model->getTravelType();
            $patientInfo = $model->getPatient();
            if (isset($patientInfo)) {
                $data->patientId = $patientInfo->getId();
                $data->name = $patientInfo->getName();
                $data->dataCreate = $patientInfo->getDateCreated();
                $data->diseaseName = $patientInfo->getDiseaseName();
                $data->diseaseDetail = $patientInfo->getDiseaseDetail();
                $data->age = $patientInfo->getAge();
                $data->ageMonth = $patientInfo->getAgeMonth();
            } else {
                $data->patientId = '';
                $data->name = '';
                $data->dataCreate = '';
                $data->diseaseName = '';
                $data->diseaseDetail = '';
                $data->age = '';
                $data->ageMonth = '';
            }
            if ($model->getStatus(false) == PatientBooking::BK_STATUS_SURGER_DONE) {
                $this->doneList[] = $data;
            } else {
                $this->processingList[] = $data;
            }
        }
    }

}
