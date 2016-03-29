<?php

class UserDoctorMobileLoginForm extends EFormModel {

    public $username;
    public $duration = 7776000; // 90天
    public $verify_code;
    public $role;
    public $errorFormCode = MobileUserIdentity::ERROR_NONE;
    public $_identity;
    public $authSmsVerify;    // AuthSmsVerify model.
    public $autoRegister = false;   // 自动注册

    // public $userExists = false;     //用户是否存在

    const ERROR_VERIFYCODE_INVALID = 400;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('username, verify_code', 'required', 'message' => '请输入{attribute}'), // username and password are required
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'username' => Yii::t('user', '用户名'),
            'verify_code' => Yii::t('user', '验证码')
        );
    }

    public function authenticate() {
        if ($this->hasErrors() === false) {   // no validation error.            
            $this->verifyCodeForMobileLogin();
            if ($this->authSmsVerify->isValid() === false) {
                $this->errorFormCode = self::ERROR_VERIFYCODE_INVALID;
                $this->addError('verify_code', $this->authSmsVerify->getError('code'));
                return false;
            }
            $this->_identity = new MobileUserIdentity($this->username, $this->role);
            if ($this->_identity->authenticate() === false) {
                $this->errorFormCode = $this->_identity->errorCode;
                if ($this->errorFormCode == MobileUserIdentity::ERROR_ACCOUNT_NOT_ACTIVATED) {
                    $url = Yii::app()->createAbsoluteUrl('user/resendActivation');
                    $this->addError('username', "您的帐号还没有激活。<br /><a href='$url'>现在去激活</a>");
                } elseif ($this->errorFormCode == MobileUserIdentity::ERROR_USERNAME_INVALID) {
                    if ($this->autoRegister === false) {
                        $this->addError('username', '该用户名不存在');
                    }
                }
            } else {
                $this->errorFormCode = MobileUserIdentity::ERROR_NONE;
            }
        }
    }

    public function verifyCodeForMobileLogin() {
        $authMgr = new AuthManager();
        $userHostIp = null;
        $this->authSmsVerify = $authMgr->verifyCodeForMobileLogin($this->username, $this->verify_code, $userHostIp);
    }

}
