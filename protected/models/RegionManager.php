<?php

class RegionManager {

    /**
     * 
     * @param integer $id   City.id
     * @return \ILocationCity
     */
    public function loadILocationCity($id) {
        $model = $this->loadLocationCity($id);
        $icity = new ILocationCity();
        $icity->initModel($model);
        return $icity;
    }

    /**
     * 
     * @param integer $id City.id
     * @param type $with
     * @return type
     * @throws CHttpException
     */
    public function loadLocationCity($id, $with = null) {
        $model = RegionCity::model()->getById($id, $with);
        if ($model === null) {
            throw new CHttpException(404, 'Record is not found.');
        }
        return $model;
    }

    /**
     * Get RegionCountry model by the given country code.
     * @param type $code country code.
     * @param type $with array of model relations
     * @return type RegionCountry
     */
    public function getCountryByCode($code, $with = null) {
        $country = RegionCountry::model()->getByCode($code, $with);
        return $country;
    }

    public function getStateById($stateId, $with = null) {
        $state = RegionState::model()->getById($stateId, $with);
        return $state;
    }

    public function getAllStatesByCountryCode($code) {
        $country = $this->getCountryByCode($code, array('rcStates'));
        if (isset($country)) {
            return $country->getStates();
        } else {
            return null;
        }
    }

    public function getAllStatesByCountryId($id) {
        $country = RegionCountry::model()->getById($id, array('rcStates'));
        if (isset($country)) {
            return $country->getStates();
        } else {
            return null;
        }
    }

    public function getAllCitiesByStateId($stateId) {
        $state = $this->getStateById($stateId, array('cities'));
        if (isset($state)) {
            return $state->getCities();
        }
        return null;
    }

    /**
     * Get array of RegionCity model by the given country code.
     * If country code is invalid, return null.
     * @param type $code country code
     * @return type array of RegionCity model.
     */
    public function getAllCitiesByCountryCode($code) {
        $country = $this->getCountryByCode($code, array('rcCities'));
        if (isset($country))
            return $country->getCities();
        else
            return null;
    }

    public function getAllCitiesByIds($idList) {
        return RegionCity::model()->getAllByIds($idList);
    }

    /**
     * search by exact match of city.name_cn or city.name.
     * @param type $name of RegionCity.
     * @return type aray of RegionCity models
     */
    public function getCityByExactName($name) {
        $criteria = new CDbCriteria();
        $criteria->addCondition('t.date_deleted is NULL');
        $criteria->addCondition("t.name = '$name' OR t.name_cn = '$name'");
        $criteria->order = 't.display_order asc';
        return RegionCity::model()->find($criteria);
    }

    /**
     * search by like '%$name$'.
     * any record city.name, city.name_cn, city.code contains the $name will be returned.
     * @param type $name name of city.
     * @return type array of City models
     */
    public function getCitiesBySimilarName($name) {
        $criteria = new CDbCriteria();
        $criteria->addCondition('t.date_deleted is NULL');
        $criteria->addCondition("t.name LIKE '%$name%' OR t.name_cn LIKE '%$name%' OR t.code='$name'");
        $criteria->order = 't.display_order asc';
        return RegionCity::model()->findAll($criteria);
    }

    public function getCountryByExactName($name) {
        $criteria = new CDbCriteria();
        $criteria->addCondition('t.date_deleted is NULL');
        $criteria->addCondition("t.name = '$name' OR t.name_cn = '$name' OR t.alias='$name'");
        $criteria->order = 't.display_order asc';
        return RegionCountry::model()->find($criteria);
    }

    /**
     * search by like '$name%'.
     * any record ctiy.name, city.name_cn, city_code starts with $name will be returned.
     * @param type $name 
     */
    public function getCitiesStartWithName($name) {
        $criteria = new CDbCriteria();
        $criteria->addCondition('t.date_deleted is NULL');
        $criteria->addCondition("t.name LIKE '$name%' OR t.name_cn LIKE '$name%' OR t.code='$name'");
        $criteria->order = 't.display_order asc';
        return RegionCity::model()->findAll($criteria);
    }

    /**
     * search by like '$name%'.
     * any record country.name, country.name_cn, country.alias, country.code starts with $name will be returned.
     * @param type $name 
     */
    public function getCountriesStartWithName($name) {
        $criteria = new CDbCriteria();
        $criteria->addCondition('t.date_deleted is NULL');
        $criteria->addCondition("t.name LIKE '$name%' OR t.name_cn LIKE '$name%' OR t.alias LIKE '$name%' OR t.code='$name'");
        $criteria->order = 't.display_order asc';
        return RegionCountry::model()->findAll($criteria);
    }

    public function getAllCountry() {
        $criteria = new CDbCriteria();
        $criteria->addCondition('t.date_deleted is NULL');
        $criteria->order = 't.display_order ASC';

        return RegionCountry::model()->findAll($criteria);
    }

    public function loadRegionStateById($id, $attributes = null, $with = null) {
        return RegionState::model()->getById($id);
    }

    public function loadRegionCityById($id, $attributes = null, $with = null) {
        return RegionCity::model()->getById($id);
    }

}
