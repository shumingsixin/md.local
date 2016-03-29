<?php
class WeixinpubWebUser extends EWebUser {

    /**
     *
     * @param UserIdentity $identity
     * @param integer $duration 
     */
    public function login($identity, $duration = 0) {
        parent::login($identity, $duration);
        $this->setState('role', $identity->getRole());
        $wxpubMgr = new WeixinpubManager();
        // if openid is found in session, store into db.
        $openid = $wxpubMgr->getOpenIdFromSession();
        // WeixinpubLog::log('openid at login: '.$openid, 'info', __METHOD__);
        if (isset($openid)) {
            $wxpubMgr->storeOpenId($openid, $wxpubMgr->getWeixinpubId(), Yii::app()->user->id);
        }
    }

}
