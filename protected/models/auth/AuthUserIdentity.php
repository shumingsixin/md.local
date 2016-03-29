<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class AuthUserIdentity extends CUserIdentity {

    const AUTH_TYPE_PASSWORD = 1; // authenticate by using password.
    const AUTH_TYPE_TOKEN = 2;    // authenticate by using token.

    public $auth_type;
    private $user;  // User model.
    private $token; // AuthTokenUser.
    private $role; //User role

    public function __construct($username, $password, $authType, $role=StatCode::USER_ROLE_PATIENT) {
        // $this->login_type = $loginType;
        $this->username = $username;
        $this->password = $password;    // used as token is action_type is 'by token'.
        $this->auth_type = $authType;
        $this->role = $role;
    }

    public function authenticate() {
        switch ($this->auth_type) {
            case self::AUTH_TYPE_PASSWORD:
                return $this->authenticatePassword();
            case self::AUTH_TYPE_TOKEN:
                return $this->authenticateToken();
            default:
                $this->errorCode = ErrorList::AUTH_UNKNOWN_TYPE;
                return false;
        }
    }

    public function authenticatePassword() {
        $this->user = User::model()->getByUsername($this->username);
        if ($this->user === null) {
            $this->errorCode = ErrorList::AUTH_USERNAME_INVALID;
        } else if ($this->user->checkLoginPassword($this->password) === false) {
            $this->errorCode = ErrorList::AUTH_PASSWORD_INVALID; //Wrong password.
        } else {
            //$this->id = $user->getId();
            if ($this->user->getLastLoginTime() === null) {
                $lastLogin = time();
            } else {
                $lastLogin = strtotime($this->user->getLastLoginTime());
            }
            $this->setState('lastLoginTime', $lastLogin); //* Can be accessed by Yii::app()->user->lastLoginTime;
            //$now = new Datetime("now");
            //$user->setLastLoginTime($now->format('Y-m-d H:i:s'));
            $now = new CDbExpression("NOW()");
            $this->user->setLastLoginTime($now);
            $this->user->update('last_login_time');

            $this->errorCode = ErrorList::ERROR_NONE;
        }

        return !$this->errorCode;
    }

    /**
     * authenticates user by token and username.     
     */
    public function authenticateToken() {
        if($this->role == StatCode::USER_ROLE_PATIENT){
            $this->token = AuthTokenUser::model()->verifyTokenPatient($this->password, $this->username);
        }elseif($this->role == StatCode::USER_ROLE_DOCTOR){
            $this->token = AuthTokenUser::model()->verifyTokenDoctor($this->password, $this->username);
        }

        if (is_null($this->token) || $this->token->isTokenValid() === false) {
            $this->errorCode = ErrorList::AUTH_TOKEN_INVALID;
        } else {
            $this->errorCode = ErrorList::ERROR_NONE;
            $this->user = $this->token->getUser();
        }
        return $this->errorCode === ErrorList::ERROR_NONE;
    }

    public function hasSuccess() {
        return $this->errorCode === ErrorList::ERROR_NONE;
    }

    public function getUser() {
        return $this->user;
    }

    public function getToken() {
        return $this->token;
    }

}
