<?php

/**
 * This is the model class for table "region_city_image".
 *
 * The followings are the available columns in table 'region_city_image':
 * @property integer $id
 * @property integer $city_id
 * @property string $image_url
 * @property string $image_type
 * @property string $tn_url
 * @property integer $display_order
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 *
 * The followings are the available model relations:
 * @property RegionCity $city
 */
class RegionCityImage extends ImageModel {
    const DEFAULT_IMAGE_PATH='location.jpg';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'region_city_image';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('city_id', 'required'),
            array('city_id, display_order', 'numerical', 'integerOnly' => true),
            array('image_url, tn_url', 'length', 'max' => 255),
            array('image_type', 'length', 'max' => 10),
            array('date_created, date_updated, date_deleted', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, city_id, image_url, image_type, tn_url, display_order, date_created, date_updated, date_deleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'city' => array(self::BELONGS_TO, 'RegionCity', 'city_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'city_id' => 'City',
            'image_url' => 'Image Url',
            'image_type' => 'Image Type',
            'tn_url' => 'Tn Url',
            'display_order' => 'Display Order',
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
        $criteria->compare('city_id', $this->city_id);
        $criteria->compare('image_url', $this->image_url, true);
        $criteria->compare('image_type', $this->image_type, true);
        $criteria->compare('tn_url', $this->tn_url, true);
        $criteria->compare('display_order', $this->display_order);
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
     * @return RegionCityImage the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public static function getAbsoluteUrlDefaultImage() {
        return Yii::app()->getBaseUrl(true) . '/' . Yii::app()->params['regionImagePath'] . self::DEFAULT_IMAGE_PATH;
    }


}
