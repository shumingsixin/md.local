<?php

class WeixinConfig {

    const APP_ID = 'wxb6dc36522aae7df2';
    const APP_SECRET = 'e70db8f5ea5baa991d71c0be3047b339';  // can be changed.
    // https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET
    const URL_ACCESS_TOKEN = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential'; //&appid=APPID&secret=APPSECRET';
    // https://open.weixin.qq.com/connect/oauth2/authorize?appid=APPID&redirect_uri=REDIRECT_URI&response_type=code&scope=SCOPE&state=STATE#wechat_redirect
    const URL_OAUTH2_CODE = 'https://open.weixin.qq.com/connect/oauth2/authorize';
    //https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code
    const URL_OAUTH2_ACCESS_TOKEN = 'https://api.weixin.qq.com/sns/oauth2/access_token';

    /*
      public function getUrlAccessToken() {
      $url = self::URL_ACCESS_TOKEN;
      $url .='&appid=' . self::APP_ID;
      $url .='&secret=' . self::APP_SECRET;
      return $url;
      }
     */


    /*     * ****** Accessors ******* */

    public function getAppId() {
        return self::APP_ID;
    }

    public function getAppSecret() {
        return self::APP_SECRET;
    }

    public function getUrlAccessToken() {
        $url = self::URL_ACCESS_TOKEN;
        $url .='&appid=' . self::APP_ID;
        $url .='&secret=' . self::APP_SECRET;
        return $url;
    }

    public function getUrAOAuth2Code() {
        return self:: URL_OAUTH2_CODE;
    }

    /**
     * @param code  微信返回的 code, 用以兑换access_token. 每个code只能用一次，有效期为5分钟.
     * @param state
     * @return string
     */
    public function getUrlOAuth2Code() {
        return self::URL_OAUTH2_CODE;
//        $url.='?appid=' . self::APP_ID;
//        //$url.='&redirect_uri=' . urlencode('http://md.mingyizhudao.com/mobiledoctor/wx/oAuth2CodeReturn');
//        $url.='&redirect_uri=' . $redirectUrl;
//        $url.='&response_type=code';
//        // $url.= '&scope=snsapi_userinfo';
//        $url.='&scope=' . $scope;
//        $url.='&state=STATE';
//        $url.='#wechat_redirect';
//
//        return $url;
    }

    public function getUrlOAuth2AccessToken($code) {
        return self::URL_OAUTH2_ACCESS_TOKEN;
        /*
        $url.='?appid=' . self::APP_ID;
        $url.='&secret=' . self::APP_SECRET;
        $url.='&code=' . $code;
        $url.='&grant_type=authorization_code';
        return $url;
         * 
         */
    }

}
