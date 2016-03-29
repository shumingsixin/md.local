<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $username
 * @proeprty integer $role
 * @property string $name
 * @property string $email
 * @property string $qq
 * @property string $wechat
 * @property string $login_attempts
 * @property string $password
 * @property string $salt
 * @property string $password_raw
 * @property integer $terms 
 * @property string $date_activated
 * @property string $last_login_time
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 */
class User extends EActiveRecord {

    const ROLE_PATIENT = 1;
    const ROLE_DOCTOR = 2;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, password, role, salt, terms', 'required'),
            array('role, login_attempts, terms', 'numerical', 'integerOnly' => true),
            array('username', 'length', 'is' => 11),
            //    array('username', 'unique', 'message' => '{attribute}已被注册.'),
            array('name, qq, wechat', 'length', 'max' => 45),
            array('email', 'length', 'max' => 255),
            array('password', 'length', 'max' => 64),
            array('password', 'length', 'min' => 64),
            array('salt', 'length', 'min' => 40),
            array('password_raw', 'required', 'message' => '请填写{attribute}.', 'on' => 'register'),
            array('password_raw', 'length', 'min' => 4, 'max' => 40, 'tooShort' => '{attribute}不可少于4位.', 'tooLong' => '{attribute}不可超过40位', 'on' => 'register'),
            array('date_activated, last_login_time, date_created, date_updated, date_deleted', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, username, name, email, qq, wechat, password, salt, password_raw, login_attempts, date_activated, last_login_time, date_created, date_updated, date_deleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'userMedicalRecords' => array(self::HAS_MANY, 'MedicalRecord', 'user_id'),
            'userDoctorProfile' => array(self::HAS_ONE, 'UserDoctorProfile', 'user_id'),
            'userDoctorCerts' => array(self::HAS_MANY, 'UserDoctorCert', 'user_id'),
            'userPatients' => array(self::HAS_MANY, 'PatientInfo', 'creator_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'username' => Yii::t('user', '手机号码'),
            'role' => Yii::t('user', '角色'),
            'name' => Yii::t('user', '姓名'),
            'email' => Yii::t('user', '邮箱'),
            'qq' => 'QQ',
            'wechat' => Yii::t('user', '微信'),
            'password' => Yii::t('user', '登录密码'),
            'salt' => 'Salt',
            'password_raw' => Yii::t('user', '登录密码'),
            'password_repeat' => Yii::t('user', '确认密码'),
            'login_attempts' => Yii::t('user', '登录尝试次数'),
            'date_activated' => Yii::t('user', '激活日期'),
            'last_login_time' => Yii::t('user', '最后登录时间'),
            'date_created' => Yii::t('site', '创建日期'),
            'date_updated' => Yii::t('site', '更新日期'),
            'date_deleted' => Yii::t('site', '删除日期'),
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
        $criteria->compare('username', $this->username, true);
        $criteria->compare('role', $this->role, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('qq', $this->qq, true);
        $criteria->compare('wechat', $this->wechat, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('salt', $this->salt, true);
        $criteria->compare('password_raw', $this->password_raw, true);
        $criteria->compare('date_activated', $this->date_activated, true);
        $criteria->compare('last_login_time', $this->last_login_time, true);
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
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /*     * ****** Query Methods ******* */

    /**
     * @param string $username  User.username.     
     * @return User model.
     */
    public function getByUsername($username) {
        return $this->getByAttributes(array('username' => $username));
    }

    public function getByUsernameAndRole($username, $role) {
        return $this->getByAttributes(array('username' => $username, 'role' => $role));
    }

    /*     * ****** Public Methods ****** */

    public function createNewModel() {
        $this->createSalt();
        $this->createPassword();
    }

    public function checkLoginPassword($passwordInput) {
        return ($this->password === $this->encryptPassword($passwordInput));
    }

    public function changePassword($passwordInput) {
        $this->password_raw = $passwordInput;
        $this->password = $this->encryptPassword($passwordInput);
        return $this->update(array('password', 'password_raw'));
    }

    public function checkUsernameExists($username) {
        return $this->exists('username=:username AND date_deleted is NULL', array(':username' => $username));
    }

    public function isDoctor($checkVerify = true) {
        if ($this->role != StatCode::USER_ROLE_DOCTOR) {
            return false;
        } elseif ($checkVerify) {
            $userDoctorProfile = $this->getUserDoctorProfile();
            return (isset($userDoctorProfile) && $userDoctorProfile->getDateVerified(false) !== null);
        } else {
            return true;
        }
    }

    /*     * ****** Private Methods ******* */

    private function createSalt() {
        $this->salt = $this->strRandom(40);
    }

    private function createPassword() {
        $this->setPassword($this->encryptPassword($this->password_raw));
    }

    public function encryptPassword($password, $salt = null) {
        if ($salt === null) {

            return ($this->encrypt($password . $this->salt));
        } else {
            return ($this->encrypt($password . $salt));
        }
    }

    private function encrypt($value) {
        return hash('sha256', $value);
    }

    // Max length supported is 62.
    private function strRandom($length = 40) {
        $chars = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        shuffle($chars);
        $ret = implode(array_slice($chars, 0, $length));

        return ($ret);
    }

    /*     * ****** Query Methods ******* */

    public function createCriteriaMedicalRecords() {
        $criteria = new CDbCriteria();
        $criteria->compare('t.user_id', $this->id);
        $criteria->order = 't.date_created ASC';
        $criteria->with = array('mrBookings');
        return $criteria;
    }

    /*     * ****** Accessors ******* */

    public function getUserDoctorCerts() {
        return $this->userDoctorCerts;
    }

    public function getUserDoctorProfile() {
        return $this->userDoctorProfile;
    }

    public function getUserMedicalRecords() {
        return $this->userMedicalRecords->with('mrBookings');
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($v) {
        $this->username = $v;
    }

    public function getMobile() {
        return $this->username;
    }

    public function getRole() {
        return $this->role;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getName() {
        return $this->name;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($v) {
        $this->password = $v;
    }

    public function setTerms($v) {
        $this->terms = $v;
    }

    public function isActivated() {
        return $this->date_activated !== null;
    }

    public function setActivated() {
        $this->date_activated = new CDbExpression("NOW()");
    }

    public function getLastLoginTime() {
        return $this->last_login_time;
    }

    public function setLastLoginTime($v) {
        $this->last_login_time = $v;
    }

}
