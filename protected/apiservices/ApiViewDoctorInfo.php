<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ApiViewDoctorInfo
 *
 * @author Administrator
 */
class ApiViewDoctorInfo extends EApiViewService {

    private $userId;    // User.id.
    private $userMgr;   // UserManager.
    private $doctorInfo;

    //初始化类的时候将参数注入
    public function __construct($userId) {
        parent::__construct();
        $this->userId = $userId;
        $this->doctorInfo = null;
        $this->userMgr = new UserManager();
    }

    protected function loadData() {
        // load PatientBooking by creatorId.
        $this->loadDoctorInfoById();
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

    private function loadDoctorInfoById() {
        $model = $this->userMgr->loadUserDoctorProflieByUserId($this->userId);
        if (isset($model)) {
            $this->setDoctorInfo($model);
        }
        $this->results->doctorInfo = $this->doctorInfo;
    }

    private function setDoctorInfo(UserDoctorProfile $model) {
        $data = new stdClass();
        $data->id = $model->getId();
        $data->name = $model->getName();
        if ($model->isVerified()) {
            $data->isVerified = 1;
        } else {
            $data->isVerified = 0;
            $certs = $this->userMgr->loadUserDoctorFilesByUserId($this->userId);
            $hasCerts = 0;
            if (arrayNotEmpty($certs)) {
                $hasCerts = 1;
            }
            $data->hasCerts = $hasCerts;
        }
        $data->stateName = $model->getStateName();    //省会
        $data->cityName = $model->getCityName();
        $data->hospitalName = $model->getHospitalName();
        $data->hpDeptName = $model->getHpDeptName();    //科室
        $data->cTitle = $model->getClinicalTitle();
        $data->aTitle = $model->getAcademictitle();
        $this->doctorInfo = $data;
    }

}
