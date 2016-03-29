<?php

/**
 * This is the model class for table "weixinpub_openid".
 *
 * The followings are the available columns in table 'weixinpub_openid':
 * @property integer $id
 * @property string $weixinpub_id
 * @property string $open_id
 * @property integer $user_id
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 */
class WeixinpubOpenid extends EActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'weixinpub_openid';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('weixinpub_id, open_id, user_id, date_created', 'required'),
            array('user_id', 'numerical', 'integerOnly' => true),
            array('weixinpub_id', 'length', 'max' => 20),
            array('open_id', 'length', 'max' => 40),
            array('date_updated, date_deleted', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, weixinpub_id, open_id, user_id, date_created, date_updated, date_deleted', 'safe', 'on' => 'search'),
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
            'weixinpub_id' => 'Weixinpub',
            'open_id' => 'Open',
            'user_id' => 'User',
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
        $criteria->compare('weixinpub_id', $this->weixinpub_id, true);
        $criteria->compare('open_id', $this->open_id, true);
        $criteria->compare('user_id', $this->user_id);
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
     * @return WeixinpubOpenid the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function createModel($wxPubId, $openId, $userId) {
        $model = new WeixinpubOpenid();
        $model->weixinpub_id = $wxPubId;
        $model->open_id = $openId;
        $model->user_id = $userId;
        return $model;
    }

    public function getByWeixinPubIdAndUserId($wxPubId, $userId) {
        return $this->getByAttributes(array('weixinpub_id' => $wxPubId, 'user_id' => $userId));
    }

    /*     * ****** Accessors ******* */

    public function getWeixinPubId() {
        return $this->weixinpub_id;
    }

    public function getOpenId() {
        return $this->open_id;
    }

    public function setOpenId($v) {
        $this->open_id = $v;
    }

    public function getUserId() {
        return $this->user_id;
    }

}
