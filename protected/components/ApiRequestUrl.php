<?php

class ApiRequestUrl {

    public $hostInfoProd = 'http://admin.mingyizd.com';
    private $admin_salesbooking_create = 'api/adminbooking';
    private $doctor_task = 'api/taskuserdoctor';
    private $patientMr_task = 'api/taskpatientmr';

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

}
