<?php

class ApiViewPatientBooking extends EApiViewService {

    private $bookingId; // PatientBooking.id
    private $creatorId;
    private $patientId;
    private $userDoctorId;  //UserDoctorProfile.user_id
    private $viewerId;  // User.id
    private $modelBooking;  // PatientBooking model.
    private $modelCreator;  // User model.
    private $modelPatient;  // PatientInfo model.
    private $modelPatientMR;    // PatientMR model.
    private $modelUserDoctorProfile; //UserDoctorProfile model
    private $listModelMRFiles; // list of PatientMRFile models.
    private $patient;   // PatientInfo
    private $salesOrder;    //SalesOrder
    private $patientMR; // PatientMR
    private $mrfiles;
    private $creator;
    private $booking;   // PatientBooking
    private $patientMgr;
    private $userMgr;
    private $ordertMgr;

    public function __construct($bookingId, $viewerId = null) {
        parent::__construct();
        $this->bookingId = $bookingId;
        //    $this->userId = $viewerId;
        $this->patientMgr = new PatientManager();
        $this->userMgr = new UserManager();
        $this->ordertMgr = new OrderManager();
        $this->salesOrder = array();
    }

    protected function loadData() {
        // load PatientBooking.
        $this->loadBooking();
        // load creator - User model
        $this->loadCreator();
        // load PatientInfo.
        $this->loadPatient();
        // load PatientMR.
        //$this->loadPatientMR();
        // load PatientMRFiles
        $this->loadSalesOrder();
        $this->loadMRFiles();
    }

    protected function createOutput() {
        if (is_null($this->output)) {
            $this->output = array(
                'status' => self::RESPONSE_OK,
                'booking' => $this->booking,
                'creator' => $this->creator,
                'patient' => $this->patient,
                'patientMR' => $this->patientMR,
                'salesOrder' => $this->salesOrder,
                'mrfiles' => $this->mrfiles,
            );
        }
    }

    /**
     * call this method before loadPatient().
     * @throws CException
     */
    private function loadBooking() {
        if (is_null($this->modelBooking)) {
            $attributes = null;
            $this->modelBooking = $this->patientMgr->loadPatientBookingById($this->bookingId, $attributes);
        }
        if (is_null($this->modelBooking)) {
            $this->throwNoDataException();
        }
        $this->creatorId = $this->modelBooking->getCreatorId();
        $this->patientId = $this->modelBooking->getPatientId();
        $this->userDoctorId = $this->modelBooking->getDoctorId();
        $this->setBooking($this->modelBooking);
    }

    private function loadCreator() {
        if (is_null($this->creator)) {
            $with = array('userDoctorProfile');
            $this->modelCreator = $this->userMgr->loadUserById($this->creatorId, $with);
            if (isset($this->modelCreator)) {
                $this->setCreator($this->modelCreator);
            }
        }
    }

    /**
     * call this method only after loadBooking().
     */
    private function loadPatient() {
        if (is_null($this->modelPatient)) {
            $attributes = null;
            $this->modelPatient = $this->patientMgr->loadPatientInfoById($this->patientId, $attributes);
        }
        if (isset($this->modelPatient)) {
            $this->setPatient($this->modelPatient);
        }
    }

    /*
      private function loadPatientMR() {
      if (is_null($this->modelPatientMR)) {
      $attributes = null;
      $with = array('pmrFiles' => array('select' => array('id', 'uid', 'file_url', 'thumbnail_url', 'base_url')));
      $this->modelPatientMR = $this->patientMgr->loadPatientMRByPatientId($this->patientId, $attributes, $with);
      }

      if (isset($this->modelPatientMR)) {
      $this->setPatientMR($this->modelPatientMR);
      $this->listModelMRFiles = $this->modelPatientMR->getMRFiles();
      }
      }
     * 
     */

