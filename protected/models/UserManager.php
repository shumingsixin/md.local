<?php

class UserManager {

    public function createUserDoctor($mobile) {
        return $this->createUser($mobile, StatCode::USER_ROLE_DOCTOR);
    }

    public function createUserPatient($mobile) {
        return $this->createUser($mobile, StatCode::USER_ROLE_PATIENT);
    }

    /**
     * 创建用户
     * @param type $mobile
     * @param type $statCode
     */
    private function createUser($mobile, $statCode) {
        $model = new User();
        $model->scenario = 'register';
        $model->username = $mobile;
        $model->role = $statCode;
        $model->password_raw = strRandom(6);
        $model->terms = 1;
        $model->createNewModel();
        $model->setActivated();
        if ($model->save()) {
            return $model;
        }
        return null;
    }

    /*     * ****** Api 3.0 ******* */

    public function createUserDoctorCert($userId) {
        $uploadField = UserDoctorCert::model()->file_upload_field;
        $file = EUploadedFile::getInstanceByName($uploadField);
        if (isset($file)) {
            $output['filemodel'] = $this->saveUserDoctorCert($file, $userId);
        } else {
            $output['error'] = 'missing uploaded file.';
        }
        return $output;
    }

    public function createUserDoctorCerts($userId) {
        $uploadField = UserDoctorCert::model()->file_upload_field;
        $files = EUploadedFile::getInstancesByName($uploadField);
        if (isset($files)) {
            foreach ($files as $file) {
                $data[] = $this->saveUserDoctorCert($file, $userId);
            }
            $output['filemodel'] = $data;
        } else {
            $output['error'] = 'missing uploaded file in - ' . $uploadField;
        }
        return $output;
    }

    /**
     * Get EUploadedFile from $_FILE. 
     * Create DoctorCert model. 
     * Save file in filesystem. 
     * Save model in db.
     * @param EUploadedFile $file EUploadedFile::getInstances()
     * @param integer $doctorId Doctor.id     
     * @return DoctorCert 
     */
    private function saveUserDoctorCert($file, $userId) {
        //$dFile = new DoctorCert();
        $dFile = new UserDoctorCert();
        $dFile->initModel($userId, $file);
        $dFile->saveModel();

        return $dFile;
    }

    //医生信息查询
    public function loadUserDoctorProflieByUserId($userId, $attributes = null, $with = null) {
        return UserDoctorProfile::model()->getByUserId($userId, $attributes, $with);
    }

    //医生文件查询
    public function loadUserDoctorFilesByUserId($userId, $attributes = null, $with = null) {
        return UserDoctorCert::model()->getDoctorFilesByUserId($userId, $attributes, $with);
    }

    //异步删除医生证明图片
    public function delectDoctorCertByIdAndUserId($id, $userId, $absolute = false) {
        $output = array('status' => 'no');
        $model = UserDoctorCert::model()->getById($id);
        if (isset($model)) {
            if ($model->getUserId() != $userId) {
                $output['errorMsg'] = '权限';
            } else {
                if ($model->deleteModel($absolute)) {
                    $output['status'] = 'ok';
                } else {
                    $output['errors'] = $model->getErrors();
                }
            }
        } else {
            $output['errorMsg'] = 'no data';
        }
        $output = (object) $output;
        return $output;
    }

    //异步删除患者病历图片
    public function delectPatientMRFileByIdAndCreatorId($id, $creatorId, $absolute = false) {
        $output = array('status' => 'no');
        $model = PatientMRFile::model()->getById($id);
        if (isset($model)) {
            if ($model->getCreatorId() != $creatorId) {
                $output['errorMsg'] = '权限';
            } else {
                if ($model->deleteModel($absolute)) {
                    $output['status'] = 'ok';
                } else {
                    $output['errors'] = $model->getErrors();
                }
            }
        } else {
            $output['errorMsg'] = 'no data';
        }
        $output = (object) $output;
        return $output;
    }

    public function loadUserByUsername($username, $role = StatCode::USER_ROLE_DOCTOR) {
        return User::model()->getByUsernameAndRole($username, $role);
    }

    /**
     * 注册医生
     * @param type $username
     * @param type $password
     * @param type $terms
     * @return User $model.
     */
    public function doRegisterDoctor($username, $password, $terms = 1, $activate = 1) {
        // create new User model and save into db.
        $model = new User();
        $model->scenario = 'register';
        $model->username = $username;
        $model->role = StatCode::USER_ROLE_DOCTOR;
        $model->password_raw = $password;
        $model->terms = $terms;
        $model->createNewModel();
        if ($activate) {
            $model->setActivated();
        }
        $model->save();

        return $model;
    }

    /**
     * Login user.
     * @param UserLoginForm $form
     * @return type 
     */
    public function doLogin(UserLoginForm $form) {
        return ($form->validate() && $form->login());
    }

