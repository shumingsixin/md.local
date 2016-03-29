<?php

/**
 * This is the model class for table "location".
 *
 * The followings are the available columns in table 'location':
 * @property integer $id
 * @property string $country
 * @property integer $country_id
 * @property string $state
 * @property integer $state_id
 * @property string $city
 * @property integer $city_id
 * @property string $county
 * @property integer $display_order
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 */
class Location extends EActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'location';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('country_id, state_id, city_id, display_order', 'numerical', 'integerOnly'=>true),
			array('country, state, city, county', 'length', 'max'=>20),
			array('date_created, date_updated, date_deleted', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, country, country_id, state, state_id, city, city_id, county, display_order, date_created, date_updated, date_deleted', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'country' => 'Country',
			'country_id' => 'Country',
			'state' => 'State',
			'state_id' => 'State',
			'city' => 'City',
			'city_id' => 'City',
			'county' => 'County',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('state_id',$this->state_id);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('county',$this->county,true);
		$criteria->compare('display_order',$this->display_order);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('date_deleted',$this->date_deleted,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Location the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /*** get and set Methods ***/
        public function getCountry() {
            return $this->country;
        }
        public function setCountry($v) {
           $this->country = $v;
        }
        
        public function getState() {
            return $this->state;
        }
        public function setState($v) {
            $this->state = $v;
        }
        
        public function getCity() {
            return $this->city;
        }
        public function setCity($v) {
            $this->city = $v;
        }
        
        public function getCounty() {
            return $this->county;
        }
        public function setCounty($v) {
           $this->county = $v;
        }
        
        /***    ***/
        public function getCountryByCountryId($id){
            $criteria = new CDbCriteria();
            $criteria->select="country_id,country";
            $criteria->addCondition("t.date_deleted is NULL");
            $criteria->order="t.display_order ASC";
            $criteria->compare("country_id", $id);
            $criteria->distinct = true;
            
            return $this->findAll($criteria);
	}
	public function getStateByStateId($id){
            $criteria = new CDbCriteria();
            $criteria->select="state_id,state";
            $criteria->addCondition("t.date_deleted is NULL");
            $criteria->order="t.display_order ASC";
            $criteria->compare("state_id", $id);
            $criteria->distinct = true;
            
            return $this->findAll($criteria);
	}
	public function getCityByCityId($id){
            $criteria = new CDbCriteria();
            $criteria->select="city_id,city";
            $criteria->addCondition("t.date_deleted is NULL");
            $criteria->order="t.display_order ASC";
            $criteria->compare("city_id", $id);
            $criteria->distinct = true;
            
            return $this->findAll($criteria);
	}
	public function getAllStatesByCountryId($id){
            $criteria = new CDbCriteria();
            $criteria->select="state_id,state";
            $criteria->addCondition("t.date_deleted is NULL");
            $criteria->order="t.display_order ASC";
            $criteria->compare("country_id", $id);
            $criteria->distinct = true;
            
            return $this->findAll($criteria);
        }
	public function getAllCityByCountryId($id){
            $criteria = new CDbCriteria();
            $criteria->select="city_id,city";
            $criteria->addCondition("t.date_deleted is NULL");
            $criteria->order="t.display_order ASC";
            $criteria->compare("city_id", $id);
            $criteria->distinct = true;
            
            return $this->findAll($criteria);
	}
	public function getAllCityByStateId($id){
            $criteria = new CDbCriteria();
            $criteria->select="city_id,city";
            $criteria->addCondition("t.date_deleted is NULL");
            $criteria->order="t.display_order ASC";
            $criteria->compare("state_id", $id);
            $criteria->distinct = true;
            
            return $this->findAll($criteria);
	}
        
}
