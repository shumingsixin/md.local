<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ApiViewPatientSearch
 *
 * @author shuming
 */
class ApiViewPatientSearch extends EApiViewService {

    private $createorId;
    private $patientMgr;
    private $patients;
    private $name;

    //初始化类的时候将参数注入
    public function __construct($createorId, $name) {
        parent::__construct();
        $this->name = $name;
        $this->createorId = $createorId;
        $this->patientMgr = new PatientManager();
        $this->patients = null;
    }

    protected function createOutput() {
        if (is_null($this->output)) {
            $this->output = array(
                'status' => self::RESPONSE_OK,
                'errorCode' => 0,
                'errorMsg' => 'success',
                'results' => $this->results,
            );
        }
    }

    protected function loadData() {
        $this->loadPatients();
    }

    private function loadPatients() {
        $criteria = new CDbCriteria();
        $criteria->compare('t.creator_id', $this->createorId);
        $criteria->addSearchCondition('t.name', $this->name);
        $criteria->addCondition('t.date_deleted is NULL');
        $models = PatientInfo::model()->findAll($criteria);
        if (arrayNotEmpty($models)) {
            $this->setPatientList($models);
        }
        $this->results->patientList = $this->patients;
    }

    //查询到的数据过滤
    private function setPatientList(array $models) {
        foreach ($models as $model) {
            $data = new stdClass();
            $data->id = $model->getId();
            $data->name = $model->getName();
            $data->age = $model->getAge();
            $data->ageMonth = $model->getAgeMonth();
            $data->cityName = $model->getCityName();
            $data->gender = $model->getGender();
            $data->mobile = $model->getMobile();
            $data->diseaseName = $model->getDiseaseName();
            $data->dateUpdated = $model->getDateUpdated('m月d日');
            $data->actionUrl = Yii::app()->createAbsoluteUrl('/apimd/patientinfo/' . $model->getId());
            $this->patients[] = $data;
        }
    }

}
