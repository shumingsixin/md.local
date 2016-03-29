<?php

class OauthController extends WeixinpubController {

    public $wx_pub_id = 'myzdztc';   // 微信公众号id.
    public $session_key_openid = 'wx.openid';

    public function actionGetWxCode() {
        //    require_once('protected/sdk/pingpp-php-master/init.php');
        $redirectUrl = $this->createAbsoluteUrl("oauth/getWxOpenId");
        $wxConfig = new WeixinConfig();
        //$wxAppId = 'wxb6dc36522aae7df2'; //@TODO: store in db.
        $wxAppId = $wxConfig->getAppId();

        //$url = \Pingpp\WxpubOAuth::createOauthUrlForCode($wxAppId, $redirectUrl);
        $requestUrl = WeixinpubOAuth::createOauthUrlForCode($wxAppId, $redirectUrl);
        $logMsg = 'Request url: ' . $requestUrl;
        WeixinpubLog::log($logMsg, 'info', __METHOD__);
        // var_dump($requestUrl);
        header('Location: ' . $requestUrl);
        Yii::app()->end();
    }

    public function actionGetWxOpenId() {
        //CoreLogPayment::log(Yii::app()->request->querystring, 'info', null, __METHOD__);
        // var_dump(Yii::app()->request->querystring);exit;        
        $code = '';
        if (isset($_GET['code'])) {
            //$output = array('status' => 'no', 'errorMsg' => '请求参数错误');
            //$this->renderJsonOutput($output);
            $code = $_GET['code'];
            $logMsg = 'Access code is found. Request: ' . Yii::app()->request->querystring;
            WeixinpubLog::log($logMsg, 'info', __METHOD__);
        } else {
            // no $code, so redirect to getWxCode first, to get access_code from Weixin.
            $logMsg = 'Access Code is missing, redirect to getWxCode. Request: ' . Yii::app()->request->querystring;
            WeixinpubLog::log($logMsg, 'info', __METHOD__);
            $this->redirect(array('getWxCode'));
            //$output = array('status' => 'no', 'errorMsg' => '请求参数错误');
            //$this->renderJsonOutput($output);

            Yii::app()->end();
        }

        $wxConfig = new WeixinConfig();
        //$wxAppId = 'wxb6dc36522aae7df2';
        //$wxAppSecret = 'e70db8f5ea5baa991d71c0be3047b339';
        $wxAppId = $wxConfig->getAppId();
        $wxAppSecret = $wxConfig->getAppSecret();
        //    require_once('protected/sdk/pingpp-php-master/init.php');
        //    $openid = \Pingpp\WxpubOAuth::getOpenid($wxAppId, $wxAppSecret, $code);
        $openid = WeixinpubOAuth::getOpenid($wxAppId, $wxAppSecret, $code);
        if (isset($openid)) {
            $userId = Yii::app()->user->id;
            $this->saveOpenId($openid, $this->wx_pub_id, $userId);
            //Yii::app()->user->session($this->{$session_key_openid}, $openid);
            //$userId=$this->getCurrentUserId();
        }
        $returnUrl = Yii::app()->session['wx.returnurl'];
        if (isset($returnUrl)) {
            unset(Yii::app()->session['wx.returnurl']);
            $this->redirect($returnUrl);
            Yii::app()->end();
        }

        $output = new stdClass();
        $output->status = 'ok';
        $output->openid = $openid;
        $this->renderJsonOutput($output);
        //    $this->redirect('http://mingyizhudao.com/order/view?openid=' . $openid . 'refno=' . $refno);
        //$this->redirect('http://md.mingyizhudao.com/test/pingpp-html5-one/demo/demo.php?openid=' . $openid);
    }

    public function actionGetWxOpenIdTest() {
       
        $wxConfig = new WeixinConfig();
        //$wxAppId = 'wxb6dc36522aae7df2';
        //$wxAppSecret = 'e70db8f5ea5baa991d71c0be3047b339';
        $wxAppId = $wxConfig->getAppId();
        $wxAppSecret = $wxConfig->getAppSecret();
        //    require_once('protected/sdk/pingpp-php-master/init.php');
        //    $openid = \Pingpp\WxpubOAuth::getOpenid($wxAppId, $wxAppSecret, $code);
        //$openid = WxpubOAuth::getOpenid($wxAppId, $wxAppSecret, $code);
        $openid='adsfasfdasdfasdfsdf';
        if (isset($openid)) {
            $userId = Yii::app()->user->id;
            $this->saveOpenId($openid, $this->wx_pub_id, $userId);
            //Yii::app()->user->session($this->{$session_key_openid}, $openid);
            //$userId=$this->getCurrentUserId();
        }
        $returnUrl = Yii::app()->session['wx.returnurl'];
        if (isset($returnUrl)) {
            unset(Yii::app()->session['wx.returnurl']);
            $this->redirect($returnUrl);
            Yii::app()->end();
        }

        $output = new stdClass();
        $output->status = 'ok';
        $output->openid = $openid;
        $this->renderJsonOutput($output);
        //    $this->redirect('http://mingyizhudao.com/order/view?openid=' . $openid . 'refno=' . $refno);
        //$this->redirect('http://md.mingyizhudao.com/test/pingpp-html5-one/demo/demo.php?openid=' . $openid);
    }

    /*
      private function getStoredOpenId() {
      if (isset(Yii::app()->session[$this->session_key_openid])) {
      // get openid from session.
      return Yii::app()->session[$this->session_key_openid];
      } elseif (isset(Yii::app()->user->id)) {
      // get openid from db.
      $userId = Yii::app()->user->id;
      $model = WeixinpubOpenid::model()->getByWeixinPubIdAndUserId($this->wx_pub_id, $userId);
      if (isset($model)) {
      $openId = $model->getOpenId();  // store openid in session.
      Yii::app()->session[$this->session_key_openid] = $openId;
      return $openId;
      } else {
      return null;
      }
      } else {
      return null;
      }
      }
     */

    private function saveOpenId($openId, $wxPubId, $userId = null) {
        Yii::app()->session[$this->session_key_openid] = $openId;
        if (isset($userId)) {
            // user is logged in, so we can save the openid into db.
            $model = WeixinpubOpenid::model()->getByWeixinPubIdAndUserId($this->wx_pub_id, $userId);
            if (isset($model) === false) {
                // create a new WeixinpubOpenid model and save it into db.
                $model = WeixinpubOpenid::createModel($wxPubId, $openId, $userId);
                return $model->save();
            } elseif ($model->open_id != $openId) {
                // update existing WeixinpubOpenid->open_id in db.
                $model->setOpenId($openId);
                return $model->save(true, array('openId', 'date_updated'));
            }
        }
        return true;
    }

    public function actionTest() {
        $returnUrl = $this->createAbsoluteUrl('testOpenId');
        Yii::app()->session['wx.returnurl'] = $returnUrl;

        $url = $this->createAbsoluteUrl('getWxOpenId');

        echo $url;
    }

    public function actionTestOpenId() {
        echo 'TestOpenId result<br>';
        // Yii::app()->session['test'] = 'test value';
        $openid = Yii::app()->session['wx.openid'];
        echo $openid;
        exit;
    }

}
