<?php

class TestController extends WebsiteController {

    public function actionUserlogin() {
        $url = $this->createAbsoluteUrl('api/create', array('model' => 'userlogin'));
        var_dump($url);

        $this->render('userlogin');
    }

    public function actionRegister() {
        //$url = $this->createAbsoluteUrl('api/create',array('model'=>'userregister'));

        $this->render('userRegister');
    }

    public function actionGetSmsCode($mobile = '11111111111', $type = 100) {
        $this->headerUTF8();
        $actionType = intval($type);
        $authMgr = new AuthManager();
        $smsVerify = $authMgr->createAuthSmsVerify($mobile, $actionType);
        if ($smsVerify->hasErrors()) {
            var_dump($smsVerify->getErrors());
        } else {
            echo 'mobile:        ' . $smsVerify->mobile . '<br>';
            echo 'action type:        ' . $smsVerify->action_type . '<br>';
            echo 'code:        ' . $smsVerify->code . '<br>';
        }
        exit;
    }

    public function actionSendSmsCode() {
        $this->render("sendSmsCode");
    }

    public function actionBooking($id = 321) {
        $userId = 3;
        $user = User::model()->getById($userId);
        $this->headerUTF8();
        $apisvc = new ApiViewBookingV4($user, $id);
        $output = $apisvc->loadApiViewData();

        var_dump($output);
    }

    public function actionAutologin($mobile) {
        $this->headerUTF8();
        $authMgr = new AuthManager();
        $output = $authMgr->apiTokenUserAutoLoginByMobile($mobile);
        var_dump($output);
    }

    public function actionTokenUsername($mobile = '11111111111', $token = '5871E9FC6E4167FB8A4E2576B08F477B') {
        $this->headerUTF8();
        $authMgr = new AuthManager();
        $output = $authMgr->authenticateUserByToken($mobile, $token);
        var_dump($output->hasSuccess());
        var_dump($output);
    }

    public function actionBookingfile($bid = null) {
        $this->headerUTF8();
        if (is_null($bid)) {
            echo 'missing parament: bid';
        }
        /*
         * else if ($this->isAjaxRequest()) {

          $file = EUploadedFile::getInstanceByName('bookingFile[file_data]');  // $_FILE['booking_file'].
          $output['post'] = $_POST;
          $output['uploadedFile'] = $file;

          $this->renderJsonOutput($output);
          } */ else if (isset($_POST['bookingFile'])) {
            $file = EUploadedFile::getInstanceByName('bookingFile[file_data]');  // $_FILE['booking_file'].
            $output['post'] = $_POST;
            $output['uploadedFile'] = $file;

            $this->renderJsonOutput($output);
        }
        $this->render("bookingFile", array('bid' => $bid));
        //$this->refresh();
    }

    public function actionCreateBooking() {

        $this->render('createBooking');
    }

    public function actionUserbookings($id = '36', $mobile = '99999999999') {

        $urls[] = $this->createAbsoluteUrl('api/list', array('model' => 'userbooking', 'username' => '13011114445', 'token' => '84B70D44C8AB4D25BB8E008A86E131C8'));
        $urls[] = $this->createAbsoluteUrl('api/view', array('model' => 'userbooking', 'id' => '141', 'username' => '13011114445', 'token' => '84B70D44C8AB4D25BB8E008A86E131C8'));
        $urls[] = $this->createAbsoluteUrl('api/list', array('model' => 'userbooking'));
        $urls[] = $this->createAbsoluteUrl('api/view', array('model' => 'userbooking', 'id' => 12));
        $urls[] = $this->createAbsoluteUrl("/mobile/app");
        var_dump($urls);
        /*
          $user = User::model()->getById($id);
          $bookingMgr = new BookingManager();
          $output = $bookingMgr->loadAllBookingsByUser($user, array('owner', 'bookingFiles'), array('limit' => 10, 'offset' => 5, 'order' => 't.id DESC'));
          var_dump(count($output));
          var_dump($output);
         */
        var_dump(Yii::app()->request);
        $bid = 143;
        $userid = 36;
        $user = User::model()->getById($userid);
        $bookingMgr = new BookingManager();
        // $ibooking = $bookingMgr->loadIBookingByUser($user, $bid);
        //$ibooking = $bookingMgr->loadAllIBookingsByUser($user);
        $ibooking = $bookingMgr->apiLoadAllIBookingsJsonByUser($user);

        var_dump($ibooking);
    }

