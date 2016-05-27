<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ApiViewPayOrders
 *
 * @author shuming
 */
class ApiViewPayOrders extends EApiViewService {

    private $bookingId;
    private $type;
    private $orderMgr;
    private $orderList;

    public function __construct($bookingId, $type) {
        parent::__construct();
        $this->bookingId = $bookingId;
        $this->type = $type;
        $this->orderMgr = new OrderManager();
        $this->orderList = array();
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
        $this->loadPayOrders();
    }

    private function loadPayOrders() {
        $models = $this->orderMgr->loadOrdersByBkIdAndBkTypeAndOrderType($this->bookingId, StatCode::TRANS_TYPE_PB, $this->type);
        if (arrayNotEmpty($models)) {
            $this->setOrder($models);
        }
        $this->results->orders = $this->orderList;
    }

    private function setOrder($models) {
        foreach ($models as $model) {
            $data = new stdClass();
            $data->id = $model->getId();
            $data->refNo = $model->ref_no;
            $data->orderTypeText = $model->getOrderType();
            $data->orderType = $model->getOrderType(false);
            $data->finalAmount = $model->getFinalAmount();
            $data->isPaidText = $model->getIsPaid();
            $data->isPaid = $model->getIsPaid(false);
            $data->actionUrl = Yii::app()->createAbsoluteUrl('/apimd/orderview');
            $this->orderList[] = $data;
        }
    }

}
