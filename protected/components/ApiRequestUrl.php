<?php

class ApiRequestUrl {

    public $hostInfoProd = 'http://crm560.mingyizd.com';
    private $admin_salesbooking_create = 'api/adminbooking';
    private $doctor_task = 'api/taskuserdoctor';
    private $patientMr_task = 'api/taskpatientmr';
    private $doctor_accept = 'api/doctoraccept';
    private $pay = 'api/tasksalseorder';
    private $da_task = 'api/taskpatientda';
    private $finished = 'api/operationfinished';

    public function getHostInfo() {
        $hostInfo = strtolower(Yii::app()->request->hostInfo);
        if (strStartsWith($hostInfo, $this->hostInfoProd)) {
            $this->hostInfoProd = $hostInfo . '/admin';
        }
    }

    public function getUrl($url) {
        $this->getHostInfo();
        return $this->hostInfoProd . '/' . $url;
    }

    public function getUrlAdminSalesBookingCreate() {
        return $this->getUrl($this->admin_salesbooking_create);
    }

    public function getUrlDoctorInfoTask() {
        return $this->getUrl($this->doctor_task);
    }

    public function getUrlPatientMrTask() {
        return $this->getUrl($this->patientMr_task);
    }

    public function getUrlDoctorAccept() {
        return $this->getUrl($this->doctor_accept);
    }

    public function getUrlDaTask() {
        return $this->getUrl($this->da_task);
    }

    public function getUrlPay() {
        return $this->getUrl($this->pay);
    }

    public function getUrlFinished() {
        return $this->getUrl($this->finished);
    }

    public function send_get($url) {
        $result = file_get_contents($url, false);
        return json_decode($result, true);
    }

}