    public function actionExpteamdata() {
        $output = array();
        $teamList = new ExpertTeamData();
        foreach ($teamList as $team) {
            //$output['expertTeams'][] = CJSON::encode($team);
            $output['expertTeams'][] = $team;
        }
        $this->renderJsonOutput($output);
    }

    public function actionBaseurl() {
        $url = Yii::app()->getBaseUrl(true);
        var_dump($url);
    }

    public function actionApi() {
        $output = null;
        $output = $this->createAbsoluteUrl('/mobiledoctor/home/index');

        var_dump($output);
    }

    public function actionDoctor($disease = null) {
        $this->headerUTF8();
        $dsearch = new DoctorSearch($_GET);
        $dsearch->addSearchCondition("t.date_deleted is NULL");
        $output = $dsearch->search();
        var_dump($output);
    }

    public function actionAuth() {
        //$user = Yii::app()->user;
        //var_dump($user->isPatient());
        $ret = User::model()->exists('username=:username AND role=:role', array(':username' => '18217531537', ':role' => 1));
        var_dump($ret);
    }

    public function actionDir() {
        $dir = time();
        $base = 'E:\test\\';
        $path = $base . $dir;
        var_dump($path);
        $ret = createDirectory($path);
        var_dump($ret);
    }

    public function actionLoadImage($id) {
        $file = PatientMRFile::model()->getById($id);
        $userId = $this->getCurrentUserId();
        // auth
        $fileMgr = new FileManager();
        $url = $fileMgr->loadFileaUrl($id);
        $this->renderImageOutput($url);




        //   echo $url;
    }

    public function actionImage() {
        $this->render('loadimage');
    }

    public function actionPatient() {
        $patientMgr = new PatientManager();
        $pid = '';
        $patient = $patientMgr->loadPatientMRById($pid);
        var_dump($patient);
    }

    public function actionEmail($id) {
        $booking = Booking::model()->getById($id);

        $data = new stdClass();
        $data->id = $booking->getId();
        $data->refNo = $booking->getRefNo();
        if ($booking->bk_type == StatCode::BK_TYPE_EXPERTTEAM) {
            $data->expertBooked = $booking->getExpertteamName();
        } elseif ($booking->bk_type == StatCode::BK_TYPE_DOCTOR) {
            $data->expertBooked = $booking->getDoctorName();
        } else {
            $data->expertBooked = $booking->getDoctorName();
        }
        $data->hospitalName = $booking->getHospitalName();
        $data->hpDeptName = $booking->getHpDeptName();
        $data->patientName = $booking->getContactName();
        $data->mobile = $booking->getMobile();
        $data->diseaseName = $booking->getDiseaseName();
        $data->diseaseDetail = $booking->getDiseaseDetail();
        $data->dateCreated = $booking->getDateCreated();
        $data->submitFrom = '';
        $emailMgr = new EmailManager();
        $ret = $emailMgr->sendEmailBookingNew($data);
        var_dump($ret);
    }

    public function actionFile() {
        $file = PatientMRFile::model()->getById(24);
        $url = $file->getAbsFileUrl();
        var_dump($url);
    }

    public function actionTeam($id) {
        $apisvc = new ApiViewExpertTeam($id);
        $output = $apisvc->loadApiViewData();
        var_dump($output);
    }

    public function actionPing() {
        $this->renderPartial('ping');
    }

