<?php

class AuthController extends WebsiteController {

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
                // 'postOnly + sendSmsVerifyCode', // we only allow deletion via POST request           
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('sendSmsVerifyCode', 'verifySmsCode'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * @param string $_POST['AuthSmsVerify']['mobile']  mobile number.
     * @param string $_POST['AuthSmsVerify']['actionType']   AuthSmsVerify.action_type.
     * @throws CException
     */
    public function actionSendSmsVerifyCode() {
        $errors = array();
        try {
            if (isset($_POST['AuthSmsVerify'])) {

                $values = $_POST['AuthSmsVerify'];

                $errors = $this->validateInputs($values);

                $userIp = Yii::app()->request->getUserHostAddress();
                $mobile = $values['mobile'];
                $actionType = $values['actionType'];

                $authMgr = new AuthManager();
                $errors = $authMgr->sendAuthSmsVerifyCode($mobile, $actionType, $userIp);
                
                if (empty($errors)) {
                    // success.
                } else {
                    throw new CException("Error.");
                }

                $this->renderJsonOutput(array('status' => true));
            } else {
                $errors[] = "Invalid request.";
                throw new CException("Invalid request.");
            }
        } catch (CException $ex) {            
            $output['status'] = false;
            $output['errors'] = $errors;
            $this->renderJsonOutput($output);
        }
    }

    public function actionVerifySmsCode() {
        $errors = array();
        try {
            if (isset($_POST['AuthSmsVerify']) || true) {
                //$values = $_POST['AuthSmsVerify'];
                $values = $_GET;
                $mobile = $values['mobile'];
                $code = $values['code'];
                $actionType = $values['actionType'];

                $userIp = Yii::app()->request->getUserHostAddress();

                $authMgr = new AuthManager();
                $authSmsVerify = $authMgr->verifyAuthSmsCode($mobile, $code, $actionType, $userIp);
                if (is_null($authSmsVerify)) {
                    throw new CException("null");
                } else if ($authSmsVerify->isValid() === false) {
                    $errors = $authSmsVerify->getErrors();
                    throw new CException("Error");
                }
                $output['status'] = true;
                //$this->renderJsonOutput($output);
                $this->headerUTF8();
                var_dump($output);
                //echo CJSON::encode($output);
                /*   if ($authSmsVerify->hasErrors() === false) {
                  $authMgr->deActiveAuthSmsVerify($authSmsVerify);
                  }
                 * 
                 */
            }
        } catch (CException $ex) {
            //var_dump($ex);
            $errors = array('Invalid request.');
            $this->renderJsonOutput(array('status' => false, 'errors' => $errors));
        }
    }

    protected function validateInputs($values) {
        $errors = array();
        if (isset($values['mobile']) === false) {
            $errors[] = "Missing mobile number.";
        }
        if (isset($values['actionType']) === false) {
            $errors[] = "Missing action type.";
        }

        return $errors;
    }

}
