<?php

/**
 * This is the model class for table "hospital".
 *
 * The followings are the available columns in table 'hospital':
 * @property integer $id
 * @property string $name
 * @property string $short_name
 * @property integer $class
 * @property integer $type
 * @property string $description
 * @property string $search_keywords
 * @property string $thumbnail_url
 * @property string $image_url
 * @property integer $country_id
 * @property integer $state_id
 * @property integer $city_id
 * @property string $address
 * @property string $phone
 * @property string $website
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 */
class Hospital extends EActiveRecord {

    const TYPE_POLY = 1; //综合医院
    const TYPE_ZHUANKE = 2; //专科医院
    const TYPE_CANCER = 3; //肿瘤医院
    const CLASS_ONE = 1;   //一级甲等
    const CLASS_TWO = 2;    //二级甲等
    const CLASS_THREE = 3;    //三级甲等

    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return 'hospital';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('class, type, country_id, state_id, city_id', 'numerical', 'integerOnly' => true),
            array('name, search_keywords, thumbnail_url, image_url, address, website', 'length', 'max' => 100),
            array('short_name, phone', 'length', 'max' => 45),
            array('description', 'length', 'max' => 1000),
            array('date_created, date_updated, date_deleted', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, short_name, class, type, description, thumbnail_url, image_url, country_id, state_id, city_id, address, phone, website, date_created, date_updated, date_deleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'hospitalCountry' => array(self::BELONGS_TO, 'RegionCountry', 'country_id'),
            'hospitalState' => array(self::BELONGS_TO, 'RegionState', 'state_id'),
            'hospitalCity' => array(self::BELONGS_TO, 'RegionCity', 'city_id'),
            'hospitalDoctors' => array(self::HAS_MANY, 'Doctor', 'hospital_id'),
            'hospitalFaculties' => array(self::MANY_MANY, 'Faculty', 'faculty_hospital_join(faculty_id, hospital_id)'), //@REMOVE. 
            //'hospitalDepartments' => array(self::HAS_MANY, "HospitalDepartment", "hospital_id", "order" => "hospitalDepartments.display_order ASC, CONVERT(hospitalDepartments.group USING gbk) ASC")
            'hospitalDepartments' => array(self::HAS_MANY, "HospitalDepartment", "hospital_id", "order" => "hospitalDepartments.display_order, hospitalDepartments.group")
                //  'hospitalFacultyJoin' => array(self::HAS_MANY, 'FacultyHospitalJoin', 'hospital_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'short_name' => 'Short Name',
            'class' => 'Class',
            'type' => 'Type',
            'description' => 'Description',
            'search_keywords' => '搜索关键词',
            'thumbnail_url' => 'Thumbnail Url',
            'image_url' => 'Image Url',
            'country_id' => 'Country',
            'state_id' => 'State',
            'city_id' => 'City',
            'address' => 'Address',
            'phone' => 'Phone',
            'website' => 'Website Url',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('short_name', $this->short_name, true);
        $criteria->compare('class', $this->class);
        $criteria->compare('type', $this->type);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('search_keywords', $this->search_keywords, true);
        $criteria->compare('thumbnail_url', $this->thumbnail_url, true);
        $criteria->compare('image_url', $this->image_url, true);
        $criteria->compare('country_id', $this->country_id);
        $criteria->compare('state_id', $this->state_id);
        $criteria->compare('city_id', $this->city_id);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('website', $this->website, true);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('date_updated', $this->date_updated, true);
        $criteria->compare('date_deleted', $this->date_deleted, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
                'pageVar' => 'page'
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Hospital the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /*     * *******  Query Methods  ******* */

    public function loadHospitalsByCity($city = null) {
        // get hospitals by city.
        $criteria = new CDbCriteria();
        $criteria->addCondition("t.date_deleted is NULL");
        $criteria->compare("t.is_show", "1");
        // Get all by city_id.
        if (isset($city)) {
            $criteria->compare("city_id", $city);
        }
        $criteria->order = "t.name ASC";
        $criteria->select = "t.id, t.name, t.short_name, t.class, t.type, t.city_id, t.phone, t.address, t.website";
        //$criteria->with = array("hospitalDepartments", "hospitalCity");
        $criteria->with = array("hospitalDepartments");
        $hospitals = Hospital::model()->findAll($criteria);
        return $hospitals;
    }

    public function getAllByDiseaseId($did, $with = null, $options = null) {
        $criteria = new CDbCriteria;
        $criteria->select = 't.*';
        $criteria->distinct = FALSE;
        $criteria->join = 'left join disease_hospital_join j on (t.`id`=j.`hospital_id`)';
        if (isset($with)) {
            $criteria->with = $with;
        }
        $criteria->addCondition("j.disease_id=:disId");
        $criteria->params[":disId"] = $did;
        $criteria->order = "j.`display_order` ASC";
        if (isset($options['limit'])) {
            $criteria->limit = $options['limit'];
        }
        if (isset($options['offset'])) {
            $criteria->offset = $options['offset'];
        }
        $criteria->distinct = true;
        return $this->findAll($criteria);
    }

    /*     * ******* Display Methods ******* */

    public function getAbsUrlAvatar($thumbnail = false) {
        if (isset($this->image_url) && $this->image_url != '') {
            $url = $this->image_url;
            if (strStartsWith($url, 'http')) {
                // $url is already an absolute internet url.
                return $url;
            }
            // $url is relative path.
//            if (strStartsWith($url, '/') === false) {
//                // append '/' to the head of $url.
//                $url = '/' . $url;
//            }
//            // append 'http://domain.com' to the head of $url.
            return $this->getRootUrl() . $url;
        } else {
            //default doctor avatar image.
            return 'http://mingyihz.oss-cn-hangzhou.aliyuncs.com/h%2Fhospital_default_128x128.png';
        }
    }

    public function getRootUrl() {
        if (isset($this->base_url) && ($this->base_url != '')) {
            return $this->base_url;
        } else {
            return Yii::app()->getBaseUrl(true) . '/';
        }
    }

    /*
      public function getAbsUrlAvatar($thumbnail = false) {
      $imageUrl = null;
      if ($thumbnail) {
      $imageUrl = $this->getThumbnailUrl();
      } else {
      $imageUrl = $this->getImageUrl();
      }
      if (strIsEmpty($imageUrl)) {
      //$imageUrl = 'http://mingyihz.oss-cn-hangzhou.aliyuncs.com/h/hospital_default.svg';
      $imageUrl = 'http://mingyihz.oss-cn-hangzhou.aliyuncs.com/h%2Fhospital_default_128x128.png';
      }
      return $imageUrl;
      }
     * 
     */

    public function getType() {
        $options = $this->getOptionsType();
        if (isset($options[$this->type])) {
            return $options[$this->type];
        } else
            return '';
    }

    public function getClass() {
        $options = $this->getOptionsClass();
        if (isset($options[$this->class])) {
            return $options[$this->class];
        } else
            return '';
    }

    public function getOptionsType() {
        $options = array(self::TYPE_POLY => '综合医院', self::TYPE_CANCER => '肿瘤医院', self::TYPE_ZHUANKE => '专科医院');
        return $options;
    }

    public function getOptionsClass() {
        $options = array(self::CLASS_THREE => '三级甲等', self::CLASS_TWO => '二级甲等', self::CLASS_ONE => '一级甲等');
        return $options;
    }

    public function getCountryName() {
        if (isset($this->hospitalCountry)) {
            return $this->hospitalCountry->getName();
        } else {
            return '';
        }
    }

    public function getStateName() {
        if (isset($this->hospitalState)) {
            return $this->hospitalState->getName();
        } else {
            return '';
        }
    }

    public function getCityName() {
        if (isset($this->hospitalCity)) {
            return $this->hospitalCity->getName();
        } else {
            return '';
        }
    }

    /*     * ****** Accessors ******* */

    public function getState() {
        return $this->hospitalState;
    }

    public function getCity() {
        return $this->hospitalCity;
    }

    public function getDoctors() {
        return $this->hospitalDoctor;
    }

    public function getFaculties() {
        return $this->hospitalFaculties;
    }

    public function getDepartments() {
        return $this->hospitalDepartments;
    }

    public function getName($short = false) {
        if ($short)
            return $this->short_name;
        else
            return $this->name;
    }

    public function getThumbnailUrl() {
        if (is_null($this->thumbnail_url) || $this->thumbnail_url == '') {
            return null;
        } elseif (strStartsWith($this->thumbnail_url, 'http://')) {
            return $this->thumbnail_url;
        } else {
            return Yii::app()->baseUrl . '/' . $this->thumbnail_url;
        }
    }

    public function getImageUrl() {
        if (is_null($this->image_url) || $this->image_url == '') {
            return null;
        } elseif (strStartsWith($this->image_url, 'http://')) {
            return $this->image_url;
        } else {
            return Yii::app()->baseUrl . '/' . $this->image_url;
        }
    }

    public function getDescription($ntext = false) {
        return $this->getTextAttribute($this->description, $ntext);
    }

    public function getPhone($nullStr = "") {
        return $this->getNullAttribute($this->phone);
    }

    public function getAddress($nullStr = "") {
        return $this->getNullAttribute($this->address);
    }

    public function getWebsite() {
        return $this->getNullAttribute($this->address);
    }

}
