<?php

class MDDoctorManager {

    /**
     * 会诊选择不参与
     * @param type $userId
     */
    public function disJoinHuizhen($userId) {
        $model = $this->loadUserDoctorHuizhenByUserId($userId);
        if (isset($model)) {
            $model->is_join = UserDoctorHuizhen::ISNOT_JOIN;
            if ($model->update(array('is_join')) === false) {
                $output['status'] = 'no';
                $output['errors'] = $model->getErrors();
            } else {
                $output['status'] = 'ok';
                $output['zzId'] = $model->getId();
            }
        }
        return $output;
    }

    /**
     * 转诊选择不参与
     * @param type $userId
     */
    public function disJoinZhuanzhen($userId) {
        $output = array('status' => 'no');
        $model = $this->loadUserDoctorZhuanzhenByUserId($userId);
        if (isset($model)) {
            $model->is_join = UserDoctorZhuanzhen::ISNOT_JOIN;
            if ($model->update(array('is_join')) == false) {
                $output['status'] = 'no';
                $output['errors'] = $model->getErrors();
            } else {
                $output['status'] = 'ok';
                $output['hzId'] = $model->getId();
            }
        } else {
            $output['errors'] = 'no data...';
        }
        return $output;
    }

    //根据医生id查询其填写的会诊信息
    public function loadUserDoctorHuizhenByUserId($userId, $with = null) {
        return UserDoctorHuizhen::model()->getByAttributes(array('user_id' => $userId), $with);
    }

    //根据id查询会诊信息
    public function loadUserDoctorHuizhenById($id) {
        return UserDoctorHuizhen::model()->getById($id);
    }

    //根据医生id查询其填写的转诊信息
    public function loadUserDoctorZhuanzhenByUserId($userId, $with = null) {
        return UserDoctorZhuanzhen::model()->getByAttributes(array('user_id' => $userId), $with);
    }

    //根据id查询转诊信息
    public function loadUserDoctorZhuanzhenById($id) {
        return UserDoctorZhuanzhen::model()->getById($id);
    }

    //保存或者修改医生会诊信息
    public function createOrUpdateDoctorHuizhen($values) {
        $output = array('status' => 'no');
        $userId = $values['user_id'];
        $form = new DoctorHuizhenForm();
        $form->setAttributes($values, true);
        if ($form->validate() === false) {
            $output['status'] = 'no';
            $output['errors'] = $form->getErrors();
            return $output;
        }
        $doctorHz = new UserDoctorHuizhen();
        $model = $this->loadUserDoctorHuizhenByUserId($userId);
        if (isset($model)) {
            $doctorHz = $model;
        }
        $attributes = $form->getSafeAttributes();
        $doctorHz->setAttributes($attributes, true);
        if ($doctorHz->save() === false) {
            $output['status'] = 'no';
            $output['errors'] = $doctorHz->getErrors();
        } else {
            $output['status'] = 'ok';
            $output['hzId'] = $doctorHz->getId();
        }
        return $output;
    }

    public function createOrUpdateDoctorZhuanzhen($values) {
        $output = array('status' => 'no');
        $userId = $values['user_id'];
        $form = new DoctorZhuanzhenForm();
        $form->setAttributes($values, true);
        if ($form->validate() === false) {
            $output['status'] = 'no';
            $output['errors'] = $form->getErrors();
            return $output;
        }
        $doctorZz = new UserDoctorZhuanzhen();
        $model = $this->loadUserDoctorZhuanzhenByUserId($userId);
        if (isset($model)) {
            $doctorZz = $model;
        }
        $attributes = $form->getSafeAttributes();
        $doctorZz->setAttributes($attributes, true);
        if ($doctorZz->save() === false) {
            $output['status'] = 'no';
            $output['errors'] = $doctorZz->getErrors();
        } else {
            $output['status'] = 'ok';
            $output['zzId'] = $doctorZz->getId();
        }
        return $output;
    }

    /**
     * 专家签约
     * @param UserDoctorProfile $model
     */
    public function doctorContract(UserDoctorProfile $model) {
        if (isset($model)) {
            if (is_null($model->date_contracted)) {
                $model->date_contracted = date('Y-m-d H:i:s');
                $model->update(array('date_contracted'));
            }
        }
    }

}
