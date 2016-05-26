<?php

class ApiViewState extends EApiViewService {

    private $country_id = 1;

    public function __construct() {
        parent::__construct();
        $this->results = new stdClass();
    }

    protected function loadData() {
        $this->loadState();
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

    public function loadState() {
        $criteria = new CDbCriteria;
        $criteria->select = 's.id,s.name';
        $criteria->join = 'LEFT JOIN hospital h ON h.id = t.hospital_id LEFT JOIN region_state s ON h.state_id = s.id';
        $criteria->distinct = true;
        $criteria->compare('t.is_contracted', '1');
        $criteria->addCondition('t.`date_deleted` IS NULL');
        //$criteria->addCondition('t.`user_id` IS NOT NULL');
        $criteria->group = 's.id';
        $criteria->having = 's.id IS NOT NULL';
        $states = CHtml::listData(Doctor::model()->findAll($criteria), 'id', 'name');
        $this->results->stateList = $states;
    }

}
