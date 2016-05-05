
<?php

class DoctorController extends MobiledoctorController {

    public $defaultAction = 'view';
    private $model; // Doctor model
    private $patient;   // PatientInfo model
    private $patientMR; // PatientMR model

    public function filterUserDoctorProfileContext($filterChain) {
        $user = $this->loadUser();
        $user->userDoctorProfile = $user->getUserDoctorProfile();
        if (isset($user->userDoctorProfile) === false) {
            $redirectUrl = $this->createUrl('profile', array('addBackBtn' => 1));
            $currentUrl = $this->getCurrentRequestUrl();
            $redirectUrl.='?returnUrl=' . $currentUrl;
            $this->redirect($redirectUrl);
        }
        $filterChain->run();
    }

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
     * @NOTE call this method after filterUserDoctorContext.
     * @param type $filterChain
     */
    public function filterPatientMRCreatorContext($filterChain) {
        $mrid = null;
        if (isset($_GET['mrid'])) {
            $mrid = $_GET['mrid'];
        } elseif (isset($_POST['patientbooking']['mrid'])) {
            $mrid = $_POST['patientbooking']['mrid'];
        }
        $user = $this->loadUser();
        $this->loadPatientMRByIdAndCreatorId($mrid, $user->getId());
        $filterChain->run();
    }

