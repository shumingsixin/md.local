<?php

class ApiViewLocalData extends EApiViewService {

    private $country_id = 1;

    public function __construct() {
        parent::__construct();
    }

    protected function loadData() {
        $this->loadAcademicTitle();
        $this->loadClinicalTitle();
        $this->loadGender();
        $this->loadBookingTravelType();
        $this->loadCity();
        $this->loadDiseaseCategory();
    }

    protected function createOutput() {

        if (is_null($this->output)) {
            $this->results->url = array(
                'smsverifycode' => Yii::app()->createAbsoluteUrl('/apimd/smsverifycode'), //发送验证码
                'userlogin' => Yii::app()->createAbsoluteUrl('/apimd/userlogin'), //登陆地址
                'userpawlogin' => Yii::app()->createAbsoluteUrl('/apimd/userpawlogin'), //密码登陆
                'savepatientbooking' => Yii::app()->createAbsoluteUrl('/apimd/savepatientbooking'), //创建预约
                'savepatient' => Yii::app()->createAbsoluteUrl('/apimd/savepatient'), //创建预约
                'patientlist' => Yii::app()->createAbsoluteUrl('/apimd/patientlist'), //我的患者
                'bookinglist' => Yii::app()->createAbsoluteUrl('/apimd/bookinglist'), //发出预约列表
                'doctorbookinglist' => Yii::app()->createAbsoluteUrl('/apimd/doctorbookinglist'), //收到的预约列表
                'patientinfo' => Yii::app()->createAbsoluteUrl('/apimd/view', array('model' => 'patientinfo', 'id' => '')), //患者信息
                'doctorpatientinfo' => Yii::app()->createAbsoluteUrl('/apimd/view', array('model' => 'doctorpatientinfo', 'id' => '')),
                'doctorinfo' => Yii::app()->createAbsoluteUrl('/apimd/doctorinfo'), //查看医生信息
                'saveprofile' => Yii::app()->createAbsoluteUrl('/apimd/saveprofile'), //医生信息保存
                'orderlist' => Yii::app()->createAbsoluteUrl('/apimd/orderlist'), //分批支付信息
                'paymentUrl' => 'http://m.mingyizhudao.com/mobile/order/view?refNo=#&os=#&header=0&footer=0&addBackBtn=0',
                'forgetpassword' => Yii::app()->createAbsoluteUrl('/apimd/forgetpassword'),
                'userregister' => Yii::app()->createAbsoluteUrl('/apimd/userregister'),
                'findView' => 'http://192.168.31.118/new.md/mobiledoctor/home/page/view/findView',
                'citylist' => Yii::app()->createAbsoluteUrl('/apimd/citylist'), //城市列表
                'indexannouncement' => Yii::app()->createAbsoluteUrl('/apimd/indexannouncement'),
                'main' => Yii::app()->createAbsoluteUrl('/apimd/main'), //个人中心数据
                'savedoctoropinion' => Yii::app()->createAbsoluteUrl('/apimd/savedoctoropinion'), //上级医生反馈
                'contractdoctorlist' => Yii::app()->createAbsoluteUrl('/apimd/contractdoctorlist'), //签约专家列表
                'doctordr' => Yii::app()->createAbsoluteUrl('/apimd/doctordr'), //转诊会诊信息展示
                'doctorhzview' => Yii::app()->createAbsoluteUrl('/apimd/doctorhzview'), //会诊信息
                'doctorzzview' => Yii::app()->createAbsoluteUrl('/apimd/doctorzzview'), //转诊信息
                'savedoctorhz' => Yii::app()->createAbsoluteUrl('/apimd/savedoctorhz'), //保存转诊信息
                'savedoctorzz' => Yii::app()->createAbsoluteUrl('/apimd/savedoctorzz'), //保存会诊信息
                'notjoinzz' => Yii::app()->createAbsoluteUrl('/apimd/notjoinzz'), //不参加会诊信息
                'notjoinhz' => Yii::app()->createAbsoluteUrl('/apimd/notjoinhz'), //不参加转诊信息
                'dataversion' => Yii::app()->createAbsoluteUrl('/apimd/dataversion'),
            );

            $this->output = array(
                'status' => self::RESPONSE_OK,
                'errorCode' => 0,
                'errorMsg' => 'success',
                'results' => $this->results,
            );
        }
    }

    public function loadAcademicTitle() {
        $data = StatCode::getOptionsAcademicTitle();
        $this->setAcademicTitle($data);
    }

    private function setAcademicTitle($data) {
        $this->results->academicTitle = $data;
    }

    public function loadClinicalTitle() {
        $data = StatCode::getOptionsClinicalTitle();
        $this->setClinicalTitle($data);
    }

    private function setClinicalTitle($data) {
        $this->results->clinicalTitle = $data;
    }

    public function loadGender() {
        $data = StatCode::getOptionsGender();
        $this->setGender($data);
    }

    private function setGender($data) {
        $this->results->gender = $data;
    }

    public function loadBookingTravelType() {
        $data = StatCode::getOptionsBookingTravelType();
        $this->setBookingTravelType($data);
    }

    private function setBookingTravelType($data) {
        $this->results->bookingTravelType = $data;
    }

    public function loadCity() {
        $data = array();
        $states = CHtml::listData(RegionState::model()->getAllByCountryId($this->country_id), 'id', 'name');
        foreach ($states as $state_id => $state_name) {
            $subCity = array();
            $cities = CHtml::listData(RegionCity::model()->getAllByStateId($state_id), 'id', 'name');
            foreach ($cities as $city_id => $city_name) {
                $subCity[] = array('id' => $city_id, 'city' => $city_name);
            }
            $data[] = array('id' => $state_id, 'state' => $state_name, 'subCity' => $subCity);
        }
        $this->setCity($data);
    }

    private function setCity($data) {
        $this->results->city = $data;
    }

    public function loadDiseaseCategory() {
        $disMgr = new DiseaseManager();
        $models = $disMgr->loadDiseaseCategoryList();
        $navList = array();
        foreach ($models as $model) {
            $data = new stdClass();
            $data->id = $model->getCategoryId();

            $data->name = $model->getCategoryName();
            // sub group.
            $subGroup = new stdClass();
            $subGroup->id = $model->getSubCategoryId();
            $subGroup->name = $model->getSubCategoryName();

            if (isset($navList[$data->id])) {
                $navList[$data->id]->subCat[] = $subGroup;
            } else {

                $navList[$data->id] = $data;
                $navList[$data->id]->subCat[] = $subGroup;
            }
        }
        $this->setDiseaseCategory(array_values($navList));
    }

    private function setDiseaseCategory($data) {
        $this->results->dept = $data;
    }

}
