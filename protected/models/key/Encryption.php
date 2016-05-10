<?php

class Encryption extends KeyActiveRecord {


    public function tableName() {
        return 'encryption';
    }


    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

  
}
