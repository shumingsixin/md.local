<?php

/**
 * This is the model class for table "region_state".
 *
 * The followings are the available columns in table 'region_state':
 * @property integer $id
 * @property string $country_name
 * @property string $country_code
 * @property string $code
 * @property string $name
 * @property string $name_cn
 * @property integer $nest_level
 * @property string $description
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 */
class RegionState extends EActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'region_state';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nest_level', 'numerical', 'integerOnly' => true),
            array('country_name, code, name, name_cn', 'length', 'max' => 45),
            array('country_code', 'length', 'max' => 3),
            array('description', 'length', 'max' => 255),
            array('date_created, date_updated, date_deleted', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, country_name, country_code, code, name, name_cn, nest_level, description, date_created, date_updated, date_deleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'cities' => array(self::HAS_MANY, 'RegionCity', 'state_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'country_name' => 'Country Name',
            'country_code' => 'Country Code',
            'code' => 'Code',
            'name' => 'Name',
            'name_cn' => 'Name Cn',
            'nest_level' => 'Nest Level',
            'description' => 'Description',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
            'date_deleted' => 'Date Deleted',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('country_name', $this->country_name, true);
        $criteria->compare('country_code', $this->country_code, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('name_cn', $this->name_cn, true);
        $criteria->compare('nest_level', $this->nest_level);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('date_updated', $this->date_updated, true);
        $criteria->compare('date_deleted', $this->date_deleted, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RegionState the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function getAllByCountryCode($code) {
        $criteria = new CDbCriteria();
        $criteria->addCondition('t.date_deleted is NULL');
        $criteria->compare('country_code', $code);
        $criteria->order = 't.display_order ASC';
        return $this->findAll($criteria);
    }

    public function getAllByCountryId($id) {
        return $this->getAllByAttributes(array('country_id' => $id));
    }
    
    public function getListStateByCountryId($countryId){
        $criteria = new CDbCriteria();
        $criteria->select="id,name";
        $criteria->addCondition("t.date_deleted is NULL");
        $criteria->order="t.display_order ASC";
        $criteria->compare("country_id", $countryId);
        $criteria->distinct = true;
            
        return $this->findAll($criteria);
    }

    /*
      public function getAllByIds($ids) {
      if (is_array($ids) === false) {
      $ids = array($ids);
      }
      $criteria = new CDbCriteria;
      $criteria->addCondition('date_deleted is NULL');
      $criteria->addInCondition('id', $ids);
      $criteria->order = "FIELD(t.id," . arrayToCsv($ids) . ")";

      return $this->findAll($criteria);
      }
     */
    /*     * ****** Accessors ****** */

    public function getCities() {
        if ($this->cities === null) {
            $this->cities = RegionCity::model()->getAllByStateId($this->id);
        }
        return $this->cities;
    }

    public function getName($lang='cn') {
        if ($lang == 'cn')
            return $this->name_cn;
        else
            return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

}
