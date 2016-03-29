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

    public function loadUserByUsername($username) {
        return User::model()->getByUsername($username);
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

}
