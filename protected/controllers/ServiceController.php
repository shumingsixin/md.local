<?php

class ServiceController extends WebsiteController {

    public function actionIndex() {
        $this->redirect('domestic');
    }

    public function actionDomestic() {
        $this->render('domestic');
    }

    public function actionOverseas() {
        $this->render('overseas');
    }

}