    public function actionPingpay() {
        //    header('Access-Control-Allow-Origin:*');    // Cross-domain access.
        header('Content-Type: application/json; charset=utf-8');
        $domainUrl = 'http://md.mingyizhudao.com/';
        /*         *
         * Ping++ Server SDK
         * 说明：
         * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写, 并非一定要使用该代码。
         * 该代码仅供学习和研究 Ping++ SDK 使用，只是提供一个参考。
         */

        //require_once(dirname(__FILE__) . '/../init.php');
        require_once('protected/sdk/pingpp-php-master/init.php');
        $input_data = file_get_contents('php://input');
        $input_data = CJSON::decode($input_data);

        if (empty($input_data['channel']) || empty($input_data['amount']) || empty($input_data['order_no'])) {
            echo 'channel or amount is empty';
            exit();
        }
        $channel = strtolower($input_data['channel']);
        $amount = $input_data['amount'];
        $orderNo = $input_data['order_no'];
        $openId = isset($input_data['open_id']) ? $input_data['open_id'] : 'o9D7bsrlWC5ecKJdSuyVAYLedjVc';
        //$orderNo = isset($input_data['order_no']) ? $input_data['order_no'] : substr(md5(time()), 0, 12);
        // get Salestransaction by refNo.
        // create SalesPayment
        //$extra 在使用某些渠道的时候，需要填入相应的参数，其它渠道则是 array() .具体见以下代码或者官网中的文档。其他渠道时可以传空值也可以不传。
        $extra = array();
        switch ($channel) {
            case'alipay_pc_direct':
                $extra = array(
                    //'success_url' => $this->createAbsoluteUrl('test/pingreturn'),
                    'success_url' => $domainUrl . 'test.mingyizd.com/test/alipayreturn',
                        // 'success_url' => 'http://192.168.31.239/myzd/test/pingreturn',
                        // 'cancel_url' => 'http://www.yourdomain.com/cancel'
                );
                break;
            case 'alipay_wap':
                $extra = array(
                    'success_url' => $domainUrl . 'test/alipayreturn',
                    //'success_url' => 'http://192.168.31.239/myzd/test/pingreturn',
                    'cancel_url' => $domainUrl . 'test/alipaycancel'
                );
                break;
            case 'upmp_wap':
                $extra = array(
                    'result_url' => 'http://www.yourdomain.com/result?code='
                );
                break;
            case 'bfb_wap':
                $extra = array(
                    'result_url' => 'http://www.yourdomain.com/result?code=',
                    'bfb_login' => true
                );
                break;
            case 'upacp_wap':
                $extra = array(
                    'result_url' => 'http://www.yourdomain.com/result'
                );
                break;
            case 'wx_pub':
                $extra = array(
                    'open_id' => $openId
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
                    'identity_id' => '10012471338',
                    'identity_type' => 1,
                    'terminal_type' => 1,
                    'terminal_id' => 'your terminal_id',
                    'user_ua' => 'your user_ua',
                    'result_url' => $domainUrl . 'test/alipayreturn'
                );
                break;
            case 'jdpay_wap':
                $extra = array(
                    'success_url' => 'http://www.yourdomain.com',
                    'fail_url' => 'http://www.yourdomain.com',
                    'token' => 'dsafadsfasdfadsjuyhfnhujkijunhaf'
                );
                break;
        }

        //    \Pingpp\Pingpp::setApiKey('sk_test_W14qv9uPGuP4rbrnHKizLOaT');  // test key
        \Pingpp\Pingpp::setApiKey('sk_live_bLGCW9m1aX5KvTSeT04G0KyP');    // live key

        try {
            $ch = \Pingpp\Charge::create(
                            array(
                                'subject' => '支付测试',
                                'body' => '请认真完成此次测试',
                                'amount' => $amount,
                                'order_no' => $orderNo,
                                'currency' => 'cny',
                                'extra' => $extra,
                                'channel' => $channel,
                                'client_ip' => $_SERVER['REMOTE_ADDR'],
                                'app' => array('id' => 'app_SWv9qLSGWj1GKqbn')
                            )
            );
            echo $ch;
            CoreLogPayment::log($ch, CoreLogPayment::LEVEL_INFO, Yii::app()->request->url, __METHOD__);
            //  Yii::log($ch, CLogger::LEVEL_INFO, __METHOD__);
        } catch (\Pingpp\Error\Base $e) {
            header('Status: ' . $e->getHttpStatus());
            echo($e->getHttpBody());
            CoreLogPayment::log($e->getHttpBody(), CoreLogPayment::LEVEL_ERROR, Yii::app()->request->url, __METHOD__);
        }
    }

