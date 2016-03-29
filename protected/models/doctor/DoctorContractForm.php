<?php

class DoctorContractForm extends EFormModel {

    public $id;
    public $preferred_patient;
    public $date_contracted; //注册就签约
    public $terms;

    public function rules() {
        return array(
            array('preferred_patient, date_contracted', 'required', 'message' => '请输入{attribute}'),
            array("terms", "required", "message" => "请同意{attribute}"),
            array('preferred_patient', 'length', 'max' => 1000),
            array('id, preferred_patient, date_contracted', 'safe'),
        );
    }

    public function initModel(UserDoctorProfile $profile = null) {
        $this->scenario = 'new';  // 第一次保存场景
        if (isset($profile)) {
            if (is_null($profile->date_contracted)) {
                $this->date_contracted = date('Y-m-d H:i:s');
            } else {
                $this->date_contracted = $profile->date_contracted;
                $this->preferred_patient = $profile->preferred_patient;
                $this->scenario = 'update';   // 更新场景
            }
        }
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'preferred_patient' => '希望收到的病人/病历',
            'date_contracted' => '成为签约专家的日期',
            'terms' => '专家签约协议',
        );
    }

}
