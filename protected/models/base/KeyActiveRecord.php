<?php

class KeyActiveRecord extends EActiveRecord {
    public function getDbConnection() {
        return Yii::app()->db2;
    }
}
