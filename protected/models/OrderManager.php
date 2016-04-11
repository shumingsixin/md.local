<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OrderManager
 *
 * @author shuming
 */
class OrderManager {

    //查询预约单的支付情况
    public function loadSalesOrderByBkIdAndBkTypeAndOrderType($bkId, $bkType = StatCode::TRANS_TYPE_PB, $orderType = SalesOrder::ORDER_TYPE_DEPOSIT, $attributes = '*', $with = null, $options = null) {
        return SalesOrder::model()->getByBkIdAndBkTypeAndOrderType($bkId, $bkType, $orderType, $attributes, $with, $options);
    }

    //查询预约单的所有支付情况
    public function loadSalesOrderByBkIdAndBkType($bkId, $bkType = StatCode::TRANS_TYPE_PB, $attributes = '*', $with = null, $options = null) {
        return SalesOrder::model()->getByBkIdAndBkType($bkId, $bkType, $attributes, $with, $options);
    }

    //查询某订单的所有支付情况
    public function loadOrdersByBkIdAndBkTypeAndOrderType($bkId, $bkType = StatCode::TRANS_TYPE_PB, $orderType = SalesOrder::ORDER_TYPE_SERVICE) {
        return SalesOrder::model()->getAllByAttributes(array('bk_id' => $bkId, 'bk_type' => $bkType, 'order_type' => $orderType));
    }

}
