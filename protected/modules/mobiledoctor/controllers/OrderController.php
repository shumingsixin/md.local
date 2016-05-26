<?php

class OrderController extends MobiledoctorController {

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST requestf           
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('view', 'loadOrderPay', 'payResult'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('orderView', 'payOrders'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * In order to compromize wx-pub-pay(微信支付), if client browser is weixin webview, redirect to domain/weixin/pay.php.
     * So $order data will be saved in session at here.
     * @param type $refNo
     */
    public function actionView($refNo) {
        $apiSvc = new ApiViewSalesOrder($refNo);
        $output = $apiSvc->loadApiViewData();
        $returnUrl = $this->getReturnUrl("/mobiledoctor/order/view");

        if ($output->status == 'ok' && $this->isUserAgentWeixin()) {
            $requestUrl = Yii::app()->request->hostInfo . '/weixin/pay.php?' . http_build_query($_GET);
            $data = $output->results;

            // store order data in session, used by wx-pub-pay.

            if (isset($data->booking) && isset($data->booking->id)) {
                $returnUrl = $this->createAbosluteUrl('patientbooking/view', array('id' => $data->booking->id));
            } else {
                $returnUrl = $this->createAbsoluteUrl('doctor/view');
            }
            $data->returnUrl = $returnUrl;
            Yii::app()->session['order.data'] = $data;
            //Yii::app()->session['order.returnUrl'] = $returnUrl;
            //  var_dump(Yii::app()->session['order.returnUrl']);
            //  var_dump($data->booking);
            $this->redirect($requestUrl);
        } else {
            $this->render('view', array(
                'data' => $output,
                'returnUrl' => $returnUrl,
            ));
        }
    }

    /**
     * Loads order data from session.
     * Used by wx-pub-pay.
     * @param type $refNo
     */
    public function actionLoadOrderPay($refNo = null) {
        $output = new stdClass();
        if (isset(Yii::app()->session['order.data'])) {
            $data = Yii::app()->session['order.data'];
            $order = $data->salesOrder;
            $order->returnUrl = $data->returnUrl;
            //    unset(Yii::app()->session['order.data']);
            //    $output->returnUrl = Yii::app()->session['order.returnUrl'];            
            //    unset(Yii::app()->session['order.returnUrl']);
            if ($order->refNo != $refNo) {
                $output->status = 'no';
                $output->data = 'no data';
                $output->error = 'invalid request';
            } else {
                // get weixin openid.
                $wxMgr = new WeixinpubManager();
                $openid = $wxMgr->getStoredOpenId();
                $order->openid = $openid;
                $output->status = 'ok';
                $output->data = $order;
            }
            // exit;
        } else {
            $output->status = 'no';
            $output->data = 'no data';
            $output->error = 'invalid refNo';
        }
        $this->renderJsonOutput($output);
    }

    //支付单详情
    public function actionOrderView($bookingid) {
        $apiSvc = new ApiViewBookOrder($bookingid);
        $output = $apiSvc->loadApiViewData();
        $this->render('orderView', array(
            'data' => $output
        ));
    }

    //分批支付订单
    public function actionPayOrders($bookingId, $orderType) {
        $apiSvc = new ApiViewPayOrders($bookingId, $orderType);
        $output = $apiSvc->loadApiViewData();
        $this->render('payOrders', array(
            'data' => $output
        ));
    }

    public function actionPayResult($paymentcode) {
        $payment = SalesPayment::model()->getByAttributes(array('uid' => $paymentcode), array('paymentOrder'));
        $order = $payment->paymentOrder;
        if ($order === NULL) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        //支付成功 生成task提醒
        $apiurl = new ApiRequestUrl();
        $url = $apiurl->getUrlPay();
        $this->send_get($url);
        $this->show_header = true;
        $this->show_footer = false;
        $this->show_baidushangqiao = false;

        $this->render('payResult', array('order' => $order));
    }

}
