<?php

class SpecialTopicUserLike extends EActiveRecord {

    const LIKE = '1';
    const NOTLIKE = '0';

    public function tableName() {
        return 'special_topic_user_like';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, special_topic_id, date_created', 'required'),
            array('user_id, special_topic_id, is_liked', 'numerical', 'integerOnly' => true),
            array('date_updated, date_deleted', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, special_topic_id, is_liked, date_created, date_updated, date_deleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'specialTopic' => array(self::BELONGS_TO, 'SpecialTopic', 'special_topic_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => '用户点赞id',
            'user_id' => '用户id',
            'special_topic_id' => '关联标题',
            'is_liked' => '是否点赞,1是,0不是',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
            'date_deleted' => 'Date Deleted',
        );
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('special_topic_id', $this->special_topic_id);
        $criteria->compare('is_liked', $this->is_liked);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('date_updated', $this->date_updated, true);
        $criteria->compare('date_deleted', $this->date_deleted, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 查询该用户是否已赞
     * @param type $userId
     * @param type $topicId
     * @return type
     */
    public function checkUserLike($userId, $topicId) {
        $model = $this->getByAttributes(array('user_id' => $userId, 'special_topic_id' => $topicId, 'is_like' => self::LIKE));
        if (isset($model)) {
            return self::LIKE;
        } else {
            return self::NOTLIKE;
        }
    }

}
