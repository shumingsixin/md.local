<?php

class ApiViewIndex extends EApiViewService {

    private $banners;

    public function __construct() {
        parent::__construct();
        $this->results = new stdClass();
    }

    protected function loadData() {
        $this->loadDoctors();
        $this->loadBanners();
        $this->setUrl();
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

    private function loadDoctors() {
        $doctorIds = $this->getDoctorIdArray(date('w'));
        $criteria = new CDbCriteria();
        $criteria->select = '*';
        $criteria->addCondition('t.date_deleted is NULL');
        $criteria->addInCondition('t.id', $doctorIds);
        $criteria->with = 'doctorHospital';
        $models = Doctor::model()->findAll($criteria);
        if (arrayNotEmpty($models)) {
            $this->setDoctors($models);
        }
    }

    private function setDoctors(array $models) {
        foreach ($models as $model) {
            $hp = $model->doctorHospital;
            $str = $model->getHospitalName() . $model->getHpDeptName() . '的' . $model->getName() . '医生已签约';
            if (isset($hp)) {
                $str = $hp->short_name . $model->getHpDeptName() . '的' . $model->getName() . '医生已签约';
            }
            $this->results->doctors[] = $str;
        }
    }

    private function loadBanners() {
        if (is_null($this->banners)) {
            $this->setBanners();
        }
    }

    private function setBanners() {
        $data = array(
            array(
                'pageTitle' => '名医主刀大事记',
                'actionUrl' => 'http://md.mingyizhudao.com/mobiledoctor/home/page/view/bigEvent',
                'imageUrl' => 'http://7xsq2z.com2.z0.glb.qiniucdn.com/146485919961731',
            ),
            array(
                'pageTitle' => '名医主刀入选50强榜单',
                'actionUrl' => 'http://md.mingyizhudao.com/mobiledoctor/home/page/view/newList',
                'imageUrl' => 'http://7xsq2z.com2.z0.glb.qiniucdn.com/146485929661479',
            ),
            array(
                'pageTitle' => '达芬奇机器人',
                'actionUrl' => 'http://md.mingyizhudao.com/mobiledoctor/home/page/view/robot',
                'imageUrl' => 'http://7xsq2z.com2.z0.glb.qiniucdn.com/146485938425858',
            )
        );

        $this->results->banners = $data;
    }

    private function getDoctorIdArray($day) {
        $array = array('1' => array('112', '1177', '3149', '2979', '137'),
            '2' => array('3007', '3087', '3146', '3055', '3110'),
            '3' => array('1030', '3061', '3017', '3018', '3165'),
            '4' => array('68', '3175', '65', '3100', '3025'),
            '5' => array('290', '130', '359', '3050', '3049'),
            '6' => array('3173', '2999', '270', '3106', '3102'),
            '0' => array('3105', '3004', '3174', '3027', '2992')
        );
        return $array[$day];
    }

    /*
     * 填充首页 签约专家列表，加入名医公益，了解名医主刀URL 
     */

    private function setUrl() {
        $this->results->publicWelfareUrl = "http://md.mingyizhudao.com/mobiledoctor/home/page/view/mygy";
        $this->results->doctorUrl = Yii::app()->createAbsoluteUrl('/apimd/contractdoctor');
        $this->results->joinUrl = "http://md.mingyizhudao.com/mobiledoctor/home/page/view/myzd";
    }

}

?>
