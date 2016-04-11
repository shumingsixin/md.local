<?php

/**
 * This is the model class for table "patient_mr_file".
 *
 * The followings are the available columns in table 'patient_mr_file':
 * @property integer $id
 * @property integer $patient_id
 * @property integer $creator_id
 * @property integer $mr_id
 * @property string $uid
 * @property string report_type
 * @property string $file_ext
 * @property string $mime_type
 * @property string $file_name
 * @property string $file_url
 * @property integer $file_size
 * @property string $thumbnail_name
 * @property string $thumbnail_url
 * @property string $base_url
 * @property integer $display_order
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 */
class PatientMRFile extends EFileModel {

    public $file_upload_field = 'file'; // $_FILE['file'].   

    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return 'patient_mr_file';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('patient_id, creator_id, uid', 'required'),
            array('patient_id, creator_id, file_size, display_order, has_remote', 'numerical', 'integerOnly' => true),
            array('uid', 'length', 'max' => 32),
            array('file_ext, report_type', 'length', 'max' => 10),
            array('mime_type', 'length', 'max' => 20),
            array('file_name, thumbnail_name, remote_file_key', 'length', 'max' => 40),
            array('file_url, thumbnail_url, base_url, remote_domain', 'length', 'max' => 255),
            array('has_remote, remote_file_key, remote_domain, date_created, date_updated, date_deleted', 'safe'),
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
            'patient_id' => '患者',
            'uid' => 'UID',
            'report_type' => '资料类别',
            'file_ext' => 'File Ext',
            'mime_type' => 'Mime Type',
            'file_name' => 'File Name',
            'file_url' => 'File Url',
            'file_size' => 'File Size',
            'thumbnail_name' => 'Thumbnail Name',
            'thumbnail_url' => 'Thumbnail Url',
            'base_url' => 'Base Url',
            'display_order' => 'Display Order',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
            'date_deleted' => 'Date Deleted',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PatientMRFile the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function initModel($patientId, $creatorId, $reportType, $file) {
        $this->setPatientId($patientId);
        $this->setCreatorId($creatorId);
        $this->setReportType($reportType);
        $this->setFileAttributes($file);
    }

    public function saveModel() {
        //数据校验
        if ($this->validate()) {    // validates model attributes before saving file.
            try {
                $fileSysDir = $this->getFileSystemUploadPath();
                createDirectory($fileSysDir);
                //Thumbnail.
                $thumbImage = Yii::app()->image->load($this->file->getTempName());
                // $image->resize(400, 100)->rotate(-45)->quality(75)->sharpen(20);
                $thumbImage->resize($this->thumbnail_width, $this->thumbnail_height);
                if ($thumbImage->save($fileSysDir . '/' . $this->getThumbnailName()) === false) {
                    throw new CException('Error saving file thumbnail.');
                }
                if ($this->file->saveAs($fileSysDir . '/' . $this->getFileName()) === false) {
                    throw new CException('Error saving file.');
                }
                //文件存储
                return $this->save();
            } catch (CException $e) {
                $this->addError('file', $e->getMessage());
                return false;
            }
        } else {
            return false;
        }
    }

    //Overwrites parent::getFileUploadRootPath().
    public function getFileUploadRootPath() {
        return Yii::app()->params['patientMRFilePath'];
    }

    public function getFileSystemUploadPath($folderName = null) {
        return parent::getFileSystemUploadPath($folderName);
    }

    public function getFileUploadPath($folderName = null) {
        return parent::getFileUploadPath($folderName);
    }

    public function deleteModel($absolute = true) {
        return parent::deleteModel($absolute);
    }

    /*     * ****** Query methods ******* */

    public function getAllByPatientId($patientId, $attributes = null, $with = null) {
        return $this->getAllByAttributes(array('patient_id' => $patientId), $with);
    }

    public function getFilesOfPatientByPatientIdAndCreaterIdAndType($patientId, $creatorId, $type, $attributes = null, $with = null) {
        return $this->getAllByAttributes(array('patient_id' => $patientId, 'creator_id' => $creatorId, 'report_type' => $type), $with);
    }

    public function getFilesOfPatientByPatientIdType($patientId, $type, $attributes = null, $with = null) {
        return $this->getAllByAttributes(array('patient_id' => $patientId, 'report_type' => $type), $with);
    }

    /*     * ****** Accessors ****** */

    public function getPatientId() {
        return $this->patient_id;
    }

    public function setPatientId($v) {
        $this->patient_id = $v;
    }

    public function setCreatorId($v) {
        $this->creator_id = $v;
    }

    public function getCreatorId() {
        return $this->creator_id;
    }

    public function setReportType($v) {
        $this->report_type = $v;
    }

}
