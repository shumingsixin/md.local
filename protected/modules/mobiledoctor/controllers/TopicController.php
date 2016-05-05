<?php

class TopicController extends MobiledoctorController {
    
    //页面加载数据
    public function actionAjaxView() {
        $values = $_GET;
        $output = array('islogin' => '0');
        if (isset($values['username']) !== false && isset($values['token']) !== false) {
            $username = $values['username'];
            $token = $values['token'];
            $authMgr = new AuthManager();
            $authUserIdentity = $authMgr->authenticateDoctorByToken($username, $token);
            if (is_null($authUserIdentity) === false && $authUserIdentity->isAuthenticated === true) {
                $output['islogin'] = '1';
                $user = $authUserIdentity->getUser();
                $like = new SpecialTopicUserLike();
                $topicId = $values['topicId'];
                $output['islike'] = $like->checkUserLike($user->id, $topicId);
            }
        }
        $this->renderJsonOutput($output);
    }

    /**
     * 用户点赞
     */
    public function actionUserLike() {
        $output = array('status' => 'no');
        if (isset($_POST['userlike'])) {
            $values = $_POST['userlike'];
            $topicMgr = new TopicManager();
            $output = $topicMgr->CreateUserlike($values);
        } else {
            $output['errors'] = 'no data...';
        }
    }

}
