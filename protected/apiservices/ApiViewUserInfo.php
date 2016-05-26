<?php

class ApiViewUserInfo extends EApiViewService {

    private $user;
    private $userMgr;

    public function __construct($user) {
        parent::__construct();
        $this->user = $user;
        $this->userMgr = new UserManager();
    }

    protected function createOutput() {
        $this->output = array(
            'status' => self::RESPONSE_OK,
            'errorCode' => 0,
            'errorMsg' => 'success',
            'results' => $this->results,
        );
    }

    protected function loadData() {
        $this->loadUserInfo();
    }

    public function loadUserInfo() {
        $profile = $this->user->getUserDoctorProfile();   // UserDoctorProfile model
        $models = $this->userMgr->loadUserDoctorFilesByUserId($this->user->id);
        $doctorCerts = false;
        if (arrayNotEmpty($models)) {
            $doctorCerts = true;
        }
        $data = new stdClass();
        $data->doctorCerts = $doctorCerts;
        if (isset($profile)) {
            $data->isProfile = true;
            $data->name = $profile->getName();
            //是否是签约医生
            $data->verified = $profile->isVerified();
            $data->teamDoctor = $profile->isTermsDoctor();
        } else {
            $data->isProfile = false;
            $data->name = $this->user->getMobile();
            $data->verified = false;
            $data->teamDoctor = false;
        }
        $this->results->userInfo = $data;
    }

}
