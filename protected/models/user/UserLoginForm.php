<?php

class UserLoginForm extends EFormModel {

    public $username;
    public $password;
    public $rememberMe;
    public $duration = 2590222; // 30 days.
    //public $verifyCode;
    //public $role = User::ROLE_PATIENT;
    public $role;
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            //  array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements(), 'on' => 'withCaptcha', 'message' => '验证码不正确'), //only on withCaptcha scenario
            array('username, password', 'required', 'message' => '请输入{attribute}'), // username and password are required
            array('rememberMe', 'boolean'), // rememberMe needs to be a boolean
            array('password', 'authenticate'), // password needs to be authenticated
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'username' => Yii::t('user', '用户名'),
            'password' => Yii::t('user', '登录密码'),
            'rememberMe' => Yii::t('user', '下次记住我'),
                //  'verifyCode' => Yii::t('user', '验证码'),
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            $this->_identity = new UserIdentity($this->username, $this->password, $this->role);
            if ($this->_identity->authenticate() === false) {
                $errorCode = $this->_identity->errorCode;
                if ($errorCode == UserIdentity::ERROR_ACCOUNT_NOT_ACTIVATED) {
                    $url = Yii::app()->createAbsoluteUrl('user/resendActivation');
                    $this->addError('username', "您的帐号还没有激活。<br /><a href='$url'>现在去激活</a>");
                } elseif ($errorCode == UserIdentity::ERROR_USERNAME_INVALID) {
                    $this->addError('username', '该用户名不存在');
                } elseif ($errorCode == UserIdentity::ERROR_PASSWORD_INVALID) {
                    $this->addError('password', '登录密码不正确');
                } else {
                    $this->addError('password', '登录密码不正确');
                }
            }
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login() {
        if ($this->_identity === null) {
            $this->_identity = new UserIdentity($this->username, $this->password, $this->role);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
            $duration = $this->rememberMe ? $this->duration : 0; // 30 days
            Yii::app()->user->login($this->_identity, $duration);

            return true;
        } else
            return false;
    }

}
