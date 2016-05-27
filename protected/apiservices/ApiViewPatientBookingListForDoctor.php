<?php

class ApiViewPatientBookingListForDoctor extends EApiViewService {

    private $doctorId;  // User.id
    private $patientMgr;
    private $doneList;  // array
    private $processingList;  // array
    private $pagesize;
    private $page;

    //初始化类的时候将参数注入
    public function __construct($doctorId, $pagesize = 100, $page = 1) {
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
        $this->loadBookings();
        $this->listorder();
        $this->results->processingList = $this->processingList;
        $this->results->doneList = $this->doneList;
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
    }

    private function loadBookings() {
        $models = Booking::model()->getAllByDoctorUserId($this->doctorId);
        if (arrayNotEmpty($models)) {
            $this->setBookings($models);
        }
    }

    //查询到的数据过滤
    private function setPatientBookings(array $models) {
        foreach ($models as $model) {
            $data = new stdClass();
            $data->id = $model->getId();
            $data->bkType = StatCode::TRANS_TYPE_PB;
            $data->dateUpdated = $model->getDateUpdated('Y-m-d');
            $data->travelType = $model->getTravelType();
            $data->doctorAccept = $model->getDoctorAccept();
            $data->actionUrl = Yii::app()->createAbsoluteUrl('/apimd/doctorbooking/' . $model->getId());
            $patientInfo = $model->getPatient();
            if (isset($patientInfo)) {
                $data->name = $patientInfo->getName();
                $data->diseaseName = $patientInfo->getDiseaseName();
            } else {
                $data->name = '';
                $data->diseaseName = '';
                $data->diseaseDetail = '';
            }
            if (strIsEmpty($model->getDoctorAccept())) {
                $this->processingList[] = $data;
            } else {
                $this->doneList[] = $data;
            }
        }
    }

    private function setBookings(array $models) {
        foreach ($models as $model) {
            $data = new stdClass();
            $data->id = $model->getId();
            $data->bkType = StatCode::TRANS_TYPE_BK;
            $data->dateUpdated = $model->getDateUpdated('Y-m-d');
            $data->travelType = '';
            $data->name = $model->getContactName();
            $data->diseaseName = $model->getDiseaseName();
            $data->doctorAccept = $model->getDoctorAccept();
            $data->actionUrl = Yii::app()->createAbsoluteUrl('/apimd/doctorbooking/' . $model->getId());
            if (strIsEmpty($model->getDoctorAccept())) {
                $this->processingList[] = $data;
            } else {
                $this->doneList[] = $data;
            }
        }
    }

    private function listorder() {
        $processing = array();
        foreach ($this->processingList as $v) {
            $processing[] = $v->dateUpdated;
        }
        $done = array();
        foreach ($this->doneList as $v) {
            $done[] = $v->dateUpdated;
        }
        array_multisort($processing, SORT_DESC, $this->processingList);
        array_multisort($done, SORT_DESC, $this->doneList);
    }

}
