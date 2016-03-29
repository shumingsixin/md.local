<?php

/**
 * This is the model class for table "contact_enquiry".
 *
 * The followings are the available columns in table 'contact_enquiry':
 * @property integer $id
 * @property string $name
 * @property string $mobile
 * @property integer $age
 * @property integer $faculty_id
 * @property string $patient_condition
 * @property string $access_agent
 * @property string $user_ip
 * @property string $user_agent
 * @property integer $sent
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 */
class ContactEnquiry extends EActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'contact_enquiry';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, mobile, age, faculty_id, patient_condition', 'required', 'message' => '请输入{attribute}'),
            array('age, faculty_id, sent', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 45),
            array('mobile', 'length', 'max' => 20),
            array('age', 'numerical', 'min' => 1, 'tooSmall' => '请输入正确的{attribute}'),
            array('patient_condition', 'length', 'max' => 200),
            //    array('user_ip', 'length', 'max' => 15),
            //    array('user_agent', 'length', 'max' => 255),
            array('date_created, date_updated, date_deleted', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, mobile, age, faculty_id, patient_condition, access_agent, user_ip, user_agent, sent, date_created, date_updated, date_deleted', 'safe', 'on' => 'search'),
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
            'name' => Yii::t('mr', '患者姓名'),
            'mobile' => Yii::t('mr', '手机号码'),
            'age' => Yii::t('mr', '患者年龄'),
            'faculty_id' => Yii::t('mr', '科室'),
            'patient_condition' => Yii::t('mr', '病情描述'),
            'access_agent' => 'Access Agent',
            'user_ip' => 'User Ip',
            'user_agent' => 'User Agent',
            'sent' => 'Sent',
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
        $criteria->compare('mobile', $this->mobile, true);
        $criteria->compare('age', $this->age);
        $criteria->compare('faculty_id', $this->faculty_id);
        $criteria->compare('patient_condition', $this->patient_condition, true);
        $criteria->compare('access_agent', $this->access_agent, true);
        $criteria->compare('user_ip', $this->user_ip, true);
        $criteria->compare('user_agent', $this->user_agent, true);
        $criteria->compare('sent', $this->sent);
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
     * @return ContactEnquiry the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function getOptionsAcceptSurgery() {
        return array(1 => '是', 0 => '否');
    }

    /*     * ****** Accessors ******* */

    public function getFacultyName() {
        if (is_null($this->faculty_id) === false) {
            $faculty = Faculty::model()->getById($this->faculty_id);
            if (isset($faculty)) {
                return $faculty->getName();
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function getName() {
        return $this->name;
    }

    public function getAge() {
        return $this->age;
    }

    public function getMobile() {
        return $this->mobile;
    }

    public function getPatientCondition() {
        return $this->getTextAttribute($this->patient_condition);
    }

}
