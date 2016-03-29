<?php

/**
 * Description of DoctorHuizhen
 *
 * @author shuming
 */
class DoctorHuizhenForm extends EFormModel {

    public $user_id;
    public $is_join;
    public $min_no_surgery;
    public $travel_duration;
    public $fee_min;
    public $fee_max;
    public $week_days;
    public $patients_prefer;
    public $freq_destination;
    public $destination_req;

    public function rules() {
        return array(
            array('is_join', 'required', 'message' => '请输入{attribute}'),
            array('user_id, is_join, fee_min, fee_max, min_no_surgery', 'numerical', 'integerOnly' => true),
            array('week_days', 'length', 'max' => 20),
            array('patients_prefer, freq_destination, destination_req', 'length', 'max' => 500),
            array('travel_duration', 'safe'),
        );
    }

    public function attributeLabels() {
        return array(
            'user_id' => 'User',
            'is_join' => '是否参加',
            'travel_duration' => '您对交通距离的要求?',
            'min_no_surgery' => '几台手术你愿意外出会诊?',
            'fee_min' => '最低手术费',
            'fee_max' => '最高手术费',
            'week_days' => '您一般一周内那几天比较方便会诊?',
            'patients_prefer' => '你更愿意会诊什么样的病人?',
            'freq_destination' => '你常去那些地区或医院?',
            'destination_req' => '您对手术地点/条件有什么要求?',
        );
    }

    public function initModel(UserDoctorHuizhen $model = null) {
        if (isset($model)) {
            $attributes = $model->attributes;
            $this->setAttributes($attributes, true);
        } else {
            //默认为不参与
            $this->is_join = 0;
        }
    }

}