    /**
     * 手机用户登录
     * @param UserCerifyCodeLoginForm $form
     * @return type
     */
    public function mobileLogin(UserDoctorMobileLoginForm $form) {
        if ($form->validate()) {
            $form->authenticate();
            if ($form->autoRegister && $form->errorFormCode == MobileUserIdentity::ERROR_USERNAME_INVALID) {
                if ($form->role == StatCode::USER_ROLE_DOCTOR) {
                    $this->createUserDoctor($form->username);
                } elseif ($form->role == StatCode::USER_ROLE_PATIENT) {
                    $this->createUserPatient($form->username);
                }
                //之前有错误 user为null  再次验证
                $form->authenticate();
            }
            if ($form->errorFormCode == MobileUserIdentity::ERROR_NONE) {
                Yii::app()->user->login($form->_identity, $form->duration);
                return true;
            }
        }
        return false;
    }

    /**
     * Auto login user.
     * @param type $username
     * @param type $password
     * @param type $rememberMe
     * @return type 
     */
    public function autoLoginUser($username, $password, $role, $rememberMe = 0) {
        $form = new UserLoginForm();
        $form->username = $username;
        $form->password = $password;
        $form->role = $role;
        $form->rememberMe = $rememberMe;
        $this->doLogin($form);

        return $form;
    }

    public function registerNewUser(UserRegisterForm $form, $checkVerifyCode = true) {
        if ($form->validate()) {
            if ($checkVerifyCode) {
                // Verifies AuthSmsVerify by using $mobile & $verifyCode.  
                $userIp = Yii::app()->request->getUserHostAddress();

                $authMgr = new AuthManager();
                $authSmsVerify = $authMgr->verifyCodeForRegister($form->getUsername(), $form->getVerifyCode(), $userIp);
                if ($authSmsVerify->isValid() === false) {
                    $form->addError('verify_code', $authSmsVerify->getError('code'));
                    //$output['errors']['verifyCode'] = $authSmsVerify->getError('code');
                    return false;
                }
            }
            // create new User model and save into db.
            $model = new User();
            $model->username = $form->username;
            $model->password_raw = $form->password;
            $model->role = $form->role;
            $model->terms = $form->terms;
            $model->createNewModel();
            $model->setActivated();
            if ($model->save() === false) {
                $form->addErrors($model->getErrors());
            } elseif (isset($authSmsVerify)) {
                // deactive current smsverify.
                $authMgr->deActiveAuthSmsVerify($authSmsVerify);
            }
        }
        return ($form->getErrors() === false);
    }

    public function doChangePassword(UserPasswordForm $passwordForm) {
        $user = $passwordForm->getUser();
        if ($passwordForm->validate()) {
            if ($user->changePassword($passwordForm->getNewPassword()) === false) {
                $passwordForm->addErrors($user->getErrors());
            }
        }
        return ($passwordForm->hasErrors() === false);
    }

    public function validateCaptchaCode(UserRegisterForm $form) {
        $form->scenario = 'getSmsCode';
        return $form->validate();
    }

