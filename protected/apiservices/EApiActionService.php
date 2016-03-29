<?php

abstract class EApiActionService {

    const RESPONSE_NO = 'no';
    const RESPONSE_OK = 'ok';   //200
    const RESPONSE_NO_DATA = 'No data'; //400
    const RESPONSE_NOT_FOUND = 'Not found'; //404
    const RESPONSE_VALIDATION_ERRORS = 'Validation errors'; //400
    const RESPONSE_INVALID_PARAMETERS = 'Invalid parameters'; //

    public $post;  // from $_POST.
    public $formModel;
    public $model;
    public $errors;
    public $scenario;
    public $output;

    public function __construct($request = null, $param2 = null, $param3 = null, $param4 = null) {
        $this->requestedValues = $request;
    }

    public function run() {
        try {
            $this->loadData();
            $this->createOutput();
        } catch (CDbException $cdbex) {
            $this->output = array('status' => self::RESPONSE_NO, 'error' => '数据错误');
        } catch (CException $cex) {
            $this->output = array('status' => self::RESPONSE_NO, 'error' => $cex->getMessage());
        }
        return $this->output;
    }

    protected function createOuptut() {
        if (is_null($this->output)) {
            $this->output = array();
            if (arrayNotEmpty($this->errors)) {
                // has error.
                $this->output['status'] = self::RESPONSE_VALIDATION_ERRORS;
                $this->output['errors'] = $this->errors;
            } else {
                // no error.
                $this->output['status'] = self::RESPONSE_OK;
                // pass model data to $output?
            }
        }
    }

    /*
      public function prepareData() {
      $this->initFormModel();
      }
     * 
     */

    //public function process() {}
    // protected abstract function initFormModel($param1 = null, $param2 = null, $param3 = null, $param4 = null);

    public function save() {
        //   $form = new BookingForm();
        //  $form->setAttributes($this->requestValues);
        $bookingMgr = new BookingManager();
        $this->formModel = $bookingMgr->createBookingForm($this->requestvalues);
        if ($this->formModel->hasErrors() === false) {
            $this->model = $bookingMgr->createBookingModel($this->formModel->attributes);
            if ($this->model->hasErrors()) {
                $this->errors = $this->model->getErrors();
            }
        }
    }

    public function update() {
        
    }

    public function delete() {
        
    }

    public function getModel() {
        return $this->model;
    }

    public function isSuccess() {
        return (arrayNotEmpty($this->errors) === false);
    }

    public function getErrors() {
        return $this->errors;
    }

    public function set() {
        
    }

    public function setRequestedaValues($v) {
        $this->requestedValues = $v;
    }

}
