<?php

class AppFormModel extends CFormModel {

    const FORMAT_DATETIME_DB = 'yyyy-mm-dd';
    const FORMAT_DATETIME_FORM = 'Y-m-d';

    public $username;
    public $token;
    public $id;

    public function rules() {
        return array(
                //array('username, token', 'required', 'message' => '您没有权限执行此操作，请先登录。'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'username' => '登录ID',
            'token' => '临时登录密匙',
        );
    }

    public function getSafeAttributes() {
        $safeAttributeNames = $this->getSafeAttributeNames();
        return $this->getAttributes($safeAttributeNames);
    }

    public function setAttributes($values, $safeOnly = true) {
        parent::setAttributes($values, $safeOnly);
    }

    /**
     * 
     * @return array the first error of each attribute.
     */
    public function getFirstErrors() {
        $ret = array();
        $errorList = $this->getErrors();
        if (emptyArray($errorList) === false) {
            foreach ($errorList as $attribute => $errors) {
                if (emptyArray($errors) === false) {
                    $error = array_shift($errors);
                    $ret[$attribute] = $error;
                }
            }
        }
        return $ret;
    }

    public function getErrorsInJson() {
        $output = array();
        $errorList = $this->getErrors();
        if (empty($errorList) === false) {
            $prefix = get_class($this) . '_';
            foreach ($errorList as $key => $error) {
                $output[$prefix . $key] = $error;
            }
        }
        return CJSON::encode($output);
    }

}
