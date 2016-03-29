<?php

/**
 * This is the model class for table "auth_sms_verify".
 *
 * The followings are the available columns in table 'auth_sms_verify':
 * @property integer $id
 * @property integer $mobile
 * @property string $code
 * @property integer $action_type
 * @property string $time_expiry
 * @property integer $is_active
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 */
class AuthSmsVerify extends EActiveRecord {

    const ACTION_USER_REGISTER = 100;
    const ACTION_USER_PASSWORD_RESET = 101;
    const ACTION_USER_LOGIN = 102;
    const ACTION_BOOKING = 200;
    const EXPIRY_DEFAULT = 600;
    const ERROR_NONE = 0;
    const ERROR_NOT_FOUND = 1;
    const ERROR_INACTIVE = 2;
    const ERROR_EXPIRED = 3;

    private $verified = false;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'auth_sms_verify';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('mobile, code, action_type, time_expiry', 'required'),
            array('mobile, action_type, is_active', 'numerical', 'integerOnly' => true),
            array('mobile', 'length', 'max' => 11),
            array('code', 'length', 'is' => 6),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, mobile, code, action_type, time_expiry, is_active, date_created, date_updated, date_deleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'mobile' => '手机号',
            'code' => '验证码',
            'action_type' => 'Action Type',
            'time_expiry' => 'Time Expiry',
            'is_active' => 'Is Active',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
            'date_deleted' => 'Date Deleted',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('mobile', $this->mobile);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('action_type', $this->action_type);
        $criteria->compare('time_expiry', $this->time_expiry, true);
        $criteria->compare('is_active', $this->is_active);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('date_updated', $this->date_updated, true);
        $criteria->compare('date_deleted', $this->date_deleted, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AuthSmsVerify the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getErrorMessage($code) {
        $msg = self::model()->getAttributeLabel('code');
        switch ($code) {
            case self::ERROR_NONE:
                $msg.='正确';
                break;
            case self::ERROR_NOT_FOUND:
                $msg.='不正确';
                break;
            case self::ERROR_INACTIVE:
                $msg.='不正确';
                break;
            case self::ERROR_EXPIRED:
                $msg.='已过期';
                break;
            default:
                $msg.='不正确';
                break;
        }
        return $msg;
    }

    public function initModel($mobile, $actionType, $userIp = null) {
        $this->mobile = $mobile;
        $this->action_type = $actionType;
        $this->createCode();
        $this->setExpiryTime();
        $this->setUserHostIp($userIp);
        //$this->setExpiryDate($actionType);
        $this->is_active = 1;
    }

    /*     * ****** Query Methods ******* */

    public function getByMobileAndCodeAndActionType($mobile, $code, $actionType) {
        return $this->getByAttributes(array('mobile' => $mobile, 'code' => $code, 'action_type' => $actionType));
    }

    /*     * ****** Public Methods ******* */

    public function isValid() {
        return ($this->verified && $this->hasErrors() === false);
    }

    /**
     * 
     * @param type $deactivateExpired   冻结该记录,如果已过期
     * @param type $deactivate          冻结所有属于该action_type 的记录,如果没过期
     */
    public function checkValidity($deactivateExpired = true, $deactivate = false) {
        if ($this->isActive()) {
            $notExpired = $this->checkExpiry(); // true means not expired.
            if ($notExpired) {    //没过期
                if ($deactivate) {
                    // 冻结所有该 action_type 的验证码
                    $this->deActivateAllRecords();
                }
            } else {  // 已过期
                if ($deactivateExpired) {    // 冻结该验证码.
                    $this->deActivateRecord();
                }
                $this->addError('code', self::getErrorMessage(self::ERROR_EXPIRED));
            }
        } else {
            $this->addError('code', self::getErrorMessage(self::ERROR_INACTIVE));
        }
        $this->verified = true;
    }

    public function isActionValid($actionType) {
        return ($actionType == self::ACTION_USER_REGISTER || $actionType == self::ACTION_USER_PASSWORD_RESET || $actionType == self::ACTION_BOOKING || $actionType == self::ACTION_USER_LOGIN);
    }

    public function deActivateRecord() {
        $this->is_active = 0;
        $this->date_updated = new CDbExpression("NOW()");
        return $this->update(array('is_active', 'date_updated'));
    }

    public function deActivateAllRecords() {
        $now = new Datetime();
        $nowDatestr = $now->format(self::DB_FORMAT_DATETIME);
        //$now = time();
        $this->updateAllByAttributes(array('is_active' => 0, 'date_updated' => $nowDatestr), array('mobile' => $this->mobile, 'action_type' => $this->action_type, 'is_active' => 1));
    }

    public function createSmsVerifyRegister($mobile, $userIp = null) {
        return $this->createRecord($mobile, self::ACTION_USER_REGISTER, false, $userIp);
    }

    public function createSmsVerifyPasswordReset($mobile, $userIp = null) {
        return $this->createRecord($mobile, self::ACTION_USER_PASSWORD_RESET, false, $userIp);
    }

    public function createSmsVerifyBooking($mobile, $userIp = null) {
        return $this->createRecord($mobile, self::ACTION_BOOKING, false, $userIp);
    }

    public function createSmsVerifyUserLogin($mobile, $userIp = null) {
        return $this->createRecord($mobile, self::ACTION_USER_LOGIN, false, $userIp);
    }

    /**
     *
     * @return type 
     */
    public function getExpiryDuration($type = 'm') {
        $expiry = self::EXPIRY_DEFAULT;
        switch ($type) {
            case 's':
                break;
            case 'm': $expiry = $expiry / 60;
                break;
            case 'h': $expiry = $expiry / 3600;
                break;
            default: $expiry = $expiry;
                break;
        }
        return $expiry;
    }

    /*     * ****** Private Methods ******* */

    private function createRecord($mobile, $actionType, $deActivate = false, $userIp = null) {
        $this->initModel($mobile, $actionType, $userIp);
        if ($deActivate) {
            $this->deActivateAllRecords();
        }
        return $this->save();
    }

    private function createCode() {
        $this->code = mt_rand(100000, 999999);
    }

    private function setExpiryTime() {
        $duration = self::EXPIRY_DEFAULT;
        $now = time();
        $this->time_expiry = $now + $duration;  // ms
    }

    /**
     * Sets the expiry date based on the given action type.
     * @param type $actionType either Activate or PasswordReset.
     */
    /*
      private function setExpiryDate($actionType) {
      $duration = self::EXPIRY_DEFAULT;
      $now = new DateTime();
      if ($actionType === self::ACTION_REGISTER) {
      $duration = self::EXPIRY_REGISTER;
      } else if ($actionType === self::ACTION_PASSWORD_RESET) {
      $duration = self::EXPIRY_PASSWORD_RESET;
      }
      if ($duration >= 0) {
      $now->modify('+' . $duration . ' second');
      $this->time_expiry = $now->format(self::DB_FORMAT_DATETIME);
      }
      }
     * 
     */

    /**
     * Checks expiry date.
     * @return type true if not expired.
     */
    private function checkExpiry() {
        if (is_null($this->time_expiry)) {
            return true;
        } else {
            $now = time();
            return ($this->time_expiry > $now);
        }
    }

    /*     * ****** Accessors ******* */

    public function getMobile() {
        return $this->mobile;
    }

    public function getCode() {
        return $this->code;
    }

    public function setUserHostIp($v) {
        $this->user_host_ip = $v;
    }

    public function isActive() {
        return $this->is_active == 1;
    }

}
