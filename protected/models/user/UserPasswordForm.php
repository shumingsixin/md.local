<?php

class UserPasswordForm extends EFormModel {

    public $password;
    public $password_new;
    public $password_repeat;
    private $user;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            array('password', 'required', 'on' => 'new', 'message' => '请输入{attribute}'),
            array('password', 'checkPassword', 'on' => 'new'),
            array('password_new', 'required', 'message' => '请输入{attribute}'),
            //array('password_new', 'length', 'min' => 4, 'max' => 40, 'tooShort' => '密码不可少于4位', 'tooLong' => '密码不可超过40位'),
            array('password_new', 'length', 'min' => 4, 'max' => 40,'tooShort'=>'密码不可少于4个字母或数字','tooLong'=>'密码不可多于40个字母或数字'),
            array('password_repeat', 'compare', 'compareAttribute' => 'password_new', 'message' => '新密码不匹配'),
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return array(
            'password' => Yii::t('user', '当前密码'),
            'password_new' => Yii::t('user', '新密码'),
            'password_repeat' => Yii::t('user', '确认新密码'),
        );
    }

    public function checkPassword($attribute) {
        if (isset($this->user) === false) {
            $this->addError('password', '请求无效 - 未知用户');
        } else if ($this->user->checkLoginPassword($this->password) === false) {
            $this->addError('password', $this->getAttributeLabel('password') . '不正确');
        }
    }

    public function initModel(User $user) {
        $this->user = $user;
    }

    public function isReset() {
        return $this->scenario == 'reset';
    }

    public function clearData() {
        $this->password = null;
        $this->password_new = null;
        $this->password_repeat = null;
    }

    /*     * ****** Accessors ******* */

    public function getUser() {
        return $this->user;
    }

    public function getNewPassword() {
        return $this->password_new;
    }

}

