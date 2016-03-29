<?php

/**
 * This is the model class for table "core_log_payment".
 *
 * The followings are the available columns in table 'core_log_payment':
 * @property integer $id
 * @property string $level
 * @property string $category
 * @property string $request_url
 * @property string $message
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 */
class CoreLogPayment extends EActiveRecord {

    const LEVEL_TRACE = 'trace';
    const LEVEL_WARNING = 'warning';
    const LEVEL_ERROR = 'error';
    const LEVEL_INFO = 'info';
    const LEVEL_PROFILE = 'profile';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'core_log_payment';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date_created', 'required'),
            array('level, category', 'length', 'max' => 128),
            array('request_url', 'length', 'max' => 2048),
            array('message, date_updated, date_deleted', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, level, category, request_url, message, date_created, date_updated, date_deleted', 'safe', 'on' => 'search'),
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
            'level' => 'Level',
            'category' => 'Category',
            'request_url' => 'Request Url',
            'message' => 'Message',
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
        $criteria->compare('level', $this->level, true);
        $criteria->compare('category', $this->category, true);
        $criteria->compare('request_url', $this->request_url, true);
        $criteria->compare('message', $this->message, true);
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
     * @return CoreLogPayment the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function log($msg, $level = self::LEVEL_INFO, $requestUrl = null, $category = __METHOD__) {
        $log = new CoreLogPayment();
        $log->message = $msg;
        $log->level = $level;
        $log->request_url = isset($requestUrl) ? $requestUrl : Yii::app()->request->url;
        $log->category = $category;

        return $log->save();
    }

}
