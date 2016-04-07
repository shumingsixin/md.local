<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserDoctorCertForm
 *
 * @author shuming
 */
class UserDoctorCertForm extends EFormModel {

    public $user_id;
    public $uid;
    public $file_name;
    public $file_url;
    public $file_size;
    public $mime_type;
    public $file_ext;
    public $has_remote;
    public $remote_domain;
    public $remote_file_key;

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, uid, file_name, file_url, file_ext, file_size, has_remote, remote_file_key, remote_domain, mime_type', 'required'),
            array('user_id, file_size, has_remote', 'numerical', 'integerOnly' => true),
            array('uid', 'length', 'max' => 32),
            array('remote_file_key', 'length', 'max' => 40),
            array('remote_domain', 'length', 'max' => 225),
            array('file_ext', 'length', 'max' => 10),
            array('mime_type', 'length', 'max' => 20),
        );
    }

    public function initModel() {
        $this->uid = strRandomLong(32);
        $this->has_remote = StatCode::HAS_REMOTE;
    }

}
