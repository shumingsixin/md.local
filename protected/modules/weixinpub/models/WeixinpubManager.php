<?php

class WeixinpubManager {

    public $wx_pub_id = 'myzdztc';   // 微信公众号id.
    public $session_key_openid = 'wx.openid';

    public function getStoredOpenId() {
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
    
    public function getOpenIdFromSession(){
        return Yii::app()->session[$this->session_key_openid];
    }

    public function storeOpenId($openId, $wxPubId, $userId = null) {
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
    
    public function getWeixinpubId(){
        return $this->wx_pub_id;
    }
    
    

}
