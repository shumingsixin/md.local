<?php

/**
 * Description of DoctorZhuanzhen
 *
 * @author shuming
 */
class DoctorZhuanzhenForm extends EFormModel {

    public $user_id;
    public $is_join;
    public $fee;
    public $preferred_patient;
    public $prep_days;

    public function rules() {
        return array(
            array('user_id, is_join, fee', 'numerical', 'integerOnly' => true),
            //array('week_days', 'length', 'max' => 20),
            array('prep_days, preferred_patient', 'length', 'max' => 500),
        );
    }

    public function attributeLabels() {
        return array(
            'user_id' => 'User',
            'is_join' => '是否参加?',
            'fee' => '是否需要转诊费?',
            //'week_days' => '您一般一周内那天比较方便?',
            'preferred_patient'=>'对转诊病历有何要求?',
            'prep_days' => '您最快多久能安排手术?',
        );
    }

    public function initModel(UserDoctorZhuanzhen $model = null) {
        if (isset($model)) {
            $attributes = $model->attributes;
            $this->setAttributes($attributes, true);
        } else {
            //默认为不参与
            $this->is_join = 0;
        }
    }

}
