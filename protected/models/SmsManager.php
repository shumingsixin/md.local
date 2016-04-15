<?php

class SmsManager {

    const VENDOR_JIANZHOU = 'jianzhou';
    const VENDOR_YUNTONGXUN = 'yuntongxun';
    const VENDOR_ACTIVE = 'jianzhou';
//    const JIANZHOU_ACCOUNT = 'jzyy305';
//    const JIANZHOU_PASSWORD = 'jiner0929';
    const JIANZHOU_ACCOUNT = 'sdk_myzd';
    const JIANZHOU_PASSWORD = '91466636';
    const JIANZHOU_URL = 'http://www.jianzhou.sh.cn/JianzhouSMSWSServer/http/sendBatchMessage';

    /**
     * 发起HTTPS请求
     */
    public function curlRequest($url, $data, $post = 1) {
        //初始化curl
        $ch = curl_init();
        //参数设置
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, $post);
        if ($post) {
            $post_data = http_build_query($data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        //连接失败
        if ($result == FALSE) {
            Yii::log('sms:' . var_export($data, true), CLogger::LEVEL_ERROR, __METHOD__);
            $result = "{\"statusCode\":\"1\",\"statusMsg\":\"timeout\"}";
        }

        curl_close($ch);
        return $result;
    }

    public function sendSmsTemplateViaJianZhou($to, $content) {
        $post_data = array(
            'account' => self::JIANZHOU_ACCOUNT,
            'password' => self::JIANZHOU_PASSWORD,
            'destmobile' => $to, //"13020267570;13916681596;17717394560"
            'msgText' => "{$content}【名医主刀】",
        );

        return $this->curlRequest(self::JIANZHOU_URL, $post_data);
    }

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

    // 发送验证码
    /**
     * 
     * @param type $to mobile number.
     * @param type $code  verify code.
     * @param type $expiry  expiry duration, eg 10 minutes.
     * @return array of errors or empty array if it is success.
     */
    public function sendSmsVerifyCode($to, $code, $expiry, $vendor = self::VENDOR_ACTIVE) {
        if ($vendor == self::VENDOR_YUNTONGXUN) {
            $templateId = '25322';  //template id, from 云通讯.
            $values = array($code, $expiry);
            return $this->sendSmsTemplateViaYunTongXun($to, $values, $templateId);
        } elseif ($vendor == self::VENDOR_JIANZHOU) {
            $model = MsgSmsTemplate::model()->getByAttributes(array('code' => 'verifyCode', 'vendor_name' => $vendor));
            $values = array($code, $expiry);
            $content = str_replace(array('{verifyCode}', '{minute}'), $values, $model->content);
            return $this->sendSmsTemplateViaJianZhou($to, $content);
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
