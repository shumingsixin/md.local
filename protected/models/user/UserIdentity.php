<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    const ERROR_ACCOUNT_NOT_ACTIVATED = 3;

    private $id;
    // private $login_type;
    private $role;

    public function __construct($username, $password, $role) {
        // $this->login_type = $loginType;
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
    }

    public function authenticate() {

        //$user = User::model()->getByUsername($this->username);
        $user = User::model()->getByUsernameAndRole($this->username, $this->role);        
        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            if ($user->checkLoginPassword($this->password) === false) {
                $this->errorCode = self::ERROR_PASSWORD_INVALID; //Wrong password.
            } else if ($user->isActivated() === false) {
                $this->errorCode = self::ERROR_ACCOUNT_NOT_ACTIVATED; //user's account is not activated.
            } else {
                $this->id = $user->getId();
                if ($user->getLastLoginTime() === null) {
                    $lastLogin = time();
                } else {
                    $lastLogin = strtotime($user->getLastLoginTime());
                }
                $this->setState('lastLoginTime', $lastLogin); //* Can be accessed by Yii::app()->user->lastLoginTime;
                //$now = new Datetime("now");
                //$user->setLastLoginTime($now->format('Y-m-d H:i:s'));
                $now = new CDbExpression("NOW()");
                $user->setLastLoginTime($now);
                $user->update('last_login_time');

                $this->errorCode = self::ERROR_NONE;
            }
        }        
        return !$this->errorCode;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($v) {
        $this->id = $v;
    }

    public function getRole() {
        return $this->role;
    }

}
