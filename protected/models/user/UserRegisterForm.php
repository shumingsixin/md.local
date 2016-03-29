<?php

class UserRegisterForm extends EFormModel {

    public $role;
    public $username;
    public $password;
    public $password_repeat;
    public $verify_code;    // 短信验证码
    public $captcha_code;   // 图形验证码
    public $terms;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, password, password_repeat', 'required', 'message' => '请输入{attribute}', 'except' => 'getSmsCode'),
            array('username', 'length', 'is' => 11, 'message' => '请输入正确的11位中国手机号码', 'except' => 'getSmsCode'),
            array('username', 'numerical', 'integerOnly' => true, 'message' => '请输入正确的11位中国手机号码', 'except' => 'getSmsCode'),
            array('username', 'checkUnique'),
            array('password', 'length', 'min' => 4, 'max' => 40, 'tooShort' => '最短为4个字母或数字', 'except' => 'getSmsCode'),
            array('password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => '{attribute}不正确', 'except' => 'getSmsCode'),
            array('terms', 'compare', 'compareValue' => 1, 'message' => '请同意{attribute}', 'except' => 'getSmsCode'),
            array('username', 'required', 'message' => '请输入{attribute}', 'on' => 'getSmsCode'),
            array('verify_code', 'required', 'message' => '请输入{attribute}'),
            array('verify_code', 'length', 'is' => 6, 'message' => '{attribute}不正确'),
            array('verify_code', 'numerical', 'integerOnly' => true, 'message' => '{attribute}不正确'),
            array('captcha_code', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements(), 'caseSensitive' => false, 'on' => 'getSmsCode'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'username' => Yii::t('user', '手机号'),
            'verify_code' => Yii::t('user', '短信验证码'),
            'password' => Yii::t('user', '登录密码'),
            'password_repeat' => Yii::t('user', '确认密码'),
            'terms' => Yii::t('user', '《在线服务条款》'),
            'captcha_code' => Yii::t('user', '验证码')
        );
    }

    public function checkUnique() {
        if (User::model()->exists('username=:username AND role=:role', array(':username' => $this->username, ':role' => $this->role))) {
            $this->addError('username', $this->getAttributeLabel('username') . '已被注册');
        }
    }

    /*     * ****** Accessors ******* */

    public function getUsername() {
        return $this->username;
    }

    // username is mobile.
    public function getMobile() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getPasswordRepeat() {
        return $this->password_repeat;
    }

    public function getVerifyCode() {
        return $this->verify_code;
    }

}