    /*
      public function actionGetWxOpenId2() {
      CoreLogPayment::log(Yii::app()->request->querystring, 'info', null, __METHOD__);
      if (isset($_GET['code'])) {

      $code = $_GET['code'];
      $wxAppId = 'wxb6dc36522aae7df2';
      $wxAppSecret = 'e70db8f5ea5baa991d71c0be3047b339';
      require_once('protected/sdk/pingpp-php-master/init.php');
      $openid = \Pingpp\WxpubOAuth::getOpenid($wxAppId, $wxAppSecret, $code);

      echo $openid;
      //$this->redirect('http://md.mingyizhudao.com/test/pingpp-html5-one/demo/demo.php?openid=' . $openid);
      } else {
      if (isset($_GET['refno'])) {
      $refno = $_GET['refno'];
      $redirectUrl = $this->createAbsoluteUrl("/test/getWxOpenId2", array("refno" => $refno));
      } else {
      $redirectUrl = $this->createAbsoluteUrl("/test/getWxOpenId2");
      }
      $wxAppId = 'wxb6dc36522aae7df2'; //@TODO: store in db.
      require_once('protected/sdk/pingpp-php-master/init.php');
      $url = \Pingpp\WxpubOAuth::createOauthUrlForCode($wxAppId, $redirectUrl);

      CoreLogPayment::log($url, 'info', null, __METHOD__);

      //   $requestUrl = $wxconfig->getUrlAccessToken();
      // send http get request to get access_token from weixin.
      //$ch = curl_init($url);
      //$ch = curl_init('http://localhost/myzd/mobiledoctor/wx/getUrlAccessToken');
      //$ch = curl_init('http://192.168.0.128/myzd/mobiledoctor/wx/getUrlAccessToken');
      //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取数据返回
      //curl_setopt($ch, CURLOPT_BINARYTRANSFER, true); // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
      //$output = curl_exec($ch);
      //var_dump($url);
      //var_dump($output);exit;
      header('Location: ' . $url);
      }
      }
     * 
     */

    public function actionGetWxCode() {
        $querystring = Yii::app()->request->querystring;
        $redirectUrl = $this->createAbsoluteUrl("/test/getWxOpenId");
        $redirectUrl.='?' . $querystring;
        //   $redirectUrl = urlencode($redirectUrl);
        $wxAppId = 'wxb6dc36522aae7df2'; //@TODO: store in db.
        require_once('protected/sdk/pingpp-php-master/init.php');
        $url = \Pingpp\WxpubOAuth::createOauthUrlForCode($wxAppId, $redirectUrl);
        //$url = \Pingpp\WxpubOAuth::createOauthUrlForCode($wxAppId, "");

        Yii::log('Redirect url:' . $url, 'info', null, __METHOD__);
        //echo $url;
        //header('Location: ' . $url);
        $this->redirect($url);
        // Yii::app()->end();
    }

    public function actionGetWxOpenId() {
        Yii::log('Querystring received: ' . Yii::app()->request->querystring, 'info', null, __METHOD__);

        $code = $_GET['code'];
        $wxAppId = 'wxb6dc36522aae7df2';
        $wxAppSecret = 'e70db8f5ea5baa991d71c0be3047b339';
        require_once('protected/sdk/pingpp-php-master/init.php');
        $openid = \Pingpp\WxpubOAuth::getOpenid($wxAppId, $wxAppSecret, $code);
        // $this->setSession('wx.openid', $openid);
        //$redirectUrl = 'http://md.mingyizhudao.com/test/pingpp-html5-one/demo/demo.php' . '?openid=' . $openid;
        /*
          if (isset($_GET['refno'])) {
          $refno = $_GET['refno'];
          //$redirectUrl.='&refno=' . $refno;
          }
         * 
         */
        //$redirectUrl = Yii::app()->request->getQuery('returnurl') . '&openid=' . $openid;
        $redirectUrl = urldecode($this->getReturnUrl('http://mingyizhudao.com')) . '&openid=' . $openid;

        //	$redirectUrl.='&'.Yii::app()->request->querystring;
        Yii::log('Redirect url: ' . $redirectUrl, 'info', null, __METHOD__);
        echo $openid;
        // $this->redirect($redirectUrl);
        // Yii::app()->end();
    }