    private function loadMRFiles() {
        if (is_null($this->modelPatient)) {
            return false;
        } else {
            $attributes = null;
            $patientId = $this->modelPatient->getId();
            $this->listModelMRFiles = $this->patientMgr->loadPatientMRFilesByPatientId($patientId, $attributes);
        }
        if (arrayNotEmpty($this->listModelMRFiles)) {
            $this->setMRFiles($this->listModelMRFiles);
        }
    }

    //查询预约支付情况
    private function loadSalesOrder() {
        $bkType = StatCode::TRANS_TYPE_PB;
        $models = $this->ordertMgr->loadSalesOrderByBkIdAndBkType($this->bookingId, $bkType);
        if (arrayNotEmpty($models)) {
            $this->setSalesOrder($models);
        }
    }

    private function setBooking(PatientBooking $model) {
        $data = new stdClass();
        $data->id = $model->getId();
        $data->refNo = $model->getRefNo();
        $data->creatorId = $model->getCreatorId();
        $data->status = $model->getStatus();
        $data->statusCode = $model->getStatus(false);
        $data->travelType = $model->getTravelType();
        //    $data->travelTypeCode = $model->getTravelType(false);
        $data->dateStart = $model->getDateStart();
        $data->dateEnd = $model->getDateEnd();
        $data->detail = $model->getDetail(false);
        $data->apptDate = $model->getApptDate();
        $data->dateConfirm = $model->getDateConfirm();
        $data->remark = $model->getRemark(false);
        $data->dateCreated = $model->getDateCreated();
        $data->dateUpdated = $model->getDateUpdated('Y年m月d日 h:i');
        $data->dateNow = date('Y-m-d H:i', time());
        $this->booking = $data;
    }

    private function setCreator(User $model) {
        $data = new stdClass();
        $data->id = $model->getId();
        $data->mobile = $model->getMobile();
        $profile = $model->getUserDoctorProfile();  // UserDoctorProfile model.
        if (isset($profile)) {
            $data->name = $profile->getName();
            $data->hospitalName = $profile->getHospitalName();
            $data->hpDeptName = $profile->getHpDeptName();
            $data->cTitle = $profile->getClinicalTitle();
            $data->aTitle = $profile->getAcademicTitle();
        } else {
            $data->name = '';
            $data->hospitalName = '';
            $data->hpDeptName = '';
            $data->cTitle = '';
            $data->aTitle = '';
        }
        $this->creator = $data;
    }

    private function setPatient(PatientInfo $model) {
        $data = new stdClass();
        $data->id = $model->getId();
        $data->creatorId = $model->getCreatorId();
        $data->name = $model->getName();
        $data->mobile = $model->getMobile();
        $data->age = $model->getAge();
        $data->ageMonth = $model->getAgeMonth();
        $data->gender = $model->getGender();
        $data->placeState = $model->getStateName();
        $data->placeCity = $model->getCityName();
        $data->diseaseName = $model->getDiseaseName();
        $data->diseaseDetail = $model->getDiseaseDetail(true);
        $this->patient = $data;
    }

    private function setPatientMR(PatientMR $model) {
        $data = new stdClass();
        $data->id = $model->getId();
        $data->creatorId = $model->getCreatorId();
        $data->diseaseName = $model->getDiseaseName();
        $data->diseaseDetail = $model->getDiseaseDetail(false);
        //$data->diseaseDetail = $model->disease_detail;
        $data->remark = $model->getRemark(false);
        $this->patientMR = $data;
    }

    private function setMRFiles(array $models) {
        foreach ($models as $model) {
            $data = new stdClass();
            $data->id = $model->getId();
            $data->fileUrl = $model->getAbsFileUrl();
            $data->tnUrl = $model->getAbsThumbnailUrl();
            $this->mrfiles[] = $data;
        }
    }

    private function setSalesOrder(array $models) {
        foreach ($models as $model) {
            $data = new stdClass();
            $data->id = $model->getId();
            $data->refNo = $model->ref_no;
            $data->subject = $model->getSubject();
            $data->description = $model->getDescription();
            $data->finalAmount = $model->getFinalAmount();
            $data->isPaid = $model->getIsPaid(false);
            $this->salesOrder[] = $data;
        }
    }

}
