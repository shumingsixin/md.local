<?php

class PatientMRFileForm extends EFormModel {

    public $patient_id;
    public $creator_id;
    public $uid;
    public $report_type;
    public $file_size;
    public $mime_type;
    public $file_ext;
    public $has_remote;
    public $remote_domain;
    public $remote_file_key;
    public $file_name;
    public $file_url;

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('uid, file_name, file_url, file_ext, file_size, has_remote, remote_domain, remote_file_key, report_type', 'required'),
            array('file_size, patient_id, creator_id, has_remote', 'numerical', 'integerOnly' => true),
            array('uid', 'length', 'max' => 32),
            array('file_ext, report_type', 'length', 'max' => 10),
            array('mime_type', 'length', 'max' => 20),
            array('remote_file_key', 'length', 'max' => 40),
            array('remote_domain', 'length', 'max' => 255),
            array('patient_id, creator_id, mime_type, file_size', 'safe'),
        );
    }

    public function initModel() {
        $this->uid = strRandomLong(32);
        if (strIsEmpty($this->report_type)) {
            $this->report_type = StatCode::MR_REPORTTYPE_MR;
        }
        $this->has_remote = StatCode::HAS_REMOTE;
    }

}
