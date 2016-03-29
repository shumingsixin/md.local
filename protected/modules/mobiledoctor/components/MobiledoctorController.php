<?php

class MobiledoctorController extends WebsiteController {

    public $layout = 'layoutSinglePage';
    public $jqPageId;   //must be unique across all pages in jquery mobile.
    public $pageTitle = '名医主刀医生端';

    public function init() {
        if ($this->isUserAgentWeixin()) {
            //   echo 'weixin';
            $this->initWeixinOpenId();
            //var_dump($this->getCurrentRequestUrl());
            //exit;
        }
//        parent::init();
//        if (isset(Yii::app()->theme)) {
//            Yii::app()->clientScript->scriptMap = array(
//                'jquery.js' => 'http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/jquery-1.9.1.min.js',
//                'jquery.min.js' => 'http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/jquery-1.9.1.min.js',
//                'jquery.yiiactiveform.js' => 'http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/jquery.yiiactiveform.js',
//            );
//        }
    }

    public function getHomeUrl() {
        return $this->createUrl('home/index');
    }

    public function setPageID($pid) {
        $this->jqPageId = $pid;
    }

    public function getPageID() {
        return $this->jqPageId;
    }

    public function setPageTitle($title, $siteName = false) {
        parent::setPageTitle($title, $siteName);
    }

    public function getPageTitle() {
        return $this->pageTitle;
    }

    public function showBrowserModeMenu() {
        if ($this->id == 'home') {
            if (isset($_GET['bm'])) {
                return $_GET['bm'] == 1;
            } else if (isset($_POST['bm'])) {
                return $_POST['bm'] == 1;
            } else {
                return $this->isAjaxRequest() === false;
            }
        } else {
            return false;
        }
    }

    public function showActionBar() {
        return ($this->isUserAgentApp() === false);
    }

    public function renderActionBar() {
        if ($this->showActionBar()) {
            $this->renderPartial('//layouts/actionbar');
        }
    }

    public function createPageAttributes($returnString = true) {
        $data = array();
        if (isset($_GET['addBackBtn']) && $_GET['addBackBtn'] == 1) {
            $data['data-add-back-btn'] = 'true';
        }
        if (isset($_GET['backBtnText'])) {
            $data['data-back-btn-text'] = $_GET['backBtnText'];
        }
        if ($returnString) {
            $ret = '';
            foreach ($data as $key => $value) {
                $ret.=$key . '=' . $value . ' ';
            }
            return $ret;
        } else {
            return $data;
        }
    }

    public function initWeixinOpenId() {
        Yii::import("weixinpub.models.*");
        $wxMgr = new WeixinpubManager();
        // get weixin_openid from session or db.
        $openid = $wxMgr->getStoredOpenId();
        if (is_null($openid)) {
            // get weixin_openid from new request.            
            //$requestUrl = $this->createUrl('/weixinpub/oauth/getWxOpenIdTest'); //@test
            $requestUrl = $this->createUrl('/weixinpub/oauth/getWxOpenId');
            $currentUrl = $this->getCurrentRequestUrl();
            // store currentUrl in session first, for later call back.
            Yii::app()->session['wx.returnurl'] = $currentUrl;
            $this->redirect($requestUrl);
            Yii::app()->end();
        } else {
            // WeixinpubLog::log("openid: ".$openid, 'info', __METHOD__);
        }
    }

}
