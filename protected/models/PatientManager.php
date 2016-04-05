<?php

class PatientManager {

    public function loadPatientInfoById($id) {
        return PatientInfo::model()->getById($id);
    }

    public function loadPatientMRById($id, $attributes = '*', $with = null) {
        if (is_null($attributes)) {
            $attributes = '*';
        }
        $criteria = new CDbCriteria();
        $criteria->select = $attributes;
        $criteria->addCondition('t.date_deleted is NULL');
        $criteria->compare('t.id', $id);
        if (is_array($with)) {
            $criteria->with = $with;
        }
        return PatientMR::model()->find($criteria);
    }

    //查询所有患者信息总数
    public function loadPatientCount($creator_id) {
        $criteria = new CDbCriteria();
        $criteria->compare('t.creator_id', $creator_id);
        $criteria->addCondition('t.date_deleted is NULL');
        return PatientInfo::model()->count($criteria);
        ;
    }

    //查询该创建者所有预约患者的总数
    public function loadPatientBookingNumberByCreatorId($creator_id,$status) {
        $criteria = new CDbCriteria();
        $criteria->compare('t.creator_id', $creator_id);
        if($status!='0'){
            $criteria->compare('t.status', $status);
        }
        $criteria->addCondition('t.date_deleted is NULL');
        return PatientBooking::model()->count($criteria);
    }

    //查询该医生所有的预约患者总数
    public function loadPatientBookingNumberByDoctorId($doctor_id) {
        $criteria = new CDbCriteria();
        $criteria->compare('t.doctor_id', $doctor_id);
        $criteria->addCondition('t.date_deleted is NULL');
        return PatientBooking::model()->count($criteria);
    }

    //加载mr信息
    public function loadPatientMRByPatientId($patientId, $attributes = null, $with = null) {
        return PatientMR::model()->getByPatientId($patientId, $attributes, $with);
    }

    //加载病人文件信息
    public function loadPatientMRFilesByPatientId($patientId, $attributes = null, $with = null) {
        return PatientMRFile::model()->getAllByPatientId($patientId, $attributes, $with);
    }

    public function loadPatientBookingById($bookingId, $attributes = null, $with = null) {
        return PatientBooking::model()->getById($bookingId, $with);
    }

    //根据patientid加载booking
    public function loadPatientBookingByPatientId($patientId, $attributes = null, $with = null) {
        return PatientBooking::model()->getByPatientId($patientId, $attributes, $with);
    }

    //查询预约该医生的患者列表
    public function loadPatientBookingListByDoctorId($doctorId, $attributes = '*', $with = null, $options = null) {
        return PatientBooking::model()->getAllByDoctorId($doctorId, $with = null, $options = null);
    }

    //查询预约该医生的患者详细信息
    public function loadPatientBookingByIdAndDoctorId($id, $doctorId, $attributes = '*', $with = null) {
        return PatientBooking::model()->getByIdAndDoctorId($id, $doctorId, $with);
    }

    //查询创建者预约列表
    public function loadAllPatientBookingByCreatorId($creatorId,$status, $attributes = null, $with = null, $options = null) {
        if (is_null($attributes)) {
            $attributes = '*';
        }
        return PatientBooking::model()->getAllByCreatorId($creatorId,$status, $attributes, $with, $options);
    }

    //查询创建者的预约详情
    public function loadPatientBookingByIdAndCreatorId($id, $creatorId, $attributes = null, $with = null, $options = null) {
        if (is_null($attributes)) {
            $attributes = '*';
        }
        return PatientBooking::model()->getByIdAndCreatorId($id, $creatorId, $with);
    }

    //查询患者的病历/出院小结图片/
    public function loadFilesOfPatientByPatientIdAndCreaterIdAndType($patientId, $creatorId, $type, $attributes = null, $with = null, $options = null) {
        if (is_null($attributes)) {
            $attributes = '*';
        }

        return PatientMRFile::model()->getFilesOfPatientByPatientIdAndCreaterIdAndType($patientId, $creatorId, $type, $attributes, $with);
    }

    //查询患者列表
    public function loadPatientInfoListByCreateorId($creatorId, $attributes, $with = null, $options = null) {
        if (is_null($attributes)) {
            $attributes = '*';
        }
        return PatientInfo::model()->getAllByCreateorId($creatorId, $attributes, $with, $options);
    }

    //患者详情查询
    public function loadPatientInfoByIdAndCreateorId($id, $creatorId, $attributes, $with = null, $options = null) {
        if (is_null($attributes)) {
            $attributes = '*';
        }
        return PatientInfo::model()->getByIdAndCreatorId($id, $creatorId, $attributes, $with, $options);
    }

    //根据患者名字查询患者
    public function loadPatientListByCreateorIdAndName($createorId, $name, $attributes = '*', $with = null, $options = null) {
        return PatientInfo::model()->getAllByAttributes(array('creator_id' => $createorId, 'name' => $name), $attributes, $with, $options);
    }

    /**
     * Get EUploadedFile from $_FILE. 
     * Create DoctorCert model. 
     * Save file in filesystem. 
     * Save model in db.
     * @param EUploadedFile $file EUploadedFile::getInstances()
     * @param integer $doctorId Doctor.id     
     * @return DoctorCert 
     */
    private function savePatientMRFile($patientId, $creatorId, $reportType, $file) {
        $pFile = new PatientMRFile();
        $pFile->initModel($patientId, $creatorId, $reportType, $file);
        //文件保存于本地返回model存于数据库
        $pFile->saveModel();

        return $pFile;
    }

    public function sendSmsToCreator(User $user, $patientBooking) {
        $mobile = $user->getUsername();
        $smsMgr = new SmsManager();
        $data = new stdClass();
        $data->refno = $patientBooking->getRefNo();
        $doctor = $patientBooking->getDoctor();
        $data->expertBooked = isset($doctor) ? $doctor->name : '';
        //发送提示的信息
        $smsMgr->sendSmsBookingSubmit($mobile, $data);
    }

}
