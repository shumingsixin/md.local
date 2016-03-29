<?php

/**
 * This is the model class for table "region_country_test".
 *
 * The followings are the available columns in table 'region_country_test':
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $name_cn
 * @property integer $nest_level
 * @property string $description
 * @property string $phone_code
 * @property string $image_url
 * @property string $tn_url
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 */
class RegionCountry extends EActiveRecord {
    const DEFAULT_IMAGE_PATH='location.jpg';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'region_country';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nest_level', 'numerical', 'integerOnly' => true),
            array('code', 'length', 'max' => 3),
            array('name, name_cn', 'length', 'max' => 45),
            array('description, image_url, tn_url', 'length', 'max' => 255),
            array('phone_code', 'length', 'max' => 5),
            array('date_created, date_updated, date_deleted', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, code, name, name_cn, nest_level, description, phone_code, image_url, tn_url, date_created, date_updated, date_deleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'rcStates' => array(self::HAS_MANY, 'RegionState', 'country_code', 'order' => 'rcStates.display_order ASC'),
            'rcCities' => array(self::HAS_MANY, 'RegionCity', 'country_code', 'order' => 'rcCities.display_order ASC'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'name_cn' => 'Name Cn',
            'nest_level' => 'Nest Level',
            'description' => 'Description',
            'phone_code' => 'Phone Code',
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
        $criteria->compare('code', $this->code, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('name_cn', $this->name_cn, true);
        $criteria->compare('nest_level', $this->nest_level);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('phone_code', $this->phone_code, true);
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
     * @return RegionCountryTest the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function getByCode($code, $with=null) {
        $model = $this->getByAttributes(array('code' => $code), $with);
        return $model;
    }

    public function getAbsoluteUrlDisplayPhoto($thumbnail=false) {
        if ($thumbnail && $this->getThumbnailUrl() !== null) {
            return $this->getAbsoluteThumbnailUrl();
        } else if ($this->getImageUrl() !== null) {
            return $this->getAbsoluteImageUrl();
        } else {
            return $this->getAbsoluteUrlDefaultImage();
        }
    }

    public function getAbsoluteImageUrl() {
        return Yii::app()->getBaseUrl(true) . '/' . $this->getImageUrl();
    }

    public function getAbsoluteThumbnailUrl() {
        return Yii::app()->getBaseUrl(true) . '/' . $this->getThumbnailUrl();
    }

    public static function getAbsoluteUrlDefaultImage() {
        return Yii::app()->getBaseUrl(true) . '/' . Yii::app()->params['regionImagePath'] . self::DEFAULT_IMAGE_PATH;
    }

    /*     * ****** Accessors ******* */

    public function getStates() {
        if ($this->rcStates === null) {
            $this->rcStates = RegionState::model()->getAllByCountryCode($this->code);
        }
        return $this->rcStates;
    }

    /*
      public function getCities() {
      if($this->cities)
      return $this->cities;
      }
     */

    public function getCode() {
        return $this->code;
    }

    public function getName($lang='cn') {
        if ($lang == 'cn')
            return $this->name_cn;
        else
            return $this->name;
    }

    public function getImageUrl() {
        return $this->image_url;
    }

    public function getThumbnailUrl() {
        return $this->tn_url;
    }

}
