<?php

class ForgetPasswordForm extends EFormModel {

    public $username;
    public $verify_code;
    public $password_new;
    public $password_repeat;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            array('username, verify_code, password_new, password_repeat', 'required', 'message' => '请输入{attribute}'),
            array('password_new', 'length', 'min' => 4, 'max' => 40, 'tooShort' => '密码不可少于4个字母或数字', 'tooLong' => '密码不可多于40个字母或数字'),
            array('password_repeat', 'compare', 'compareAttribute' => 'password_new', 'message' => '新密码不匹配'),
            array('verify_code', 'checkVerifyCode'),
        );
    }

    public function checkVerifyCode() {
        if (isset($this->verify_code) && isset($this->username)) { 
            $authMgr = new AuthManager();
            $authSmsVerify = $authMgr->verifyCodeForPasswordReset($this->username, $this->verify_code, null);
            if ($authSmsVerify->isValid() === false) {
                $this->addError('verify_code', $authSmsVerify->getError('code'));
            }
        }
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return array(
            'username' => Yii::t('user', '用户名'),
            'verify_code' => Yii::t('user', '短信验证码'),
            'password_new' => Yii::t('user', '新密码'),
            'password_repeat' => Yii::t('user', '确认新密码')
        );
    }

    public function clearData() {
        $this->password = null;
        $this->password_new = null;
        $this->password_repeat = null;
    }

    /*     * ****** Accessors ******* */

    public function getNewPassword() {
        return $this->password_new;
    }

}