    public function actionPingWebhook() {
        //$data = array();
        //  $data['get'] = $_GET;
        //  $data['post'] = $_POST;
        //$data['postJson']=file_get_contents('php://input');
        // $dataJson = CJSON::encode($data);
        $dataison = file_get_contents('php://input');
        $data = json_decode($dataison);

        if ($data->type == 'charge.succeeded') {
            echo '<h3>success</h3>';
            // update payment, order, payment data.
        } else {
            echo '<h3>fail</h3>';
            // update payment, payment data.
        }
        var_dump($data);
        Yii::log($dataison, CLogger::LEVEL_ERROR, __METHOD__);
        // echo 'Success';
        // var_dump($dataJson);
    }

    public function actionTestSms($mobile = 18217531537) {
        $smsMgr = new SmsManager();
        $data = new stdClass();
        $data->id = '925';
        $data->refno = 'PB151117100052';
        $data->expertBooked = '王小明';
        /*
          $data->refno='PB151117100052';
          $data->expertBooked='王小明';
          $ret=$smsMgr->sendSmsBookingSubmit($mobile, $data);
         */
        /*
          $data->refno = 'PB151117100052';
          $data->bookingId = '925';
          $data->bookingViewUrl = 'http://md.mingyizhudao.com/mobiledoctor/patientbooking/view/id/925';
          $ret = $smsMgr->sendSmsBookingAssignDoctor($mobile, $data);
         * 
         */

        $data->refno = 'PB151117100052';
        $data->amount = '500.00';
        //$ret = $smsMgr->sendSmsBookingDepositPaid($mobile, $data);
        $ret = $smsMgr->sendSmsBookingAssignDoctor($mobile, $data);
        var_dump($ret);
    }

    public function actionAgent() {
        $userAgent = strtolower(Yii::app()->request->getUserAgent());
        var_dump($userAgent);
    }

    public function actionUser() {
        $userSearch = new UserSearch($_GET);
        $ret = $userSearch->search();
        var_dump($userSearch->select);
        var_dump($ret);
    }

    public function actionAjaxUserSearch() {
        //$_GET['role'] = 2;
        //$userSearch = new UserSearch($_GET);
        //$ret = $userSearch->search();

        $apiSvc = new ApiViewUserSearch($_GET);
        $output = $apiSvc->loadApiViewData();
        $this->renderJsonOutput($output);
    }

    public function actionUserSearch() {
        $this->render("userSearch");
    }

    /**
     * 密码替换
     */
    public function actionHash() {
        $output = array();
        $models = AdminUser::model()->getAll();
        foreach ($models as $model) {
            if (strIsEmpty($model->password_raw)) {
                $password = rand(100001, 1000000);
                $model->password_raw = $password;
                $model->password = hash('sha256', $password);
                $model->update(array('password', 'password_raw'));
                $output[$model->id] = $password;
            }
        }
        $this->renderJsonOutput($output);
    }

    public function actionAdminBookingByBk() {
        $output = array();
        $criteria = new CDbCriteria();
        $criteria->join = ' LEFT JOIN sales_order s ON (s.bk_type= 1 AND s.bk_id = t.id)';
        $criteria->addCondition("s.is_paid = 1");
        $criteria->addCondition("s.final_amount > 1");
        $models = Booking::model()->findAll($criteria);
        if (arrayNotEmpty($models)) {
            $bookingMgr = new BookingManager();
            foreach ($models as $model) {
                $admin = $bookingMgr->createAdminBooking($model);
                if ($admin->hasErrors() == false) {
                    $output[] = $model->id;
                }
            }
        }
        $this->renderJsonOutput($output);
    }

    public function actionAdminBookingByPk() {
        $criteria = new CDbCriteria();
        $criteria->join = ' LEFT JOIN sales_order s ON (s.bk_type= 2 AND s.bk_id = t.id)';
        $criteria->addCondition("s.is_paid = 1");
        $criteria->addCondition("s.final_amount > 1");
        $criteria->addCondition("t.remark is NULL");
        $criteria->limit = 100;
        $models = PatientBooking::model()->findAll($criteria);
        if (arrayNotEmpty($models)) {
            $bookingMgr = new BookingManager();
            foreach ($models as $model) {
                $admin = $bookingMgr->createAdminBooking($model);
                if ($admin->hasErrors() == false) {
                    $model->remark = 1;
                    $model->update(array('remark'));
                    $output[] = $model->id;
                }
            }
        }
        $this->renderJsonOutput($output);
    }

}
