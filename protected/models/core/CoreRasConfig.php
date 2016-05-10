<?php
class CoreRasConfig extends EActiveRecord {
    /**
     * @return string the associated database table name
     */
    public function getDbConnection() {
        return Yii::app()->db2;
    }
    
    public function tableName() {
        return 'encryption';
    }
    
    public static function model($className=__CLASS__){
        return parent::model($className);
    }
    
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'key_name' => 'KEY名称',
            'client' => '使用来源客户端',
            'public_key' => '公钥',
            'private_key' => '私钥',
            'date_created' => '创建日期',
            'date_updated' => '修改日期',
            'date_deleted' => '删除日期'
        );
    }
    
    public function getByClient($client){
        $criteria = new CDbCriteria;
        $criteria->addCondition("t.client ='".$client."'");
        return $this->find($criteria);
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getClient() {
        return $this->client;
    }
    
    public function getPublicKey() {
        return $this->public_key;
    }
    
    public function getPrivateKey() {
        return $this->private_key;
    }
    
    public function getDateStart($format = null) {
        return $this->getDateAttribute($this->date_start, $format);
    }
    
    public function getDateEnd($format = null) {
        return $this->getDateAttribute($this->date_end, $format);
    }
    
    public function getApptDate($format = null) {
        return $this->getDatetimeAttribute($this->appt_date, $format);
    }
    
    
}