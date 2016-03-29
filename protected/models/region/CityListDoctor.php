<?php

/**
 * This is the model class for table "city_list_doctor".
 *
 * The followings are the available columns in table 'city_list_doctor':
 * @property integer $id
 * @property integer $state_id
 * @property string $state_name
 * @property integer $city_id
 * @property string $city_name
 * @property integer $display_order
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 */
class CityListDoctor extends EActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'city_list_doctor';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('city_id', 'required'),
            array('state_id, city_id, is_hot, display_order', 'numerical', 'integerOnly' => true),
            array('state_name, city_name', 'length', 'max' => 45),
            array('date_created, date_updated, date_deleted', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, state_id, state_name, city_id, city_name, is_hot, display_order, date_created, date_updated, date_deleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'state_id' => 'State',
            'state_name' => 'State Name',
            'city_id' => 'City',
            'city_name' => 'City Name',
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
        $criteria->compare('state_id', $this->state_id);
        $criteria->compare('state_name', $this->state_name, true);
        $criteria->compare('city_id', $this->city_id);
        $criteria->compare('city_name', $this->city_name, true);
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
     * @return CityListDoctor the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }


    /******** Query Methods ********/

    /**
     * 获取所有的城市
     * @return array|CActiveRecord|mixed|null|static
     */
    public function getAllCity(){
        $criteria = new CDbCriteria();
        $criteria->addCondition("t.date_deleted is NULL");
        $criteria->select ='t.id, t.state_id, t.state_name, t.city_id, t.city_name, t.is_hot';
        $criteria->order = 't.display_order ASC';
        return $this->findAll($criteria);
    }

    /**
     * 获取含有专家团队的城市
     * @return array|CActiveRecord|mixed|null|static
     */
    public function getCityHasTeam(){
        $criteria = new CDbCriteria();
        $criteria->addCondition("t.date_deleted is NULL");
        $criteria->addCondition("t.has_team = 1");
        $criteria->select ='t.id, t.state_id, t.state_name, t.city_id, t.city_name, t.is_hot';
        $criteria->order = 't.display_order ASC';
        return $this->findAll($criteria);
    }


    /*     * ****** Accessors ******* */
    public function getIsHot(){
        return $this->is_hot;
    }


    public function getStateId() {
        return $this->state_id;
    }

    public function getStateName() {
        return $this->state_name;
    }

    public function getCityId() {
        return $this->city_id;
    }

    public function getCityName() {
        return $this->city_name;
    }

}