    public function doResetPassword($user, $userAction, $newPassword) {
        if ($user->changePassword($newPassword)) {
            // return $userAction->deActivateRecord();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Marks url as inactive at first access.
     * @param type $userId
     * @param type $uid
     * @return type boolean
     */
    public function validatePasswordResetAction($userId, $uid) {
        $user = User::model()->getById($userId);
        if (isset($user) && $user->isLocalAccount()) {
            $userAction = UserAuthAction::model()->getByUserIdAndUIDAndActionType($userId, $uid, UserAuthAction::ACTION_PASSWORD_RESET);
            if (isset($userAction) && $userAction->checkValidity(false)) {
                return $userAction;
            }
        }
        return null;
    }

    public function loadUserById($id, $with = null) {
        return User::model()->getById($id, $with);
    }

    public function loadUser($id, $with = null) {
        $model = User::model()->getById($id, $with);
        if (is_null($model)) {
            throw new CHttpException(404, 'Not found.');
        } else {
            return $model;
        }
    }

    /*     * *************************************************app使用方法********************************************************* */

    //医生注册
    public function apiTokenDoctorRegister($values) {
        $output = array('status' => 'no'); // default status is false.
        // TODO: wrap the following method. first, validates the parameters in $values.        
        if (isset($values['username']) === false || isset($values['password']) === false || isset($values['verify_code']) === false) {
            $output['status'] = EApiViewService::RESPONSE_NO;
            $output['errorCode'] = ErrorList::NOT_FOUND;
            $output['errorMsg'] = 'Wrong parameters.';
            return $output;
        }
        // assign parameters.
        $mobile = $values['username'];
        $password = $values['password'];
        $verifyCode = $values['verify_code'];
        $userHostIp = isset($values['userHostIp']) ? $values['userHostIp'] : null;
        $autoLogin = false;
        if (isset($values['autoLogin']) && $values['autoLogin'] == 1) {
            $autoLogin = true;
        }

        // Verifies AuthSmsVerify by using $mobile & $verifyCode.     手机验证码验证    
        $authMgr = new AuthManager();
        $authSmsVerify = $authMgr->verifyCodeForRegister($mobile, $verifyCode, $userHostIp);
        if ($authSmsVerify->isValid() === false) {
            $output['status'] = EApiViewService::RESPONSE_NO;
            $output['errorCode'] = ErrorList::NOT_FOUND;
            $output['errorMsg'] = $authSmsVerify->getError('code');
            return $output;
        }
        // Check if username exists.
        if (User::model()->exists('username=:username AND role=:role', array(':username' => $mobile, ':role' => StatCode::USER_ROLE_DOCTOR))) {
            $output['status'] = EApiViewService::RESPONSE_NO;
            $output['errorCode'] = ErrorList::NOT_FOUND;
            $output['errorMsg'] = '该手机号已被注册';
            return $output;
        }

        // success.
        // Creates a new User model.
        $user = $this->doRegisterDoctor($mobile, $password);
        if ($user->hasErrors()) {
            $output['status'] = EApiViewService::RESPONSE_NO;
            $output['errorCode'] = ErrorList::NOT_FOUND;
            $output['errorMsg'] = $user->getFirstErrors();
            return $output;
        } else if ($autoLogin) {
            $output['status'] = EApiViewService::RESPONSE_NO;
            $output['errorCode'] = ErrorList::NOT_FOUND;
            $output['errorMsg'] = $user->getFirstErrors();
            // auto login user and return token.            
            $output = $authMgr->doTokenDoctorLoginByPassword($mobile, $password, $userHostIp);
        } else {
            $output['status'] = EApiViewService::RESPONSE_OK;
            $output['errorCode'] = ErrorList::ERROR_NONE;
            $output['errorMsg'] = 'success';
            $output['results'] = [];
        }
        // deactive current smsverify.                
        if (isset($authSmsVerify)) {
            $authMgr->deActiveAuthSmsVerify($authSmsVerify);
        }

        return $output;
    }

    public function apiForgetPassword($values) {
        $output = array('status' => 'no', 'errorCode' => ErrorList::NOT_FOUND);
        $form = new ForgetPasswordForm();
        $form->attributes = $values;
        if ($form->validate()) {
            $user = $this->loadUserByUsername($form->username, StatCode::USER_ROLE_DOCTOR);
            if (isset($user)) {
                $success = $this->doResetPassword($user, null, $form->password_new);
                if ($success) {
                    $output['status'] = 'ok';
                    $output['errorCode'] = ErrorList::ERROR_NONE;
                    $output['errorsMsg'] = 'success';
                } else {
                    $output['errorsMsg'] = '密码修改失败';
                }
            } else {
                $output['errorMsg'] = '用户不存在';
            }
        } else {
            $output['errorMsg'] = '验证码错误';
        }
        return $output;
    }

    /**
     * api 创建或修改(id设值)医生个人信息
     * @param User $user
     * @param $values
     * @param null $id
     * @return mixed
     */
    public function apiCreateProfile(User $user, $values) {
        $userId = $user->getId();
        $model = UserDoctorProfile::model()->getByUserId($userId);
        $isupdate = true;
        if (is_null($model)) {
            $isupdate = false;
            $model = new UserDoctorProfile();
        }
        $model->setAttributes($values);
        // user_id.
        $model->user_id = $userId;
        $model->mobile = $user->getUsername();
        //给省会名 城市名赋值
        $regionState = RegionState::model()->getById($model->state_id);
        $model->state_name = $regionState->getName();
        $regionCity = RegionCity::model()->getById($model->city_id);
        $model->city_name = $regionCity->getName();
        if ($model->save()) {
            //信息修改成功 调用远程接口创建task
            if ($isupdate) {
                $type = StatCode::TASK_DOCTOR_CERT;
                $apiRequest = new ApiRequestUrl();
                //$remote_url = $apiRequest->getUrlAdminSalesBookingCreate() . "?userid={$userId}&type={$type}";
                //本地测试请用 
                $remote_url = "http://localhost/admin/api/taskuserdoctor?userid={$userId}&type={$type}";
                $apiRequest->send_get($remote_url);
            }
            $output['status'] = EApiViewService::RESPONSE_OK;
            $output['errorCode'] = ErrorList::ERROR_NONE;
            $output['errorMsg'] = 'success';
            $output['results'] = array(
                'id' => $model->getId(),
                'actionUrl' => Yii::app()->createAbsoluteUrl('/apimd/doctorinfo'),
            );
        } else {
            $output['status'] = EApiViewService::RESPONSE_NO;
            $output['errorCode'] = ErrorList::BAD_REQUEST;
            $output['errorMsg'] = $model->getFirstErrors();
        }
        return $output;
    }

}
