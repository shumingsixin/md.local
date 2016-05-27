<?php

class ApiViewDoctorPatientBookingList extends EApiViewService {

    private $creatorId;  // User.id
    private $patientMgr;
    private $patientBookings;  // array
    private $pagesize;
    private $page;

    //初始化类的时候将参数注入
    public function __construct($creatorId, $status, $pagesize = 100, $page = 1) {
        parent::__construct();
        $this->creatorId = $creatorId;
        $this->pagesize = $pagesize;
        $this->page = $page;
        $this->status = $status;
        $this->patientMgr = new PatientManager();
        $this->patientBookings = array();
    }

    protected function loadData() {
        // load PatientBooking by creatorId.
        $this->loadPatientBookings();
    }

    //返回的参数
    protected function createOutput() {
        if (is_null($this->output)) {
            $this->output = array(
                'status' => self::RESPONSE_OK,
                'errorCode' => 0,
                'errorMsg' => 'success',
                'results' => $this->patientBookings,
            );
        }
    }

    //调用model层方法
    private function loadPatientBookings() {
        $attributes = null;
        $with = array('pbPatient' => array('patientDAFiles'));
        $options = array('limit' => $this->pagesize, 'offset' => (($this->page - 1) * $this->pagesize), 'order' => 't.date_updated DESC');
        $models = $this->patientMgr->loadAllPatientBookingByCreatorId($this->creatorId, $this->status, $attributes, $with, $options);
        if (arrayNotEmpty($models)) {
            $this->setPatientBookings($models);
        }
    }

    public function loadCount() {
        return $this->patientMgr->loadPatientBookingNumberByCreatorId($this->creatorId, $this->status);
    }

    //查询到的数据过滤
    private function setPatientBookings(array $models) {
        foreach ($models as $model) {
            $data = new stdClass();
            $data->id = $model->getId();
            $data->refNo = $model->getRefNo();
            $data->travelType = $model->getTravelType();
            $data->status = $model->getStatus(false);
            $data->statusText = $model->getStatus();
            $data->isDepositPaid = $model->getIsDepositPaid();
            $data->dateUpdated = $model->getDateUpdated('m月d日');
            $patientInfo = $model->getPatient();
            if (isset($patientInfo)) {
                if ($model->status == PatientBooking::BK_STATUS_SERVICE_PAIDED) {
                    $files = $patientInfo->patientDAFiles;
                    $data->statusText = "待上传";
                    if (arrayNotEmpty($files)) {
                        $data->statusText = "待审核";
                    }
                }
                $data->patientId = $patientInfo->getId();
                $data->name = $patientInfo->getName();
                $data->dataCreate = $patientInfo->getDateCreated();
                $data->diseaseName = $patientInfo->getDiseaseName();
                $data->diseaseDetail = $patientInfo->getDiseaseDetail();
                $data->age = $patientInfo->getAge();
                $data->ageMonth = $patientInfo->getAgeMonth();
            }
            $data->actionUrl = Yii::app()->createAbsoluteUrl('/apimd/orderinfo/' . $model->getId());
            $this->patientBookings[] = $data;
        }
    }

}
