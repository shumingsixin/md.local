<?php

class UserLikeForm extends EFormModel {

    public $username;
    public $token;
    public $user_id;
    public $special_topic_id;
    public $is_liked;

    public function rules() {
        return array(
            array('user_id, special_topic_id, username, token', 'required'),
            array('user_id, special_topic_id, is_liked', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            array(' user_id, special_topic_id, is_liked', 'safe'),
        );
    }

    public function initModel() {
        if (strIsEmpty($this->username) || strIsEmpty($this->token)) {
            $this->addError('username', '用户没有登录!');
        } else {
            $this->setUserId();
        }
    }

    private function setUserId() {
        $authMgr = new AuthManager();
        $authUserIdentity = $authMgr->authenticateDoctorByToken($this->username, $this->token);
        if (is_null($authUserIdentity) || $authUserIdentity->isAuthenticated === false) {
            $this->addError('username', '用户权限有误!');
        }
        $user = $authUserIdentity->getUser();
        $this->user_id = $user->getId();
        $like = new SpecialTopicUserLike();
        $islike = $like->checkUserLike($user->id, $this->special_topic_id);
        if ($islike == SpecialTopicUserLike::LIKE) {
            $this->addError('is_like', '无法重复点赞!');
        }
    }

}
