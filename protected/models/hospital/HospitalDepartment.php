<?php

/**
 * This is the model class for table "hospital_department".
 *
 * The followings are the available columns in table 'hospital_department':
 * @property integer $id
 * @property integer $hospital_id
 * @property string $group
 * @property string $name
 * @property integer $display_order
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 *
 * The followings are the available model relations:
 * @property Hospital $hospital
 */
class HospitalDepartment extends EActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'hospital_department';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('hospital_id, name', 'required'),
            array('hospital_id, display_order', 'numerical', 'integerOnly' => true),
            array('group, name', 'length', 'max' => 45),
            array('date_created, date_updated, date_deleted, group', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, hospital_id, group, name, display_order, date_created, date_updated, date_deleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'hpDeptHospital' => array(self::BELONGS_TO, 'Hospital', 'hospital_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'hospital_id' => 'Hospital',
            'group' => 'Group',
            'name' => 'Name',
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
        $criteria->compare('hospital_id', $this->hospital_id);
        $criteria->compare('group', $this->group, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('display_order', $this->display_order);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('date_updated', $this->date_updated, true);
        $criteria->compare('date_deleted', $this->date_deleted, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    //去掉不为空字段的空格
    protected function trimAttributes() {
        return array('name');
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return HospitalDepartment the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /*     * ****** Query Methods ******* */

    public function getAllByHospitalId($hid) {
        return $this->getAllByAttributes(array("hospital_id" => $hid));
    }

    public function getAllShowByHospitalId($hid) {
        return $this->getAllByAttributes(array('hospital_id' => $hid, 'is_show' => 1));
    }

    /*     * ****** Accessors ******* */

    public function getHospital() {
        return $this->hpDeptHospital;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($v) {
        $this->id = $v;
    }

    public function getHospitalId() {
        return $this->hospital_id;
    }

    public function setHospitalId($v) {
        $this->hospital_id = $v;
    }

    public function getGroup() {
        return $this->group;
    }

    public function setGroup($v) {
        $this->group = $v;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($v) {
        $this->name = $v;
    }

    public function getOptionsDeptGroup() {
        return array(
            '外科' => '外科',
            '骨科' => '骨科',
            '妇产科' => '妇产科',
            '眼科' => '眼科',
            '口腔科' => '口腔科',
            '小儿外科' => '小儿外科',
            '其他' => '其他',
        );
    }

    /**
     * ajax验证是否已存在该科室
     * @param type $group
     * @param type $name
     * @return type
     */
    public function getByNameAndHostitalId($name,$hospitalId) {
        return $this->getByAttributes(array('name' => $name,'hospital_id'=>$hospitalId));
    }

}
