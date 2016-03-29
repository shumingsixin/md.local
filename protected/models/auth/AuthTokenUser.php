<?php

/**
 * This is the model class for table "auth_token_user".
 *
 * The followings are the available columns in table 'auth_token_user':
 * @property integer $id
 * @property string $token
 * @property integer $user_id
 * @property integer $is_active
 * @property integer $time_expiry
 * @property string $user_host_ip
 * @property string $user_mac_address
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 *
 * The followings are the available model relations:
 * @property User $user
 */
class AuthTokenUser extends EActiveRecord {

    const EXPIRY_DEFAULT = 31536000;    //one year
    const ERROR_NONE = 0;
    const ERROR_NOT_FOUND = 1;
    const ERROR_INACTIVE = 2;
    const ERROR_EXPIRED = 3;

    public $error_code;
    private $verified = false;  // flag indicating if token is verified.

    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return 'auth_token_user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date_created', 'required'),
            array('user_id, is_active, time_expiry', 'numerical', 'integerOnly' => true),
            array('token', 'length', 'is' => 32),
            array('user_host_ip', 'length', 'max' => 15),
            array('username', 'length', 'max' => 11),
            array('user_mac_address', 'length', 'max' => 50),
            array('date_updated, date_deleted', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, token, user_id, username, is_active, time_expiry, user_host_ip, user_mac_address, date_created, date_updated, date_deleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'atuUser' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'token' => 'Token',
            'user_id' => 'User',
            'is_active' => 'Is Active',
            'time_expiry' => 'Time Expiry',
            'user_host_ip' => 'User Host Ip',
            'user_mac_address' => 'User Mac Address',
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
        $criteria->compare('token', $this->token, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('is_active', $this->is_active);
        $criteria->compare('time_expiry', $this->time_expiry);
        $criteria->compare('user_host_ip', $this->user_host_ip, true);
        $criteria->compare('user_mac_address', $this->user_mac_address, true);
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
     * @return AuthTokenUser the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function initModel($userId, $username, $userHostIp, $userMacAddress) {
        $this->createToken($userId, $username, $userHostIp, $userMacAddress);
    }

    // 创建 token。
    public function createTokenPatient($userId, $username, $userHostIp, $userMacAddress) {
        return $this->createToken($userId, $username, StatCode::USER_ROLE_PATIENT, $userHostIp, $userMacAddress);
    }

    public function createTokenDoctor($userId, $username, $userHostIp, $userMacAddress) {
        return $this->createToken($userId, $username, StatCode::USER_ROLE_DOCTOR, $userHostIp, $userMacAddress);
    }

    public function createToken($userId, $username, $userRole, $userHostIp, $userMacAddress) {
        $this->setUserId($userId);
        $this->setUsername($username);
        $this->setUserRole($userRole);
        $this->setToken();
        $this->setTimeExpiry();
        $this->setUserHostIp($userHostIp);
        $this->setUserMacAddress($userMacAddress);
        $this->setIsActive(true);
    }

    // 验证 token。
    public function verifyTokenPatient($token, $username) {
        return $this->verifyByTokenAndUsernameAndRole($token, $username, StatCode::USER_ROLE_PATIENT);
    }

    public function verifyTokenDoctor($token, $username) {
        return $this->verifyByTokenAndUsernameAndRole($token, $username, StatCode::USER_ROLE_DOCTOR);
    }

    public function verifyByTokenAndUsernameAndRole($token, $username, $userRole) {
        $model = $this->getByTokenAndUsernameAndRole($token, $username, $userRole, true);
        if (isset($model)) {
            $model->verifyToken();
            return $model;
        } else {
            return null;
        }
    }

    //@不用了。 - 2015-10-28 by QP
    public function verifyByTokenAndUsername($token, $username) {
        $model = $this->getByTokenAndUsername($token, $username, true);
        if (isset($model)) {
            $model->verifyToken();
            return $model;
        } else {
            return null;
        }
    }

    public function verifyToken() {
        if ($this->checkExpiry()) {
            $this->error_code = self::ERROR_NONE;
        } else {
            $this->error_code = self::ERROR_EXPIRED;
        }
        $this->verified = true;
    }

    public function isTokenValid() {
        return ($this->verified && $this->error_code === self::ERROR_NONE);
    }

    /*
      public function verifyToken($token, $username) {
      $tokenUser = $this->getByTokenAndUsername($token, $username, true);
      if (isset($tokenUser)) {
      if ($this->checkExpiry($tokenUser)) {
      $this->error_code = self::ERROR_NONE;
      } else {
      $this->error_code = self::ERROR_EXPIRED;
      }
      } else {
      $this->error_code = self::ERROR_NOT_FOUND;
      }
      return $this->error_code == self::ERROR_NONE;
      }
     * 
     */

    public function deActivateToken() {
        $this->setIsActive(false);
        $this->date_updated = new CDbExpression("NOW()");
        return $this->update(array('is_active', 'date_updated'));
    }

    public function deActivateAllOldTokens() {
        $now = new CDbExpression("NOW()");
        return $this->updateAllByAttributes(array('is_active' => 0, 'date_updated' => $now), array('user_id' => $this->user_id, 'is_active' => '1'));
    }

    public function checkExpiry() {
        if (is_null($this->time_expiry)) {
            return true;
        } else {
            $now = time();
            return ($this->time_expiry > $now);
        }
    }

    /*     * ****** private methods  ******* */

    // Max length supported is 62.
    private function strRandom($length = 40) {
        $chars = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        shuffle($chars);
        $ret = implode(array_slice($chars, 0, $length));

        return ($ret);
    }

    private function getByTokenAndUsernameAndRole($token, $username, $userRole, $isActiveFlag = true) {
        $isActive = $isActiveFlag === true ? 1 : 0;
        $model = $this->getByAttributes(array('token' => $token, 'username' => $username, 'user_role' => $userRole, 'is_active' => $isActive));
        if (isset($model)) {
            return $model;
        }
        return null;
    }

    //@不用了。 参照 getByTokenAndUsernameAndRole(). - 2015-10-28 by QP
    private function getByTokenAndUsername($token, $username, $isActiveFlag = true) {
        $isActive = $isActiveFlag === true ? 1 : 0;
        $model = $this->getByAttributes(array('token' => $token, 'username' => $username, 'is_active' => $isActive));
        if (isset($model)) {
            return $model;
        }
        return null;
    }

    /*     * ****** Query Methods ******* */

    public function getAllActiveByUserId($userId) {
        $now = time();
        $criteria = new CDbCriteria();
        $criteria->addCondition("t.date_deleted is NULL");
        $criteria->compare("user_id", $userId);
        $criteria->compare("is_active", '1');
        $criteria->compare('time_expiry', ">:" . $now);
        return $this->findAll($criteria);
    }

    public function getFirstActiveByUserId($userId) {
        $criteria = new CDbCriteria();
        $criteria->addCondition("t.date_deleted is NULL");
        $criteria->compare("t.user_id", $userId);
        $criteria->compare("t.is_active", '1');
        //$now = time();
        //$criteria->addCondition("t.time_expiry>" . $now);
        return $this->find($criteria);
    }

    /*     * ****** Accessors ******* */

    public function getUser() {
        return $this->atuUser;
    }

    public function getToken() {
        return $this->token;
    }

    private function setToken() {
        $this->token = strtoupper(substr(str_shuffle(MD5(microtime())), 0, 32));   // refer to helper.php
    }

    public function getUserId() {
        return $this->user_id;
    }

    private function setUserId($v) {
        $this->user_id = $v;
    }

    public function getUsername() {
        return $this->username;
    }

    private function setUsername($v) {
        $this->username = $v;
    }

    public function getTimeExpiry() {
        return $this->time_expiry;
    }

    private function setTimeExpiry() {
        $duration = self::EXPIRY_DEFAULT;
        $now = time();
        $this->time_expiry = $now + $duration;
    }

    public function getUserHostIp() {
        return $this->user_host_ip;
    }

    private function setUserHostIp($v) {
        $this->user_host_ip = $v;
    }

    public function getUserMacAddress() {
        return $this->user_mac_address;
    }

    private function setUserMacAddress($v) {
        $this->user_mac_address = $v;
    }

    private function setIsActive($v) {
        $this->is_active = $v === true ? 1 : 0;
    }

    private function setUserRole($v) {
        $this->user_role = $v;
    }

}
