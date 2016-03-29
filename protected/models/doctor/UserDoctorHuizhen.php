<?php

/**
 * This is the model class for table "user_doctor_huizhen".
 *
 * The followings are the available columns in table 'user_doctor_huizhen':
 * @property integer $id
 * @property integer $user_id
 * @property integer $is_join
 * @property string $travel_duration
 * @property integer $fee_min
 * @property integer $fee_max
 * @property string $week_days
 * @property string $patients_prefer
 * @property string $freq_destination
 * @property string $destination_req
 */
class UserDoctorHuizhen extends EFileModel {

    const IS_JOIN = 1;  //参加
    const ISNOT_JOIN = 0;    //不参加

    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return 'user_doctor_huizhen';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, is_join, min_no_surgery, fee_min, fee_max', 'numerical', 'integerOnly' => true),
            array('week_days', 'length', 'max' => 20),
            array('travel_duration', 'length', 'max' => 100),
            array('patients_prefer, freq_destination, destination_req', 'length', 'max' => 500),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, is_join, travel_duration, fee_min, fee_max, week_days, patients_prefer, freq_destination, destination_req', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'hzUser' => array(self::HAS_ONE, 'User', 'user_id'),
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
            'travel_duration' => 'Travel Duration',
            'min_no_surgery' => 'Min No Surgery',
            'fee_min' => 'Fee Min',
            'fee_max' => 'Fee Max',
            'week_days' => 'Week Days',
            'patients_prefer' => 'Patients Prefer',
            'freq_destination' => 'Freq Destination',
            'destination_req' => 'Destination Req',
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
        $criteria->compare('min_no_surgery', $this->min_no_surgery, true);
        $criteria->compare('travel_duration', $this->travel_duration, true);
        $criteria->compare('fee_min', $this->fee_min);
        $criteria->compare('fee_max', $this->fee_max);
        $criteria->compare('week_days', $this->week_days, true);
        $criteria->compare('patients_prefer', $this->patients_prefer, true);
        $criteria->compare('freq_destination', $this->freq_destination, true);
        $criteria->compare('destination_req', $this->destination_req, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserDoctorHuizhen the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getOptionsIsJoin() {
        return array(self::IS_JOIN => '加入', self::ISNOT_JOIN => '不参与');
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

    public function getWeekDays($v = true) {
        if ($v) {
            if (strIsEmpty($this->week_days, true) === false) {
                return explode(',', $this->week_days);
            } else {
                return array();
            }
        } else {
            return $this->week_days;
        }
    }

    public function getTravelDuration($v = true) {
        if ($v) {
            if (strIsEmpty($this->travel_duration, true) === false) {
                return explode(',', $this->travel_duration);
            } else {
                return array();
            }
        } else {
            return $this->travel_duration;
        }
    }

}
