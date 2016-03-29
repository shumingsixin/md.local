<?php

/**
 * Description of salesTansactionManager
 *
 * @author Administrator
 */
class PayManager {

    public function doPingxxPay($refNo, $channel, $refurl, $openid='') {
        $pingCharge = null;
        $apisvs = new ApiViewSalesOrder($refNo);
        $output = $apisvs->loadApiViewData();
        
        $order = $output->results->salesOrder;
        $booking = $output->results->booking;
        if ($order === NULL) {
            //exception
            throw new CException('该订单-' . $refNo . ' 不存在');
        }
        $payment = new SalesPayment();
        $payment->initPaymentByOrder($order, $channel);
        $amount = intval($payment->getBillAmount() * 100);
        $orderNo = $payment->getUid();
        $subject = $order->subject;
        $body = $order->description;
        //获取手机号
        $yeepayIndentity = NULL;
        if ($channel == 'yeepay_wap') {
            if (isset($booking->mobile)) {
                $yeepayIndentity = array('id' => $booking->mobile, 'type' => 4);
            } else {
                $yeepayIndentity = array('id' => $refNo, 'type' => 6);
            }
        }
        $extra = $this->createPingxxExtra($payment, $channel, $refurl, $yeepayIndentity, $openid);
//        \Pingpp\Pingpp::setApiKey('sk_test_W14qv9uPGuP4rbrnHKizLOaT');  // Ping++ test key.
        \Pingpp\Pingpp::setApiKey('sk_live_bLGCW9m1aX5KvTSeT04G0KyP');  // Ping++ live key.

        $requestArray = array(
            'subject' => $subject,
            'body' => $body,
            'amount' => $amount,
            'order_no' => $orderNo,
            'currency' => 'cny',
            'extra' => $extra,
            'channel' => $channel,
            'client_ip' => $_SERVER['REMOTE_ADDR'],
            'app' => array('id' => 'app_SWv9qLSGWj1GKqbn')      // Ping++ app id.
        );
        if ($payment->save() === false) {
            //exception
            throw new CException($payment->getErrors());
        }

        $pingCharge = \Pingpp\Charge::create($requestArray);
        $payment->setPingChargeId($pingCharge['id']);
        $payment->update(array('ping_charge_id'));
        $paymentData = new SalesPaymentData();
        $paymentData->initFromPayment($payment, $pingCharge);
        if ($paymentData->save() === false) {
            throw new CException($paymentData->getErrors());
        }
        return $pingCharge;
    }

    public function createPingxxExtra(SalesPayment $payment, $channel, $refurl, $yeepayIndentity, $openid='') {
        //$extra 在使用某些渠道的时候，需要填入相应的参数，其它渠道则是 array() .具体见以下代码或者官网中的文档。其他渠道时可以传空值也可以不传。
        $extra = array();
        switch ($channel) {
            case 'alipay_pc_direct':
                $extra = array(
//                    'success_url' => 'http://test.mingyizd.com/payment/alipayReturn'  //test
                    'success_url' => 'http://www.mingyizhudao.com/payment/alipayReturn' //prod
                );
                break;
            case 'alipay_wap':
                $extra = array(
//                    'success_url' => 'http://test.mingyizd.com/payment/alipayReturn', //test
                    'success_url' => 'http://www.mingyizhudao.com/payment/alipayReturn', //prod
                    'cancel_url' => $refurl
                );
                break;
            case 'upmp_wap':
                $extra = array(
                    'result_url' => 'http://192.168.31.205/myzd/result?code='
                );
                break;
            case 'bfb_wap':
                $extra = array(
                    'result_url' => 'http://192.168.31.205/myzd/result?code=',
                    'bfb_login' => true
                );
                break;
            case 'upacp_wap':
                $extra = array(
                    'result_url' => 'http://192.168.31.205/myzd/result'
                );
                break;
            case 'wx_pub':
                $extra = array(
                    'open_id' => $openid
                );
                break;
            case 'wx_pub_qr':
                $extra = array(
                    'product_id' => 'Productid'
                );
                break;
            case 'yeepay_wap':
                $extra = array(
                    'product_category' => '51',
                    'identity_id' => $yeepayIndentity['id'],
                    'identity_type' => $yeepayIndentity['type'],
                    'terminal_type' => 3,
                    'terminal_id' => 'chuangxian10012471338',
                    'user_ua' => Yii::app()->request->getUserAgent(),
                    'result_url' => 'http://mingyizhudao.com/payment/yeepayReturn?outno=' . $payment->getUid()
                );
                break;
            case 'jdpay_wap':
                $extra = array(
                    'success_url' => 'http://192.168.31.205/myzd',
                    'fail_url' => 'http://192.168.31.205/myzd',
                    'token' => 'dsafadsfasdfadsjuyhfnhujkijunhaf'
                );
                break;
        }
        return $extra;
    }

    public function updateDataAfterTradeSuccess(SalesPayment $payment, $post) {
        $order = SalesOrder::model()->getById($payment->order_id);
        $paymentData = SalesPaymentData::model()->getByAttributes(array('payment_id' => $payment->id));
        $booking = null;
        if ($order->bk_type == 1) {
            $booking = Booking::model()->getById($order->bk_id);
        } else if ($order->bk_type == 2) {
            $booking = PatientBooking::model()->getById($order->bk_id);
        }
        if (isset($order) && isset($paymentData)) {
            $now = new CDbExpression('NOW()');
            $payment->setChannelTradeNo($post['data']['object']['transaction_no']);
            $payment->setPaymentStatus(1);
            $payment->setBuyerAccount(isset($post['data']['object']['extra']['buyer_account']) ? $post['data']['object']['extra']['buyer_account'] : "");
            $payment->setPaidAmount($post['data']['object']['amount'] / 100);
            $payment->setPaidDate($now);
            $payment->update();

            $order->setIsPaid(1);
            $order->setDateClosed($now);
            $order->setPingId($post['data']['object']['id']);
            $order->update();

            $paymentData->setReturnData(CJSON::encode($post));
            $paymentData->setDateReturn($now);
            $paymentData->update();

            $booking->is_deposit_paid = 1;
            $booking->update();
        }
    }

    public function updateDataAfterTradeFail(SalesPayment $payment) {
        $order = SalesOrder::model()->getById($payment->order_id);
        $paymentData = SalesPaymentData::model()->getByAttributes(array('payment_id' => $payment->id));
        if (isset($order) && isset($paymentData)) {
            $now = new CDbExpression('NOW()');
            $payment->setChannelTradeNo($post['data']['object']['transaction_no']);
            $payment->setPaymentStatus(2);
            $payment->update();
            $order->setIsPaid(0);
            $order->setDateClosed($now);
            $order->update();
            $paymentData->setReturnData(CJSON::encode($post));
            $paymentData->setDateReturn($now);
            $paymentData->setErrorCode(CJSON::encode($post));
            $paymentData->setErrorMsg(CJSON::encode($post));
            $paymentData->update();
        }
    }

}
