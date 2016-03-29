<?php

class DiseaseManager {

    public function loadDiseaseById($id, $with = null) {
        return Disease::model()->getById($id, $with);
    }

    //获取疾病分类
    public function loadDiseaseCategoryList() {
        $models = DiseaseCategory::model()->getAllByInCondition('t.app_version', 7);
        return $models;
    }

}
