<?php

/**
 * This is the model class for table "tbl_email_template".
 *
 * The followings are the available columns in table 'tbl_email_template':
 * @property integer $id
 * @property string $name
 * @property string $view
 * @property string $subject
 * @property string $sender
 * @property string $sender_name
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 */
class EmailTemplate extends EActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'email_template';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, view, subject, sender', 'required'),
            array('name, view, sender_name', 'length', 'max' => 45),
            array('subject, sender', 'length', 'max' => 255),
            array('date_created, date_updated, date_deleted', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, view, subject, sender, date_created, date_updated, date_deleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'view' => 'View',
            'subject' => 'Subject',
            'sender' => 'Sender',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
            'date_deleted' => 'Date Deleted',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('view', $this->view, true);
        $criteria->compare('subject', $this->subject, true);
        $criteria->compare('sender', $this->sender, true);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('date_updated', $this->date_updated, true);
        $criteria->compare('date_deleted', $this->date_deleted, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return EmailTemplate the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /*     * ******** Query Methods ********* */

    public function getByName($name) {
        return $this->getByAttributes(array('name' => $name));
    }

    /*     * ****** Accessors ******* */

    public function getName() {
        return $this->name;
    }

    public function getView() {
        return $this->view;
    }

    public function getSubject() {
        return $this->subject;
    }

    public function getSender() {
        return array($this->sender => $this->sender_name);
    }

    public function getSenderEmail() {
        return $this->sender;
    }

    public function getSenderName() {
        return $this->sender_name;
    }

}