    /**
     * 修改医生信息
     * @param type $filterChain
     */
    public function filterUserDoctorVerified($filterChain) {
        $user = $this->loadUser();
        $doctorProfile = $user->getUserDoctorProfile();
        if (isset($doctorProfile)) {
            if ($doctorProfile->isVerified()) {
                $output = array('status' => 'no', 'error' => '您已通过实名认证,信息不可以再修改。');
                if (isset($_POST['plugin'])) {
                    echo CJSON::encode($output);
                    Yii::app()->end(200, true); //结束 返回200
                } else {
                    $this->renderJsonOutput($output);
                }
            }
        }
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
            'postOnly + delete', // we only allow deletion via POST requestf           
            'userDoctorContext + profile ajaxProfile createPatient ajaxCreatePatient createPatientMR createBooking account',
            'patientContext + createPatientMR',
            'patientCreatorContext + createBooking',
            'userDoctorProfileContext + contract uploadCert',
            'userDoctorVerified + delectDoctorCert ajaxUploadCert ajaxUploadCert ajaxProfile',
            'userContext + viewContractDoctors'
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
                'actions' => array('register', 'ajaxRegister', 'mobileLogin', 'forgetPassword', 'ajaxForgetPassword', 'getCaptcha', 'valiCaptcha', 'viewContractDoctors', 'ajaxLogin'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('logout', 'changePassword', 'createPatientBooking', 'ajaxContractDoctor', 'ajaxStateList', 'ajaxDeptList', 'viewDoctor', 'addPatient', 'view', 'profile', 'ajaxProfile', 'ajaxUploadCert', 'doctorInfo', 'doctorCerts', 'account', 'delectDoctorCert', 'uploadCert', 'updateDoctor', 'toSuccess', 'contract', 'ajaxContract', 'sendEmailForCert', 'ajaxViewDoctorZz', 'createDoctorZz', 'ajaxDoctorZz', 'ajaxViewDoctorHz', 'createDoctorHz', 'ajaxDoctorHz', 'drView', 'ajaxDoctorTerms', 'doctorTerms'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    //进入查看签约医生的界面
    public function actionViewContractDoctors() {
        $this->render("viewContractDoctors");
    }

    //获取签约医生
    public function actionAjaxContractDoctor() {
        $values = $_GET;
        $apiService = new ApiViewDoctorSearch($values);
        $output = $apiService->loadApiViewData();
        $this->renderJsonOutput($output);
    }

    //获取城市列表
    public function actionAjaxStateList() {
        $city = new ApiViewState();
        $output = $city->loadApiViewData();
        $this->renderJsonOutput($output);
    }

    //获取科室分类
    public function actionAjaxDeptList() {
        $apiService = new ApiViewDiseaseCategory();
        $output = $apiService->loadApiViewData();
        $this->renderJsonOutput($output);
    }

    //获取医生信息
    public function actionViewDoctor($id) {
        $apiService = new ApiViewDoctor($id);
        $output = $apiService->loadApiViewData();
        $this->render("viewDoctor", array(
            'data' => $output
        ));
    }

    //添加患者
    public function actionAddPatient($id) {
        $apiService = new ApiViewDoctor($id);
        $doctor = $apiService->loadApiViewData();
        //查看患者列表
        $userId = $this->getCurrentUserId();
        $apisvc = new ApiViewDoctorPatientList($userId, 100, 1);
        //调用父类方法将数据返回
        $patientList = $apisvc->loadApiViewData();
        $this->render("addPatient", array(
            'doctorInfo' => $doctor,
            'patientList' => $patientList
        ));
    }

    //跳转至就诊意向页面
    public function actionCreatePatientBooking($doctorId, $patientId) {
        $apiService = new ApiViewDoctor($doctorId);
        $doctor = $apiService->loadApiViewData();
        $userId = $this->getCurrentUserId();
        $apisvc = new ApiViewDoctorPatientInfo($patientId, $userId);
        $patient = $apisvc->loadApiViewData();
        $form = new PatientBookingForm();
        $this->render("addPatientBooking", array(
            'model' => $form,
            'doctorInfo' => $doctor,
            'patientInfo' => $patient
        ));
    }

    /**
     * 进入专家协议页面
     */
    public function actionDoctorTerms() {
        $user = $this->getCurrentUser();
        $doctorProfile = $user->getUserDoctorProfile();
        $teamDoctor = 0;
        if (isset($doctorProfile)) {
            if ($doctorProfile->isTermsDoctor()) {
                $teamDoctor = 1;
            }
        }
        $returnUrl = $this->getReturnUrl($this->createUrl('doctor/view'));
        $this->render("doctorTerms", array(
            'teamDoctor' => $teamDoctor,
            'returnUrl' => $returnUrl
        ));
    }

    /**
     * 专家协议同意
     */
    public function actionAjaxDoctorTerms() {
        $output = array('status' => 'no');
        $user = $this->getCurrentUser();
        $doctorProfile = $user->getUserDoctorProfile();
        if (isset($doctorProfile)) {
            $doctorProfile->date_terms_doctor = date('Y-m-d H:i:s');
            if ($doctorProfile->update(array('date_terms_doctor'))) {
                $output['status'] = 'ok';
                $output['id'] = $doctorProfile->getId();
            } else {
                $output['error'] = $doctorProfile->getErrors();
            }
        } else {
            $output['error'] = 'no data..';
        }
        $this->renderJsonOutput($output);
    }

    //进入医生问卷调查页面
    public function actionContract() {
        $this->render("contract");
    }

    public function actionDrView() {
        $this->render("drView");
    }

    //医生查看自己能接受病人的转诊信息
    public function actionAjaxViewDoctorZz() {
        $userId = $this->getCurrentUserId();
        $apiSvc = new ApiViewDoctorZz($userId);
        $output = $apiSvc->loadApiViewData();
        $this->renderJsonOutput($output);
    }

    //进入保存或修改医生转诊信息的页面
    public function actionCreateDoctorZz() {
        $userId = $this->getCurrentUserId();
        $doctorMgr = new MDDoctorManager();
        $model = $doctorMgr->loadUserDoctorZhuanzhenByUserId($userId);
        $form = new DoctorZhuanzhenForm();
        $form->initModel($model);
        $this->render("createDoctorZz", array(
            'model' => $form
        ));
    }

    //保存或修改医生接受病人转诊信息
    public function actionAjaxDoctorZz() {
        $output = array('status' => 'no');
        $userId = $this->getCurrentUserId();
        if (isset($_POST['DoctorZhuanzhenForm'])) {
            $values = $_POST['DoctorZhuanzhenForm'];
            $values['user_id'] = $userId;
            $doctorMgr = new MDDoctorManager();
            $output = $doctorMgr->createOrUpdateDoctorZhuanzhen($values);
            //专家签约
            $user = $this->loadUser();
            $doctorProfile = $user->getUserDoctorProfile();
            $doctorMgr->doctorContract($doctorProfile);
        } elseif (isset($_POST['disjoin']) && $_POST['disjoin'] == UserDoctorZhuanzhen::ISNOT_JOIN) {
            $doctorMgr = new MDDoctorManager();
            $output = $doctorMgr->disJoinZhuanzhen($userId);
        }
        $this->renderJsonOutput($output);
    }

    //医生查看自己接受的会诊信息
    public function actionAjaxViewDoctorHz() {
        $userId = $this->getCurrentUserId();
        $apiSvc = new ApiViewDoctorHz($userId);
        $output = $apiSvc->loadApiViewData();
        //若该用户未填写则进入填写页面
        $this->renderJsonOutput($output);
    }

    //进入保存或修改医生会诊 信息的页面
    public function actionCreateDoctorHz() {
        $userId = $this->getCurrentUserId();
        $doctorMgr = new MDDoctorManager();
        $model = $doctorMgr->loadUserDoctorHuizhenByUserId($userId);
        $form = new DoctorHuizhenForm();
        $form->initModel($model);
        $this->render("createDoctorHz", array(
            'model' => $form
        ));
    }

    //保存或修改医生会诊信息
    public function actionAjaxDoctorHz() {
        $userId = $this->getCurrentUserId();
        $output = array('status' => 'no');
        if (isset($_POST['DoctorHuizhenForm'])) {
            $values = $_POST['DoctorHuizhenForm'];
            $values['user_id'] = $userId;
            $doctorMgr = new MDDoctorManager();
            $output = $doctorMgr->createOrUpdateDoctorHuizhen($values);
            //专家签约
            $user = $this->loadUser();
            $doctorProfile = $user->getUserDoctorProfile();
            $doctorMgr->doctorContract($doctorProfile);
        } elseif (isset($_POST['disjoin']) && $_POST['disjoin'] == UserDoctorZhuanzhen::ISNOT_JOIN) {
            $doctorMgr = new MDDoctorManager();
            $output = $doctorMgr->disJoinHuizhen($userId);
        }
        $this->renderJsonOutput($output);
    }

    public function actionAccount() {
        $user = $this->loadUser();
        $doctorProfile = $user->getUserDoctorProfile();
        $userMgr = new UserManager();
        $models = $userMgr->loadUserDoctorFilesByUserId($user->id);
        $doctorCerts = 0;
        $userDoctorProfile = 0;
        $verified = 0;
        if (arrayNotEmpty($models)) {
            $doctorCerts = 1;
        }
        if (isset($doctorProfile)) {
            $userDoctorProfile = 1;
            if ($doctorProfile->isVerified()) {
                $verified = 1;
            }
        }
        $this->render('account', array('userDoctorProfile' => $userDoctorProfile, 'verified' => $verified, 'doctorCerts' => $doctorCerts));
    }

    //医生信息查询
    public function actionDoctorInfo() {
        $user = $this->loadUser();
        $doctorProfile = $user->getUserDoctorProfile();
        $isVerified = false;
        if (isset($doctorProfile)) {
            $isVerified = $doctorProfile->isVerified();
        }
        $userId = $user->getId();
        $apisvc = new ApiViewDoctorInfo($userId);
        $output = $apisvc->loadApiViewData();

        $this->render('doctorInfo', array(
            'data' => $output, 'isVerified' => $isVerified,
        ));
    }

    //修改密码
    public function actionChangePassword() {
        $user = $this->getCurrentUser();
        $form = new UserPasswordForm('new');
        $form->initModel($user);
        $this->performAjaxValidation($form);
        if (isset($_POST['UserPasswordForm'])) {
            $form->attributes = $_POST['UserPasswordForm'];
            $userMgr = new UserManager();
            $success = $userMgr->doChangePassword($form);
            if ($this->isAjaxRequest()) {
                if ($success) {
                    //do anything here
                    echo CJSON::encode(array(
                        'status' => 'true'
                    ));
                    Yii::app()->end();
                } else {
                    $error = CActiveForm::validate($form);
                    if ($error != '[]') {
                        echo $error;
                    }
                    Yii::app()->end();
                }
            } else {
                if ($success) {
                    // $this->redirect(array('user/account'));
                    $this->setFlashMessage('user.password', '密码修改成功！');
                }
            }
        }
        $this->render('changePassword', array(
            'model' => $form
        ));
    }

    //个人中心
    public function actionView() {
        // var_dump(Yii::app()->user->id);exit;
        $user = $this->loadUser();  // User model
        $profile = $user->getUserDoctorProfile();   // UserDoctorProfile model
        $data = new stdClass();
        $data->id = $user->getId();
        $data->mobile = $user->getMobile();
        $userMgr = new UserManager();
        $models = $userMgr->loadUserDoctorFilesByUserId($user->id);
        $doctorCerts = false;
        if (arrayNotEmpty($models)) {
            $doctorCerts = true;
        }
        $data->doctorCerts = $doctorCerts;
        if (isset($profile)) {
            $data->isProfile = true;
            $data->name = $profile->getName();
            //是否是签约医生
            $data->verified = $profile->isVerified();
            $data->teamDoctor = $profile->isTermsDoctor();
        } else {
            $data->isProfile = false;
            $data->name = $user->getMobile();
            $data->verified = false;
            $data->teamDoctor = false;
        }
        $this->render('view', array(
            'user' => $data
        ));
    }

    public function actionAjaxContract() {
        //需要发送电邮的数据
        $data = new stdClass();
        $user = $this->loadUser();
        $doctorProfile = $user->getUserDoctorProfile();
        $data->oldPreferredPatient = $doctorProfile->preferred_patient;
        $output = array('status' => 'no');
        $form = new DoctorContractForm();
        $form->initModel($doctorProfile);
        $data->scenario = $form->scenario;
        if (isset($_POST['DoctorContractForm'])) {
            $values = $_POST['DoctorContractForm'];
            $form->setAttributes($values);
            if ($form->validate()) {
                $doctorProfile->setAttributes($form->attributes);
                if ($doctorProfile->save(true, array('preferred_patient', 'date_contracted', 'date_updated'))) {
                    $data->dateUpdated = date('Y-m-d H:i:s');
                    $data->doctorProfile = $doctorProfile;
                    //判断信息是修改还是保存 发送电邮
                    $emailMgr = new EmailManager();
                    $emailMgr->sendEmailDoctorUpateContract($data);
                    $output['status'] = 'ok';
                    $output['salesOrder']['id'] = $doctorProfile->getId();
                } else {
                    $output['errors'] = $doctorProfile->getErrors();
                }
            } else {
                $output['errors'] = $form->getErrors();
            }
        } else {
            $output['error'] = 'invalid request';
        }
        $this->renderJsonOutput($output);
    }

    //上传成功页面跳转
    public function actionToSuccess() {
        $this->render('_success');
    }

    /**
     * 医生上传认证全部成功 添加任务
     */
    public function actionSendEmailForCert() {
        $userId = $this->getCurrentUserId();
        $type = StatCode::TASK_DOCTOR_CERT;
        $apiUrl = new ApiRequestUrl();
        $url = $apiUrl->getUrlDoctorInfoTask() . "?userid={$userId}&type={$type}";
        //本地测试请用 $remote_url="http://192.168.31.119/admin/api/taskuserdoctor?userid={$userId}&type={$type}";
        $this->send_get($url);
    }

    public function actionAjaxProfile() {
        $output = array('status' => 'no');
        if (isset($_POST['doctor'])) {
            $values = $_POST['doctor'];
            $form = new UserDoctorProfileForm();
            $form->setAttributes($values, true);
            $form->initModel();
            if ($form->validate() === false) {
                $output['status'] = 'no';
                $output['errors'] = $form->getErrors();
                $this->renderJsonOutput($output);
            }
            $regionMgr = new RegionManager();
            $user = $this->loadUser();
            $userId = $user->getId();
            $doctorProfile = $user->getUserDoctorProfile();
            $isupdate = true;
            if (is_null($doctorProfile)) {
                $doctorProfile = new UserDoctorProfile();
                $isupdate = false;
            }
            $attributes = $form->getSafeAttributes();
            $doctorProfile->setAttributes($attributes, true);
            $doctorProfile->user_id = $userId;
            $doctorProfile->setMobile($user->username);
            $state = $regionMgr->loadRegionStateById($doctorProfile->state_id);
            if (isset($state)) {
                $doctorProfile->state_name = $state->getName();
            }
            $city = $regionMgr->loadRegionCityById($doctorProfile->city_id);
            if (isset($city)) {
                $doctorProfile->city_name = $city->getName();
            }
            if ($doctorProfile->save()) {
                if ($isupdate) {
                    $this->createTaskProfile($userId);
                }
                $output['status'] = 'ok';
                $output['doctor']['id'] = $doctorProfile->getUserId();
                $output['doctor']['profileId'] = $doctorProfile->getId();
                $output['doctor']['teamsDoctor'] = $doctorProfile->isTermsDoctor();
                $output['doctor']['verifiedDoctor'] = $doctorProfile->isVerified();
            } else {
                $output['status'] = 'no';
                $output['errors'] = $doctorProfile->getErrors();
            }
        }
        $this->renderJsonOutput($output);
    }

    //修改医生认证信息添加task
    public function createTaskProfile($userId) {
        $type = StatCode::TASK_DOCTOR_PROFILE_UPDATE;
        $apiRequest = new ApiRequestUrl();
        $remote_url = $apiRequest->getUrlAdminSalesBookingCreate() . "?userid={$userId}&type={$type}";
        //本地测试请用 $remote_url="http://192.168.31.119/admin/api/taskuserdoctor?userid={$userId}&type={$type}";
        $this->send_get($remote_url);
    }

    public function actionProfile($register = 0) {
        $user = $this->loadUser();
        $doctorProfile = $user->getUserDoctorProfile();
        $form = new UserDoctorProfileForm();
        $form->initModel($doctorProfile);
        $form->terms = 1;
        $returnUrl = $this->getReturnUrl($this->createUrl('doctor/doctorInfo'));
        $userMgr = new UserManager();
        $certs = $userMgr->loadUserDoctorFilesByUserId($user->id);
        if (arrayNotEmpty($certs) === false) {
            $returnUrl = $this->createUrl('doctor/uploadCert');
        }
        $this->render('profile', array(
            'model' => $form,
            'returnUrl' => $returnUrl,
            'register' => $register,
        ));
    }

    /**
     * @DELETE
     */
    public function actionCreatePatient() {
        $this->redirect(array('patient/create'));
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->user->loginUrl);
    }

    /**
     * 手机用户登录
     */
    public function actionMobileLogin($loginType = 'sms') {
        $user = $this->getCurrentUser();
        //已登陆 跳转至主页
        if (isset($user)) {
            $this->redirect(array('view'));
        }
        $smsform = new UserDoctorMobileLoginForm();
        $pawform = new UserLoginForm();
        $smsform->role = StatCode::USER_ROLE_DOCTOR;
        $pawform->role = StatCode::USER_ROLE_DOCTOR;
        $returnUrl = $this->getReturnUrl($this->createUrl('doctor/view'));
        //失败 则返回登录页面
        $this->render("mobileLogin", array(
            'model' => $smsform,
            'pawModel' => $pawform,
            'returnUrl' => $returnUrl,
            'loginType' => $loginType
        ));
    }

    /**
     * 异步登陆
     */
    public function actionAjaxLogin() {
        $output = array('status' => 'no');
        if (isset($_POST['UserDoctorMobileLoginForm'])) {
            $loginType = 'sms';
            $smsform = new UserDoctorMobileLoginForm();
            $values = $_POST['UserDoctorMobileLoginForm'];
            $smsform->setAttributes($values, true);
            $smsform->role = StatCode::USER_ROLE_DOCTOR;
            $smsform->autoRegister = false;
            $userMgr = new UserManager();
            $isSuccess = $userMgr->mobileLogin($smsform);
        } else if (isset($_POST['UserLoginForm'])) {
            $loginType = 'paw';
            $pawform = new UserLoginForm();
            $values = $_POST['UserLoginForm'];
            $pawform->setAttributes($values, true);
            $pawform->role = StatCode::USER_ROLE_DOCTOR;
            $pawform->rememberMe = true;
            $userMgr = new UserManager();
            $isSuccess = $userMgr->doLogin($pawform);
        } else {
            $output['errors'] = 'no data..';
        }
        if ($isSuccess) {
            $output['status'] = 'ok';
        } else {
            if ($loginType == 'sms') {
                $output['errors'] = $smsform->getErrors();
            } else {
                $output['errors'] = $pawform->getErrors();
            }
            $output['loginType'] = $loginType;
        }
        $this->renderJsonOutput($output);
    }

    /**
     * 医生补全图片
     */
    public function actionUploadCert() {
        $user = $this->loadUser();
        $doctorProfile = $user->getUserDoctorProfile();
        $isVerified = false;
        if (isset($doctorProfile)) {
            $isVerified = $doctorProfile->isVerified();
        }
        $id = $user->getId();
        $viewFile = 'uploadCert';
        if ($this->isUserAgentIOS()) {
            $viewFile .= 'Ios';
        } else {
            $viewFile .= 'Android';
        }
        $this->render($viewFile, array(
            'output' => array('id' => $id, 'isVerified' => $isVerified)
        ));
    }

    /**
     * 主页进入修改医生信息页面
     */
    public function actionUpdateDoctor() {
        $user = $this->loadUser();
        $doctorProfile = $user->getUserDoctorProfile();
        $form = new UserDoctorProfileForm();
        $form->initModel($doctorProfile);
        $form->terms = 1;
        $this->render('updateDoctor', array(
            'model' => $form,
        ));
    }

    //医生注册并自动登录
    public function actionRegister() {
        $userRole = User::ROLE_DOCTOR;
        $form = new UserRegisterForm();
        $form->role = $userRole;
        $form->terms = 1;
        $this->render('register', array(
            'model' => $form,
        ));
    }

    public function actionAjaxRegister() {
        $userRole = User::ROLE_DOCTOR;
        $output = array('status' => 'no');
        if (isset($_POST['RegisterForm'])) {
            $form = new UserRegisterForm();
            $form->attributes = $_POST['RegisterForm'];
            $userMgr = new UserManager();
            $userMgr->registerNewUser($form);
            if ($form->hasErrors() === false) {
                $userMgr->autoLoginUser($form->username, $form->password, $userRole, 1);
                $output['status'] = 'ok';
                $output['register'] = '1';
            } else {
                $output['errors'] = $form->getErrors();
            }
        }
        $this->renderJsonOutput($output);
    }

    //进入忘记密码页面
    public function actionForgetPassword() {
        $form = new ForgetPasswordForm();
        $this->render('forgetPassword', array(
            'model' => $form,
        ));
    }

    //忘记密码功能
    public function actionAjaxForgetPassword() {
        $output = array('status' => 'no');
        $form = new ForgetPasswordForm();
        if (isset($_POST['ForgetPasswordForm'])) {
            $form->attributes = $_POST['ForgetPasswordForm'];
            if ($form->validate()) {
                $userMgr = new UserManager();
                $user = $userMgr->loadUserByUsername($form->username, StatCode::USER_ROLE_DOCTOR);
                if (isset($user)) {
                    $success = $userMgr->doResetPassword($user, null, $form->password_new);
                    if ($success) {
                        $output['status'] = 'ok';
                    } else {
                        $output['errors']['errorInfo'] = '密码修改失败!';
                    }
                } else {
                    $output['errors']['username'] = '用户不存在';
                }
            } else {
                $output['errors'] = $form->getErrors();
            }
        }

        $this->renderJsonOutput($output);
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
