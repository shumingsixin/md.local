<?php

class UserDrController extends MobiledoctorController {

    //进入医生问卷调查页面
    public function actionView() {
        $this->render("view");
    }

    //医生查看自己能接受病人的转诊信息
    public function actionAjaxViewDoctorZz() {
        $userId = $this->getCurrentUserId();
        $apiSvc = new apiViewDoctorZz($userId);
        $output = $apiSvc->loadApiViewData();
        $this->renderJsonOutput($output);
    }

    //进入保存或修改医生转诊信息的页面
    public function actionCreateDoctorZz() {
        $userId = $this->getCurrentUserId();
        $userMgr = new UserManager();
        $model = $userMgr->loadUserDoctorZhuanzhenByUserId($userId);
        $form = new DoctorZhuanzhenForm();
        $form->initModel($model);
        $this->render("createDoctorZz", array(
            'model' => $form
        ));
    }

    //保存或修改医生接受病人转诊信息
    public function actionAjaxDoctorZz() {
        $output = array('status' => 'no');
        $userId = $this->getCurrentUserId();
        if (isset($_POST['DoctorZhuanzhenForm'])) {
            $values = $_POST['DoctorZhuanzhenForm'];
            $values['user_id'] = $userId;
            $userMgr = new UserManager();
            $output = $userMgr->createOrUpdateDoctorZhuanzhen($values);
        }
        $this->renderJsonOutput($output);
    }

    //医生查看自己接受的会诊信息
    public function actionAjaxViewDoctorHz() {
        $userId = $this->getCurrentUserId();
        $apiSvc = new apiViewDoctorHz($userId);
        $output = $apiSvc->loadApiViewData();
        //若该用户未填写则进入填写页面
        $this->renderJsonOutput($output);
    }

    //进入保存或修改医生会诊 信息的页面
    public function actionCreateDoctorHz() {
        $userId = $this->getCurrentUserId();
        $userMgr = new UserManager();
        $model = $userMgr->loadUserDoctorHuizhenByUserId($userId);
        $form = new DoctorHuizhenForm();
        $form->initModel($model);
        $this->render("createDoctorHz", array(
            'model' => $form
        ));
    }

    //保存或修改医生会诊信息
    public function actionAjaxDoctorHz() {
        $userId = $this->getCurrentUserId();
        $output = array('status' => 'no');
        if (isset($_POST['DoctorHuizhenForm'])) {
            $values = $_POST['DoctorHuizhenForm'];
            $values['user_id'] = $userId;
            $userMgr = new UserManager();
            $output = $userMgr->createOrUpdateDoctorHuizhen($values);
        }
        $this->renderJsonOutput($output);
    }

}
