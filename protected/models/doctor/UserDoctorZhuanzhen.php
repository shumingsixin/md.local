<?php

/**
 * This is the model class for table "user_doctor_zhuanzhen".
 *
 * The followings are the available columns in table 'user_doctor_zhuanzhen':
 * @property integer $id
 * @property integer $user_id
 * @property integer $is_join
 * @property integer $fee
 * @property string $week_days
 * @property string $prep_days
 */
class UserDoctorZhuanzhen extends EFileModel {

    const IS_JOIN = 1;  //参加
    const ISNOT_JOIN = 0;    //不参加
    const PTEP_DAYS_ONE = '3d'; //三天内安排床位
    const PTEP_DAYS_TWO = '1w'; //一周内安排床位
    const PTEP_DAYS_THREE = '2w'; //两周内安排床位
    const PTEP_DAYS_FOUR = '3w'; //三周内安排床位

    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return 'user_doctor_zhuanzhen';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, is_join, fee', 'numerical', 'integerOnly' => true),
            array('prep_days, preferred_patient', 'length', 'max' => 500),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, is_join, fee, prep_days', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'zzUser' => array(self::HAS_ONE, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'is_join' => 'Is Join',
            'fee' => 'Fee',
            'prep_days' => 'Prep Days',
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
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('is_join', $this->is_join);
        $criteria->compare('fee', $this->fee);
        $criteria->compare('prep_days', $this->prep_days, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserDoctorZhuanzhen the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getOptionsIsJoin() {
        return array(self::IS_JOIN => '加入', self::ISNOT_JOIN => '不参与');
    }

    public function getOptionsPrepDays() {
        return array(self::PTEP_DAYS_ONE => '三天内',
            self::PTEP_DAYS_TWO => '一周内',
            self::PTEP_DAYS_THREE => '两周内',
            self::PTEP_DAYS_FOUR => '三周内'
        );
    }

    public function getIsJoin($v = true) {
        if ($v) {
            $options = $this->getOptionsIsJoin();
            if (isset($options[$this->is_join])) {
                return $options[$this->is_join];
            } else {
                return '';
            }
        }
        return $this->is_join;
    }

    public function getPrepDays($v = true) {
        if ($v) {
            $options = $this->getOptionsPrepDays();
            if (isset($options[$this->prep_days])) {
                return $options[$this->prep_days];
            } else {
                return '';
            }
        }
        return $this->prep_days;
    }

}
