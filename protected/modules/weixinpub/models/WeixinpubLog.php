<?php

/**
 * This is the model class for table "weixinpub_log".
 *
 * The followings are the available columns in table 'weixinpub_log':
 * @property integer $id
 * @property string $level
 * @property string $category
 * @property string $message
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 */
class WeixinpubLog extends EActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'weixinpub_log';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date_created', 'required'),
            array('level', 'length', 'max' => 10),
            array('category', 'length', 'max' => 128),
            array('message, date_updated, date_deleted', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, level, category, message, date_created, date_updated, date_deleted', 'safe', 'on' => 'search'),
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
     * @return WeixinpubLog the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function log($message, $level = 'info', $category = 'application') {
        $model = new WeixinpubLog();
        $model->message = $message;
        $model->level = $level;
        $model->category = $category;
        return $model->save();
    }

}
