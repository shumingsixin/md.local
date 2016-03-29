<?php

class SmsManager {
    /*
      public function sendSms() {

      }
     * 
     */

    /*
      public function sendSmsTemplate($to, $values, $templateId) {
      return $this->sendSmsTemplateViaYunTongXun($to, $values, $templateId);
      }
     * 
     */

    // Send verifing sms to user's mobile when user registers.
    /**
     * 
     * @param type $to mobile number.
     * @param type $code  verify code.
     * @param type $expiry  expiry duration, eg 10 minutes.
     * @return array of errors or empty array if it is success.
     */
    /*
      public function sendVerifyUserRegisterSms($to, $code, $expiry) {
      $templateId = '25322';  //template id, from 云通讯.
      $values = array($code, $expiry);
      return $this->sendSmsTemplateViaYunTongXun($to, $values, $templateId);
      }
     */

    protected function sendSmsTemplateViaYunTongXun($to, $values, $templateId) {
        require_once("./protected/sdk/yuntongxun/yuntongxun.config.php");
        //require_once("./protected/sdk/yuntongxun/yuntongxun.test.php");
        require_once("./protected/sdk/yuntongxun/CCPRestSmsSDK.php");
        //$ytxConfig from yuntongxun.config.php.

        $rest = new REST($ytxConfig['serverIP'], $ytxConfig['serverPort'], $ytxConfig['softVersion']);
        $rest->setAccount($ytxConfig['accountSid'], $ytxConfig['accountToken']);
        $rest->setAppId($ytxConfig['appId']);
        $ret = $rest->sendTemplateSMS($to, $values, $templateId);   //returns a SimpleXMLElement object.
        $errors = array();
        if (is_null($ret)) {
            // Null return.
            $errors[] = 'No response from vendor.';
        } else if ($ret->statusCode != 0) {
            // Error.           
            $msg = strval($ret->statusMsg);
            $code = strval($ret->statusCode);
            $errors[$code] = $msg;
        } else {
            // Success.            
        }
        return $errors;
    }

    // Send verifying sms to user's mobile number.
    // 发送验证码
    /**
     * 
     * @param type $to mobile number.
     * @param type $code  verify code.
     * @param type $expiry  expiry duration, eg 10 minutes.
     * @return array of errors or empty array if it is success.
     */
    public function sendSmsVerifyCode($to, $code, $expiry, $vendor = 'yuntongxun') {
        if ($vendor == 'yuntongxun') {
            $templateId = '25322';  //template id, from 云通讯.
            $values = array($code, $expiry);
            return $this->sendSmsTemplateViaYunTongXun($to, $values, $templateId);
        }
    }

    /**
     * 当用户提交预约后，发送短信给用户。
     * @param type $to 手机号
     * @param type $data 参数顺序: 1.专家, 2.refno 预约号 
     * @param type $vendor 短信提供商
     * @return type
     */
    public function sendSmsBookingSubmit($to, $data, $vendor = 'yuntongxun') {
        if ($vendor == 'yuntongxun') {
            //$templateId = '49856';  //template id, from 云通讯.
            $templateId = '50220';
            $days = 1;
            $values = array($data->refno, $data->expertBooked, $days);
            return $this->sendSmsTemplateViaYunTongXun($to, $values, $templateId);
        }
    }

    /**
     * 当客服给预约关联了专家后，发送短信给专家。
     * @param type $to 手机号
     * @param type $data 参数顺序： 1. refno 预约号, 2. booking id.
     * @param type $vendor 短信提供商
     * @return type
     */
    public function sendSmsBookingAssignDoctor($to, $data, $vendor = 'yuntongxun') {
        if ($vendor == 'yuntongxun') {
            //$templateId = '49996';  //template id, from 云通讯.            
            //$values = array($data->refno, $data->bookingId);
            $templateId = '50231';
            $url = 'http://md.mingyizhudao.com/mobiledoctor/patientbooking/doctorPatientBooking?id=' . $data->id;
            $values = array($data->refno, $url);
            return $this->sendSmsTemplateViaYunTongXun($to, $values, $templateId);
        }
    }

    /**
     * 
     * @param type $to
     * @param type $data 参数顺序 1. amount 金额, 2. refno 预约号.
     * @param type $vendor
     * @return type
     */
    public function sendSmsBookingDepositPaid($to, $data, $vendor = 'yuntongxun') {
        if ($vendor == 'yuntongxun') {
            $templateId = '49857';  //template id, from 云通讯.
            $values = array($data->amount, $data->refno);
            return $this->sendSmsTemplateViaYunTongXun($to, $values, $templateId);
        }
    }

}
