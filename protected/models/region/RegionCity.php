<?php

/**
 * This is the model class for table "region_city_test".
 *
 * The followings are the available columns in table 'region_city_test':
 * @property integer $id
 * @property string $country_name
 * @property string $country_code
 * @property string $state_name
 * @property integer $state_id
 * @property string $code
 * @property string $name
 * @property string $name_cn
 * @property string $description
 * @property string $image_url
 * @property string $tn_url
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 */
class RegionCity extends EActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'region_city';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('state_id', 'numerical', 'integerOnly' => true),
            array('country_name, state_name, name, name_cn', 'length', 'max' => 45),
            array('country_code', 'length', 'max' => 3),
            array('code', 'length', 'max' => 20),
            array('description, image_url, tn_url', 'length', 'max' => 255),
            array('date_created, date_updated, date_deleted', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, country_name, country_code, state_name, state_id, code, name, name_cn, description, image_url, tn_url, date_created, date_updated, date_deleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
           /* 'cityDisplayPhoto' => array(self::HAS_ONE, 'RegionCityImage', 'city_id',
                'order' => 'cityDisplayPhoto.display_order',
                'on' => 'cityDisplayPhoto.date_deleted is NULL'),
            */
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
            'state_name' => 'State Name',
            'state_id' => 'State',
            'code' => 'Code',
            'name' => 'Name',
            'name_cn' => 'Name Cn',
            'description' => 'Description',
            'image_url' => 'Image Url',
            'tn_url' => 'Tn Url',
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
        $criteria->compare('state_name', $this->state_name, true);
        $criteria->compare('state_id', $this->state_id);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('name_cn', $this->name_cn, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('image_url', $this->image_url, true);
        $criteria->compare('tn_url', $this->tn_url, true);
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
     * @return RegionCityTest the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /*     * ****** Query Methods ******* */

    public function getAllByCountryCode($code) {
        $criteria = new CDbCriteria();
        $criteria->addCondition('t.date_deleted is NULL');
        $criteria->compare('country_code', $code);
        $criteria->order = "t.display_order";

        return $this->findAll($criteria);
    }

    public function getAllByStateId($stateId) {
        $models = $this->getAllByAttributes(array('state_id' => $stateId));
        return $models;
    }

    public function getListCityByStateId($stateId){
        $criteria = new CDbCriteria();
        $criteria->select="id,name";
        $criteria->addCondition("t.date_deleted is NULL");
        $criteria->order="t.display_order ASC";
        $criteria->compare("state_id", $stateId);
            
        return $this->findAll($criteria);
    }
    
    public function getListCityByCountryId($countryId){
        $criteria = new CDbCriteria();
        $criteria->select="id,name";
        $criteria->addCondition("t.date_deleted is NULL");
        $criteria->order="t.display_order ASC";
        $criteria->compare("country_id", $countryId);
            
        return $this->findAll($criteria);
    }
    
    /*
    public function getAllByIds($ids) {
        if (is_array($ids) === false) {
            $ids = array($ids);
        }
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.date_deleted is NULL');
        $criteria->addInCondition('id', $ids);
        $criteria->order = "FIELD(t.id," . arrayToCsv($ids) . ")";

        return $this->findAll($criteria);
    }
     * 
     */

    public function getAbsoluteUrlDisplayPhoto($thumbnail=false) {
        if (isset($this->cityDisplayPhoto)) {
            if ($thumbnail) {
                return $this->cityDisplayPhoto->getAbsoluteThumbnailUrl();
            } else {
                return $this->cityDisplayPhoto->getAbsoluteImageUrl();
            }
        }else
            return RegionCityImage::getAbsoluteUrlDefaultImage();
    }

    /*     * ****** Accessors ****** */

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
