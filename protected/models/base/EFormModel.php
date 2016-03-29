<?php

abstract class EFormModel extends CFormModel {

    const FORMAT_DATETIME_DB = 'yyyy-mm-dd';
    const FORMAT_DATETIME_FORM = 'Y-m-d';

    //  const GENDER_MALE = 1;
    //  const GENDER_FEMALE = 2;
    // public $success = false;
    public $action = '';
    public $id;
    public $date_created;
    public $date_updated;
    public $date_deleted;
    public $isNewRecord = true;
    public $success;

    public function getSafeAttributes() {
        $safeAttributeNames = $this->getSafeAttributeNames();
        return $this->getAttributes($safeAttributeNames);
    }

    /**
     * Customized validation for array-type fields.
     * @param type $attribute
     * @param type $params 
     */
    public function validateArrayField($attribute, $params) {
        if (isset($params['message']) === false) {
            $message = '请输入至少一项' . $this->getAttributeLabel($attribute);
        } else {
            $message = str_replace('{attribute}', $this->getAttributeLabel($attribute), $params['message']);
        }
        if (is_array($this->{$attribute}) === false || empty($this->{$attribute})) {
            $this->addError($attribute, $message);
        } else {
            $hasValue = false;
            foreach ($this->{$attribute} as $key => $value) {
                if (trim($value) != '') {
                    $hasValue = true;
                    break;
                }
            }
            if ($hasValue === false) {
                $this->addError($attribute, $message);
            }
        }
    }

    public function greaterThanZero($attribute, $params) {
        if (isset($params['message']) === false) {
            $message = $this->getAttributeLabel($attribute) . '必须大于零';
        } else {
            $message = str_replace('{attribute}', $this->getAttributeLabel($attribute), $params['message']);
        }
        if ($this->{$attribute} <= 0) {
            $this->addError($attribute, $message);
        }
    }

    /*
      public function hasSuccess() {
      return $this->success;
      }
     * 
     */

    public function isNew() {
        return ($this->scenario == 'new');
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

    public function loadOptionsGender() {
        return StatCode::getOptionsGender();
        //return array(self::GENDER_MALE => Yii::t('user', '男'), self::GENDER_FEMALE => Yii::t('user', '女'));
    }

    public function loadOptionsYear($range = 120) {
        $options = array();
        $currentYear = intval(Date('Y'));
        $endYear = $currentYear - $range;
        for ($i = $currentYear; $i > $endYear; $i--) {
            $options[$i] = $i;
        }
        return $options;
    }

    public function loadOptionsMonth() {
        $options = array();
        for ($i = 1; $i < 13; $i++) {
            $options[$i] = $i;
        }
        return $options;
    }

    public function loadOptionsDay($year = null, $month = null) {
        $options = array();
        //  $largeMonths = array(1,3,5,7,8,10,12);
        $days = 30;
        if (isLeapYear($year) && $month == 2) {
            $days = 29;
        } else if (($month == null) || ($month < 1) || ($month > 12)) {   //just return a default value of 31 days in a month.
            $days = 31;
        } else if ($month == 2) {   //Feburary.
            $days = 28;
        } else if (in_array($month, array(1, 3, 5, 7, 8, 10, 12))) {
            $days = 31;
        }
        for ($i = 1; $i < $days + 1; $i++) {
            $options[$i] = $i;
        }
        return $options;
    }

    public function parseYmdToDate($year, $month, $day) {
        if (empty($year) || empty($month) || empty($day)) {
            return null;
        } else {
            $datestr = $year . '-' . $month . '-' . $day;
            $date = new DateTime($datestr);
            return $date->format(self::FORMAT_DATETIME_FORM);
        }
    }

    public function validateYmdDate($attribute) {
        $attrYear = $attribute . '_year';
        $attrMonth = $attribute . '_month';
        $attrDay = $attribute . '_day';
        if ((empty($this->{$attrYear}) && empty($this->{$attrMonth}) && empty($this->{$attrDay})) === false) {
            $datestr = $this->{$attrYear} . '-' . $this->{$attrMonth} . '-' . $this->{$attrDay};
            $date = date_parse_from_format('Y-m-d', $datestr);
            if ($date['warning_count'] > 0 || $date['error_count'] > 0) {
                $this->dob = null;
                $this->addError($attribute, '请输入正确的' . $this->getAttributeLabel($attribute));
            }
        }
    }

    public function parseDobFromChinaNRIC($attribute) {
        $dobStr = substr($attribute, 6, 8); // get dob portion from nric.
        $year = substr($dobStr, 0, 4);  // get year from $dobStr.
        $month = substr($dobStr, 4, 2); // get month from $dobStr.
        $day = substr($dobStr, 6, 2); // get day from $dobStr.
        $dateStr = $year . '-' . $month . '-' . $day;
        $date = date_parse_from_format('Y-m-d', $dateStr);
        if ($date['warning_count'] > 0 || $date['error_count'] > 0) {
            return null;
        } else {
            return $date;
        }
    }

    public function validateChineseNRIC($attribute) {
        $errorMsg = '请输入正确的中国' . $this->getAttributeLabel($attribute);
        $dobStr = '';
        // 18 digits in length.
        if (preg_match('/^\d{18}$/', $this->{$attribute}) === false) {
            $this->addError('nric', $this->nric);
            $this->addError('nric', 'not 18 digits');
        }
        // check dob portion.        
        else if (($dobStr = strlen($dobStr)) !== 8) {
            //$this->addError($attribute, $dobStr);
            $this->addError('nric', 'not 8 digits');
        } else {
            $year = substr($dobStr, 0, 4);
            $month = substr($dobStr, 4, 2);
            $day = substr($dobStr, 6, 2);
            $dateStr = $year . '-' . $month . '-' . $day;
            $date = date_parse_from_format('Y-m-d', $dateStr);
            if ($date['warning_count'] > 0 || $date['error_count'] > 0) {
                $this->addError('nric', $errorMsg);
            }
        }
    }

    /**
     * Convert json-format to array-type.
     * @param type $attribute 
     */
    protected function jsonToArray($attribute) {
        if (is_array($this->{$attribute}) === false) {
            // $this->{$attribute} = json_decode($this->{$attribute});
            $this->{$attribute} = CJSON::decode($this->{$attribute});
        }
    }

    protected function objectToArray($attribute) {
        if (is_object($this->{$attribute})) {
            $this->{$attribute} = get_object_vars($this->{$attribute});
        }
    }

    /*     * ****** Accessors ******* */

    public function getId() {
        return $this->id;
    }

    public function setId($v) {
        $this->id = $v;
    }

    public function setScenario($v) {
        parent::setScenario($v);
    }

}
