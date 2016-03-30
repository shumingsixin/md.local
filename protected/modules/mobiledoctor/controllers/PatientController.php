<?php

class PatientController extends MobiledoctorController {

    private $patient;

    public function filterPatientContext($filterChain) {
        $patientId = null;
        if (isset($_GET['id'])) {
            $patientId = $_GET['id'];
        } else if (isset($_POST['patient']['id'])) {
            $patientId = $_POST['patient']['id'];
        }

        $this->loadPatientInfoById($patientId);

//complete the running of other filters and execute the requested action.
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
        } elseif (isset($_GET['id'])) {
            $patientId = $_GET['id'];
        } else if (isset($_POST['patient']['id'])) {
            $patientId = $_POST['patient']['id'];
        }
        $creator = $this->loadUser();

        $this->loadPatientInfoByIdAndCreatorId($patientId, $creator->getId());
        $filterChain->run();
    }

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
            'userDoctorContext + create ajaxCreate createPatientMR ajaxCreatePatientMR',
            'patientContext + createPatientMR updatePatientMR',
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
                'actions' => array(''),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'view', 'createPatientMR', 'updatePatientMR', 'createBooking', 'ajaxCreate', 'ajaxCreate', 'ajaxCreatePatientMR', 'ajaxUploadMRFile', 'delectPatientMRFile', 'patientMRFiles', 'list', 'uploadMRFile'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionAjaxCreate() {
        $output = array('status' => 'no');
        if (isset($_POST['patient'])) {
            $values = $_POST['patient'];
            $form = new PatientInfoForm();
            $form->setAttributes($values, true);
            $form->creator_id = $this->getCurrentUserId();
            $form->country_id = 1;  // default country is China.
            if ($form->validate()) {
                $patientMgr = new PatientManager();
                $patient = $patientMgr->loadPatientInfoById($form->id);
                if (isset($patient) === false) {
                    $patient = new PatientInfo();
                }
                $patient->setAttributes($form->attributes, true);
                $patient->setAge();
                $regionState = RegionState::model()->getById($patient->state_id);
                $patient->state_name = $regionState->getName();
                $regionCity = RegionCity::model()->getById($patient->city_id);
                $patient->city_name = $regionCity->getName();

                if ($patient->save()) {
                    $output['status'] = 'ok';
                    $output['patient']['id'] = $patient->getId();
                } else {
                    $output['errors'] = $patient->getErrors();
                }
            } else {
                $output['errors'] = $form->getErrors();
            }
        }
        $this->renderJsonOutput($output);
    }

    public function actionCreate() {
        $returnUrl = $this->getReturnUrl();
        $user = $this->loadUser();
        $doctorProfile = $user->getUserDoctorProfile();
        $teamDoctor = 0;
        if (isset($doctorProfile)) {
            if ($doctorProfile->isVerified()) {
                if ($doctorProfile->isTermsDoctor() === false) {
                    $teamDoctor = 1;
                }
            }
        }
        $form = new PatientInfoForm();
        $form->initModel();
        $this->render("createPatient", array(
            'model' => $form,
            'teamDoctor' => $teamDoctor,
            'returnUrl' => $returnUrl
        ));
    }

    //病人疾病信息更新加载
    public function actionUpdatePatientMR($id) {
        $patient = $this->loadPatientInfoById($id);
        $form = new PatientInfoForm();
        $form->initModel($patient);
        $this->render('updatePatientMR', array(
            'model' => $form
        ));
    }

    /**
     * 病人用户补全图片 type为是创建还是修改 返回不同的页面
     */
    public function actionUploadMRFile($id) {
        $returnUrl = $this->getReturnUrl($this->createUrl('patientbooking/create'));
        $url = 'updateMRFile';
        if ($this->isUserAgentIOS()) {
            $url .= 'Ios';
        } else {
            $url .= 'Android';
        }
        $this->render($url, array(
            'output' => array('id' => $id, 'returnUrl' => $returnUrl)
        ));
    }

    private function loadPatientInfoById($id) {
        if ($this->patient === null) {
            $this->patient = PatientInfo::model()->getById($id);
            if ($this->patient === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $this->patient;
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

    //异步删除患者病历图片
    public function actionDelectPatientMRFile($id) {
        $userId = $this->getCurrentUserId();
        $userMgr = new UserManager();
        $output = $userMgr->delectPatientMRFileByIdAndCreatorId($id, $userId);
        $this->renderJsonOutput($output);
    }

    //异步加载病人病历图片
    public function actionPatientMRFiles($id) {
        $userId = $this->getCurrentUserId();
        $apisvc = new ApiViewFilesOfPatient($id, $userId);
        $output = $apisvc->loadApiViewData();
        $this->renderJsonOutput($output);
    }

    //我的患者列表信息查询
    public function actionList($page = 1) {
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
        $pagesize = 100;
        //service层
        $apisvc = new ApiViewDoctorPatientList($userId, $pagesize, $page);
        //调用父类方法将数据返回
        $output = $apisvc->loadApiViewData();

        $dataCount = $apisvc->loadCount();
        $this->render('list', array(
            'data' => $output, 'dataCount' => $dataCount, 'teamDoctor' => $teamDoctor
        ));
    }

    public function actionSearch($name) {
        $userId = $this->getCurrentUserId();
        $apisvc = new ApiViewPatientSearch($userId, $name);
        $output = $apisvc->loadApiViewData();
        $this->render('list', array(
            'data' => $output
        ));
    }

    //我的患者详情
    public function actionView($id) {
        $userId = $this->getCurrentUserId();
        //service层
        $apisvc = new ApiViewDoctorPatientInfo($id, $userId);
        //调用父类方法将数据返回
        $output = $apisvc->loadApiViewData();
        $this->render('view', array(
            'data' => $output
        ));
    }

}
