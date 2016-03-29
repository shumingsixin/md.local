<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ContactForm extends EFormModel {

    public $name;
    public $mobile;
    public $email;
    public $subject;
    public $message;
    //  public $verifyCode;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            // name, email, subject and body are required
            array('mobile', 'required', 'message' => '请填入{attribute}'),
            // email has to be a valid email address
            array('email', 'email'),
            // array('mobile', 'length', 'max' => 45, 'tooLong' => '{attribute}不可超过45个字'),
            array('mobile', 'length', 'is' => 11, 'message' => '请填入正确的11位{attribute}'),
            array('mobile', 'numerical', 'integerOnly' => true, 'message' => '请填入正确的11位{attribute}'),
            array('name, email, subject', 'length', 'max' => 100, 'tooLong' => '{attribute}不可超过250个字'),
            array('message', 'length', 'max' => 500, 'tooLong' => '{attribute}不可超过500个字'),
                // verifyCode needs to be entered correctly
                // array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements(), 'message' => '验证码不正确')
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return array(
            'name' => Yii::t('contactus', '姓名'),
            'mobile' => Yii::t('contactus', '手机号'),
            'email' => Yii::t('contactus', '电子邮箱'),
            'subject' => Yii::t('contactus', '标题'),
            'message' => Yii::t('contactus', '内容'),
                // 'verifyCode' => '验证码',
        );
    }

}