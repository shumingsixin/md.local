<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MobileUserIdentity
 *
 * @author Administrator
 */
class MobileUserIdentity extends CUserIdentity {

    const ERROR_ACCOUNT_NOT_ACTIVATED = 3;

    private $id;
    private $role;

    public function __construct($username, $role) {
        // $this->login_type = $loginType;
        $this->username = $username;
        $this->role = $role;
    }

    public function authenticate() {
        $user = User::model()->getByUsernameAndRole($this->username, $this->role);
        if (isset($user) === false) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            if ($user->isActivated() === false) {
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
