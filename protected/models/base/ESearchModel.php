<?php

abstract class ESearchModel {

    public $model;
    public $alias = 't';
    public $select = '*';
    public $with;
    public $order;
    public $limit;
    public $offset;
    public $searchInputs;
    public $queryParams;
    public $criteria;
    public $output;

    //@abstract method to be implemented.
    abstract function model();

    //@abstract method to be implemented.
    abstract function addQueryConditions();

    /**
     * 
     * @param array $searchInputs
     */
    public function __construct(array $searchInputs, $with = null) {
        $this->searchInputs = $searchInputs;
        $this->with = $with;
        $this->limit = 10;
        $this->offset = 0;
        $this->queryParams = array();
        $this->model();
        $this->prepareParameters();
        $this->buildQueryCriteria();
    }

    public function search() {
        $this->createOutput();

        return $this->output;
    }

    public function count() {
        return $this->model->count($this->criteria);
    }

    public function addSearchCondition($condition) {
        $this->criteria->addCondition($condition);
    }

    //@Implement.
    /**
     * This method specifies the seach parameters in the request.
     * i.e. name, age.
     * @return array.
     */
    public function getQueryFields() {
        return array();
    }

    //@Implement.
    public function buildQueryCriteria() {
        $this->criteria = new CDbCriteria();
        $this->criteria->alias = $this->alias;
        $this->setSelect($this->select);
        $this->criteria->with = $this->with;
        //@abstract method to be implemented.
        $this->addQueryConditions();

        $this->buildCriteriaQueryOptions();
    }

    public function prepareParameters() {
        $this->parseSearchInputs();
        $this->parseQueryOptions($this->searchInputs);
    }

    protected function createOutput() {
        $this->output = $this->model->findAll($this->criteria);
    }

    protected function parseSearchInputs() {
        $queryFields = $this->getQueryFields();
        if (arrayNotEmpty($queryFields)) {
            foreach ($queryFields as $field) {
                if (isset($this->searchInputs[$field])) {
                    if (strIsEmpty($this->searchInputs[$field]) === false) {
                        $this->queryParams[$field] = trim($this->searchInputs[$field]);
                    }
                }
            }
        }
    }

    protected function parseQueryOptions($querystring) {
        // order by.
        if (isset($querystring['order'])) {
            $order = $querystring['order'];
        } else {
            $order = 't.id';
        }
        $this->setOrder($order);

        // limit of pageSize.
        if (isset($querystring['limit'])) {
            $limit = intval($querystring['limit']);
            //$this->queryOptions['limit'] = $querystring['limit'];
        } elseif (isset($querystring['pagesize'])) {
            $limit = intval($querystring['pagesize']);
        } else {
            $limit = $this->limit;
        }
        $this->setLimit($limit);

        // offset or page
        if (isset($querystring['offset'])) {
            $offset = intval($querystring['offset']);
        } elseif (isset($querystring['page'])) {
            // pageSize=10, page=2 => offset=10 (starts from 11th record in db.)
            $offset = (intval($querystring['page']) - 1) * $this->limit;
        } else {
            $offset = 0;
        }
        $this->setOffset($offset);
    }

    protected function buildCriteriaQueryOptions() {
        $this->criteria->order = $this->order;
        $this->criteria->limit = $this->limit;
        $this->criteria->offset = $this->offset;
    }

    protected function hasQueryParams() {
        return arrayNotEmpty($this->queryParams);
    }

    /**
     * overwrite this method to customize select fields in the sql.
     * @param array $fields
     */
    public function setSelectFields(array $fields) {
        if (arrayNotEmpty($fields)) {
            foreach ($fields as &$field) {
                $field = $this->alias . '.' . $field;
            }
            $this->select = implode(',', $fields);
            $this->setSelect($this->select);
        }
    }

    public function setOrder($order) {
        if (strContains($order, '.')) {
            $this->order = $order;
        } else {
            $this->order = $this->alias . '.' . $order;
        }
    }

    public function setLimit($n) {
        $limit = intval($n);
        if ($limit < 0) {
            $limit = 0;
        }
        $this->limit = $limit;
    }

    public function setOffset($n) {
        $offset = intval($n);
        if ($offset < 0) {
            $offset = 0;
        }
        $this->offset = $offset;
    }

    public function setSelect($v) {
        $this->criteria->select = $v;
    }

}
