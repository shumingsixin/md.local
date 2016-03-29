<?php

/**
 * This is the model class for table "disease".
 *
 * The followings are the available columns in table 'disease':
 * @property integer $id
 * @property string $name
 * @property integer $category_id
 * @property string $description
 * @property integer $display_order
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 */
class Disease extends EActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'disease';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, date_created', 'required'),
            array('category_id, display_order', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 20),
            array('description', 'length', 'max' => 500),
            array('date_updated, date_deleted', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, category_id, description, display_order, date_created, date_updated, date_deleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'diseaseDoctors' => array(self::MANY_MANY, 'Doctor', 'disease_doctor_join(disease_id, doctor_id)'),
            'diseaseExpteams' => array(self::MANY_MANY, 'ExpertTeam', 'disease_expteam_join(disease_id, expteam_id)'),
            'diseaseHospitals' => array(self::MANY_MANY, 'Hospital', 'disease_hospital_join(disease_id, hospital_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'category_id' => 'Category',
            'description' => 'Description',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('description', $this->description, true);
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
     * @return Disease the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /*     * ****** Accessors ******* */

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

}
