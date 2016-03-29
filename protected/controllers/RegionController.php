<?php

class RegionController extends WebsiteController {

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('loadStates', 'loadCities'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionLoadStates() {
        $this->headerUTF8();
        $regionMgr = new RegionManager();
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $regionStates = $regionMgr->getAllStatesByCountryId($id);
        } else if (isset($_GET['code'])) {
            $code = $_GET['code'];
            $regionStates = $regionMgr->getAllStatesByCountryCode($code);
        }

        if (is_array($regionStates) && count($regionStates) > 0) {
            $listData = CHtml::listData($regionStates, 'id', 'name_cn');
            if (count($listData) === 1) {
                foreach ($listData as $id => $name) {
                    echo CHtml::tag('option', array('value' => $id), CHtml::encode($name), true);
                }
            } else {
                echo CHtml::tag('option', array('value' => ''), CHtml::encode('省份或地区'), true);
                foreach ($listData as $id => $name) {
                    echo CHtml::tag('option', array('value' => $id), CHtml::encode($name), true);
                }
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('省份或地区'), true);
        }
    }

    public function actionLoadCities($state = null, $prompt = '选择城市') {
        $this->headerUTF8();
        $regionMgr = new RegionManager();
        //$promptText = '-- 选择城市 --';
        $promptText = $prompt;
        $output = '';
        $models = null;
        if (isset($_GET['country'])) {  //get by country.
            $countryId = $_GET['country'];
            $models = $regionMgr->getAllCitiesByCountryId($countryId);
        } else if (isset($_GET['state'])) { //get by state.
            $stateId = $_GET['state'];
            $models = $regionMgr->getAllCitiesByStateId($stateId);
        }

        if (is_array($models)) {
            if (count($models) == 1) {
                $listData = CHtml::listData($models, 'id', 'name_cn');
            //    $output.= CHtml::tag('option', array('value' => ''), CHtml::encode($promptText), true); // jQuery.mobile bug. 如果只有一个option， 无法选中。
                foreach ($listData as $id => $name) {
                    $output.= CHtml::tag('option', array('value' => $id), CHtml::encode($name), true);
                }
            } else if (count($models) > 1) {
                $listData = CHtml::listData($models, 'id', 'name_cn');
                $output.= CHtml::tag('option', array('value' => ''), CHtml::encode($promptText), true);
                foreach ($listData as $id => $name) {
                    $output.= CHtml::tag('option', array('value' => $id), CHtml::encode($name), true);
                }
            }
        } else {
            $output = CHtml::tag('option', array('value' => ''), CHtml::encode($promptText), true);
        }
        echo $output;

        Yii::app()->end();
    }

    /*
      public function actionLoadLocationsByName($name, $lang='cn') {
      if ($name != null) {
      $regionMgr = new RegionManager();
      $countries = $regionMgr->getCountriesStartWithName($name);
      $cities = $regionMgr->getCitiesStartWithName($name);

      if ($lang == 'en') {
      //$list1 = arrayExtractKeyValue($countries, 'id', 'name');
      //$list2 = arrayExtractKeyValue($cities, 'id', 'name');
      $list1 = arrayExtractValue($countries, 'name');
      $list2 = arrayExtractValue($cities, 'name');
      } else {
      // $list1 = arrayExtractKeyValue($countries, 'id', 'name_cn');
      // $list2 = arrayExtractKeyValue($cities, 'id', 'name_cn');
      $list1 = arrayExtractValue($countries, 'name_cn');
      $list2 = arrayExtractValue($cities, 'name_cn');
      }
      $list = array_unique(array_merge($list1, $list2));  //merge array and remove duplicates.
      $data = array();
      foreach ($list as $key => $value) {
      //$temp = array('id' => $key, 'name' => $value);
      $temp = array('name' => $value);
      $data[] = $temp;
      }

      $this->renderJsonOutput($data);
      Yii::app()->end();
      }
      }
     */
}
