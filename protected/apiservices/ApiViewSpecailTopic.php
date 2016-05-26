<?php

class ApiViewSpecailTopic extends EApiViewService {

    private $topicList;

    public function __construct() {
        parent::__construct();
        $this->results = new stdClass();
        $this->topicList = array();
    }

    protected function loadData() {
        $this->loadTopic();
    }

    protected function createOutput() {
        if (is_null($this->output)) {
            $this->output = array(
                'status' => self::RESPONSE_OK,
                'errorCode' => 0,
                'errorMsg' => 'success',
                'results' => $this->results,
            );
        }
    }

    public function loadTopic() {
        $models = SpecialTopic::model()->getAll();
        if (arrayNotEmpty($models)) {
            $this->setTopicList($models);
        }
        $this->results->topicList = $this->topicList;
    }

    public function setTopicList($models) {

        foreach ($models as $model) {
            $data = new stdClass();
            $data->id = $model->id;
            $data->topic = $model->topic;
            $data->contentUrl = $model->content_url;
            $data->bannerUrl = $model->banner_url;
            $data->likeCount = $model->like_count;
            $this->topicList[] = $data;
        }
    }

}

?>