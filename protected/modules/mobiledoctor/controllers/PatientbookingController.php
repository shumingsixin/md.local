<?php

class PatientbookingController extends MobiledoctorController {

    private $model; // PatientBooking model.
    private $patient;   // PatientInfo model.

    public function filterPatientBookingContext($filterChain) {
        $bookingId = null;
        if (isset($_GET['id'])) {
            $bookingId = $_GET['id'];
        } elseif (isset($_POST['booking']['id'])) {
            $bookingId = $_POST['booking']['id'];
        }
        $this->loadModel($bookingId);
        $filterChain->run();
    }

    /**
     * @NOTE call this method after filterUserDoctorContext.
     * @param type $filterChain
     */
    public function filterPatientCreatorContext($filterChain) {
        $patientId = null;
        if (isset($_GET['pid'])) {
            $patientId = $_GET['pid'];
        } else if (isset($_POST['booking']['patient_id'])) {
            $patientId = $_POST['booking']['patient_id'];
        }

        $creator = $this->loadUser();

        $this->loadPatientInfoByIdAndCreatorId($patientId, $creator->getId());
        $filterChain->run();
    }

    public function filterUserContext($filterChain) {
        $user = $this->loadUser();
        if (is_null($user)) {
            $redirectUrl = $this->createUrl('doctor/mobileLogin');
            $currentUrl = $this->getCurrentRequestUrl();
            $redirectUrl.='?returnUrl=' . $currentUrl;
            $this->redirect($redirectUrl);
        }
        $filterChain->run();
    }

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
            'userDoctorContext + create',
            'patientCreatorContext + create',
            'userContext + list doctorPatientBookingList'
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
                'actions' => array('list', 'doctorPatientBookingList'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('view', 'create', 'ajaxCreate', 'update', 'list', 'doctorPatientBookingList', 'doctorPatientBooking', 'ajaxDoctorOpinion', 'ajaxBookingNum', 'ajaxOperation'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    //异步提交上级医生反馈
    public function actionAjaxDoctorOpinion($id, $type, $accept, $opinion) {
        $output = array('status' => 'no');
        $userId = $this->getCurrentUserId();
        if ($type == StatCode::TRANS_TYPE_PB) {
            $booking = PatientBooking::model()->getByAttributes(array('doctor_id' => $userId, 'id' => $id));
        } else {
            $booking = Booking::model()->getByIdAndDoctorUserId($id, $userId);
        }
        if (isset($booking)) {
            $booking->setDoctorAccept($accept);
            $booking->setDoctorOpinion($opinion);
            if ($booking->update(array('doctor_accept', 'doctor_opinion'))) {
                //医生评价成功 调用crm接口修改admin_booking的接口
                $urlMgr = new ApiRequestUrl();
                $url = $urlMgr->getUrlDoctorAccept() . "?id={$id}&type={$type}&accept={$accept}&opinion={$opinion}";
//                $url = "http://192.168.31.119/admin/api/doctoraccept?id={$id}&type={$type}&accept={$accept}&opinion={$opinion}";
                $this->send_get($url);
                $output['status'] = 'ok';
                $output['id'] = $booking->getId();
            } else {
                $output['errors'] = $booking->getErrors();
            }
        } else {
            $output['errors'] = 'no data..';
        }
        $this->renderJsonOutput($output);
    }

    public function actionView($id) {
        $userId = $this->getCurrentUserId();
        $apiSvc = new ApiViewPatientBooking($id, $userId);
        $output = $apiSvc->loadApiViewData();
        $this->render('view', array(
            'data' => $output
        ));
    }

    //各类订单数量
    public function actionAjaxBookingNum() {
        $userId = $this->getCurrentUserId();
        $apisvc = new ApiViewBookingCount($userId);
        $output = $apisvc->loadApiViewData();
        $this->renderJsonOutput($output);
    }

    //查询创建者的签约信息
    public function actionList($page = 1, $status = 0) {
        $user = $this->loadUser();
        $userId = $user->getId();
        $doctorProfile = $user->getUserDoctorProfile();
        $teamDoctor = 0;
        if (isset($doctorProfile)) {
            if ($doctorProfile->isVerified()) {
                if ($doctorProfile->isTermsDoctor() === false) {
                    $teamDoctor = 1;
                }
            }
        }
        $pagesize = 200;
        //service层
        $apisvc = new ApiViewDoctorPatientBookingList($userId, $status, $pagesize, $page);
        //调用父类方法将数据返回
        $output = $apisvc->loadApiViewData();
        $dataCount = $apisvc->loadCount();
        $this->render('bookinglist', array(
            'data' => $output, 'dataCount' => $dataCount, 'teamDoctor' => $teamDoctor
        ));
    }

    //查询预约该医生的预约列表
    public function actionDoctorPatientBookingList($page = 1) {
        $pagesize = 100;
        $doctorId = $this->getCurrentUserId();
        $apisvc = new ApiViewPatientBookingListForDoctor($doctorId, $pagesize, $page);
        //调用父类方法将数据返回
        $output = $apisvc->loadApiViewData();
        $this->render('doctorPatientBookingList', array(
            'data' => $output
        ));
    }

    //查询该医生的预约详情
    public function actionDoctorPatientBooking($id, $type = StatCode::TRANS_TYPE_PB) {
        $doctorId = $this->getCurrentUserId();
        $apiSvc = new ApiViewPatientBookingForDoctor($id, $doctorId, $type);
        $output = $apiSvc->loadApiViewData();
        $this->render('doctorPatientBookingView', array(
            'data' => $output
        ));
    }

    //下级医生确认手术完成
    public function actionAjaxOperation($id) {
        $output = array('status' => 'no');
        $userId = $this->getCurrentUserId();
        $booking = PatientBooking::model()->getByIdAndCreatorId($id, $userId);
        if (isset($booking)) {
            $booking->operation_finished = StatCode::OPERATION_FINISHED;
            if ($booking->update(array('operation_finished'))) {
                //远程调用接口
                $apiRequest = new ApiRequestUrl();
                //$url = 'http://192.168.1.216/admin/api/operationfinished?id={$id}';
                $url = $apiRequest->getUrlFinished() . "?id=" . $id;
                $this->send_get($url);
                $output['status'] = 'ok';
            } else {
                $output["errors"] = $booking->getErrors();
            }
        } else {
            $output["errors"] = 'no data...';
        }
        $this->renderJsonOutput($output);
    }

    public function actionCreate() {
        $user = $this->getCurrentUser();
        $doctorProfile = $user->getUserDoctorProfile();
        $userMgr = new UserManager();
        $certs = $userMgr->loadUserDoctorFilesByUserId($user->id);
        $doctorCerts = 0;
        if (arrayNotEmpty($certs)) {
            $doctorCerts = 1;
        }
        $userDoctorProfile = 0;
        if (isset($doctorProfile)) {
            $userDoctorProfile = 1;
        }
        $patient = $this->patient;
        $form = new PatientBookingForm();
        $form->initModel();
        //判断数据来源
        if ($this->isUserAgentWeixin()) {
            $form->user_agent = StatCode::USER_AGENT_WEIXIN;
        } else {
            $form->user_agent = StatCode::USER_AGENT_MOBILEWEB;
        }
        $form->setPatientId($patient->getId());
        $this->render('create', array(
            'model' => $form,
            'userDoctorProfile' => $userDoctorProfile,
            'doctorCerts' => $doctorCerts
        ));
    }

    public function actionAjaxCreate() {
        $post = $this->decryptInput();
        $output = array('status' => 'no');
        $bookingDB = null;
        if (isset($post['booking'])) {
            $values = $post['booking'];
            $patientId = null;
            $patientName = null;
            $patientMgr = new PatientManager();
            if (isset($values['patient_id'])) {
                $patientId = $values['patient_id'];
                $model = $patientMgr->loadPatientInfoById($patientId);
                if (isset($model)) {
                    $patientName = $model->getName();
                }
            }
            $user = $this->getCurrentUser();
            $userId = $user->getId();
            $createName = $user->getUsername();
            $userDoctorProfile = $user->getUserDoctorProfile();
            if (isset($userDoctorProfile)) {
                if (strIsEmpty($userDoctorProfile->getName()) === false) {
                    $createName = $userDoctorProfile->getName();
                }
            }
            $form = new PatientBookingForm();
            $form->setAttributes($values, true);
            $form->setPatientId($patientId);
            $form->patient_name = $patientName;
            $form->setCreatorId($userId);
            $form->creator_name = $createName;
            $form->setStatusNew();
            try {
                if ($form->validate() === false) {
                    $output['errors'] = $form->getErrors();
                    throw new CException('error saving data.');
                }
                $patientBooking = new PatientBooking();
                $patientBooking->setAttributes($form->attributes, true);
                if ($patientBooking->save() === false) {
                    $output['errors'] = $patientBooking->getErrors();
                    throw new CException('error saving data.');
                }
                $bookingDB = $patientBooking;
                $apiRequest = new ApiRequestUrl();
                $remote_url = $apiRequest->getUrlAdminSalesBookingCreate() . '?type=' . StatCode::TRANS_TYPE_PB . '&id=' . $patientBooking->id;
                //$remote_url = 'http://localhost/admin/api/adminbooking?type=' . StatCode::TRANS_TYPE_PB . '&id=' . $patientBooking->id;
                $data = $this->send_get($remote_url);
                if ($data['status'] == "ok") {
                    $output['status'] = 'ok';
                    $output['salesOrderRefNo'] = $data['salesOrderRefNo'];
                    $output['booking']['id'] = $patientBooking->getId();
                    $output['booking']['patientId'] = $patientBooking->getPatientId();
                    //发送提示短信
                    $this->sendSmsToCreator($patientBooking);
                } else {
                    throw new CException('error saving data.');
                }
            } catch (CException $cex) {
                $output['status'] = 'no';
                if (isset($bookingDB)) {
                    $bookingDB->delete(true);
                }
            }
        }
        $this->renderJsonOutput($output);
    }

    //保存支付信息
    public function initSalesOrder(PatientBooking $book) {
        $model = new stdClass();
        $model->refNo = $book->getRefNo();
        $model->id = $book->getId();
        $model->bk_type = StatCode::TRANS_TYPE_PB;
        $model->user_id = $book->creator_id;
        if ($book->getTravelType(false) == StatCode::BK_TRAVELTYPE_PATIENT_GO) {
            $model->subject = '预约金';
            $model->order_type = SalesOrder::ORDER_TYPE_DEPOSIT;
        } else {
            $model->subject = '服务费';
            $model->order_type = SalesOrder::ORDER_TYPE_SERVICE;
        }
        $model->description = '预约号:' . $book->getRefNo() . '。' . $book->getTravelType(true) . '所支付的' . $model->subject . '!';
        $model->amount = SalesOrder::ORDER_AMOUNT_DEPOSIT;

        $orderMgr = new OrderManager();
        $order = $orderMgr->initSalesOrder($model);
        return $order;
    }

    public function sendSmsToCreator($patientBooking) {
        $user = $this->getCurrentUser();
        $mobile = $user->getUsername();
        $smsMgr = new SmsManager();
        $data = new stdClass();
        $data->refno = $patientBooking->getRefNo();
        $doctor = $patientBooking->getDoctor();
        if (isset($doctor)) {
            $name = $doctor->name;
        } else {
            $name = '';
        }
        $data->expertBooked = $name;
        //发送提示的信息
        $smsMgr->sendSmsBookingSubmit($mobile, $data);
    }

    public function loadModel($id) {
        if (is_null($this->model)) {
            $this->model = PatientBooking::model()->getById($id);
            if (is_null($this->patient)) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
        }
        return $this->model;
    }

    private function loadPatientInfoByIdAndCreatorId($id, $creatorId) {
        if (is_null($this->patient)) {
            $this->patient = PatientInfo::model()->getByIdAndCreatorId($id, $creatorId);
            if (is_null($this->patient)) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
        }
        return $this->patient;
    }

}
