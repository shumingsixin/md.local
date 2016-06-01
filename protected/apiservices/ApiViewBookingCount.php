<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ApiViewBookingCount
 *
 * @author shuming
 */
class ApiViewBookingCount extends EApiViewService {

    private $creatorId;  // User.id
    private $patientMgr;
    private $info;  // array

    //初始化类的时候将参数注入

    public function __construct($creatorId) {
        parent::__construct();
        $this->creatorId = $creatorId;
        $this->patientMgr = new PatientManager();
        $this->info = array('0' => 0, '1' => 0, '2' => 0, '5' => 0, '6' => 0);
    }

    protected function loadData() {
        // load PatientBooking by creatorId.
        $this->loadBookingCount();
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

    private function loadBookingCount() {
        $models = $this->patientMgr->loadCountByStatus($this->creatorId);
        if (arrayNotEmpty($models)) {
            $this->setCount($models);
        }
        $this->results->info = $this->info;
    }

    private function setCount($models) {
        $sum = 0;
        foreach ($models as $value) {
            $this->info[$value->status] = $value->id + 0;
            $sum+= $value->id;
        }
        $this->info["0"] = $sum;
    }

}
