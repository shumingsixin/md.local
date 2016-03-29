<?php

/**
 * This is the model class for table "disease_category".
 *
 * The followings are the available columns in table 'disease_category':
 * @property integer $id
 * @property integer $cat_id
 * @property string $cat_name
 * @property integer $sub_cat_id
 * @property string $sub_cat_name
 * @property string $description
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 */
class DiseaseCategory extends EActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'disease_category';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date_created', 'required'),
            array('cat_id, sub_cat_id', 'numerical', 'integerOnly' => true),
            array('cat_name, sub_cat_name', 'length', 'max' => 50),
            array('description', 'length', 'max' => 100),
            array('date_updated, date_deleted', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, cat_id, cat_name, sub_cat_id, sub_cat_name, description, date_created, date_updated, date_deleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'dcDiseases' => array(self::HAS_MANY, 'Disease', 'category_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'cat_id' => 'Cat',
            'cat_name' => 'Cat Name',
            'sub_cat_id' => 'Sub Cat',
            'sub_cat_name' => 'Sub Cat Name',
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
        $criteria->compare('cat_id', $this->cat_id);
        $criteria->compare('cat_name', $this->cat_name, true);
        $criteria->compare('sub_cat_id', $this->sub_cat_id);
        $criteria->compare('sub_cat_name', $this->sub_cat_name, true);
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
     * @return DiseaseCategory the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /*     * ******　Accessors ******* */
    public function getDiseases(){
        return $this->dcDiseases;
    }

    public function getCategoryId() {
        return $this->cat_id;
    }

    public function getCategoryName() {
        return $this->cat_name;
    }

    public function getSubCategoryId() {
        return $this->sub_cat_id;
    }

    public function getSubCategoryName() {
        return $this->sub_cat_name;
    }

}
