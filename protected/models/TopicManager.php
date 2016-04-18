<?php

class TopicManager {

    public function CreateUserlike($values) {
        $output = array('status' => 'no');
        $form = new UserLikeForm();
        $form->setAttributes($values, true);
        $form->initModel();
        if ($form->validate() == false) {
            $output['errors'] = $form->getErrors();
            return $output;
        }
        $attributes = $form->getSafeAttributes();
        $like = new SpecialTopicUserLike();
        $like->setAttributes($attributes, true);
        if ($like->save() === false) {
            $output['errors'] = $like->getErrors();
        } else {
            //保存成功 修改专题表的点赞数
            $topic = SpecialTopic::model()->getById($like->special_topic_id);
            $topic->like_count += 1;
            $topic->update(array(like_count));
            $output['status'] = 'ok';
            $output['id'] = $like->getId();
        }
        return $output;
    }

}
