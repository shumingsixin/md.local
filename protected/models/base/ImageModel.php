<?php

/**
 * This is the model class for base image model.
 *
 * @property integer $id
 * @property string $image_url
 * @property string $image_type
 * @property string $tn_url
 * @property string $original_image_url
 * @property integer $display_order
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 * 
 */
class ImageModel extends EActiveRecord {
    /*
      public $image_path;
      public $thumb_path;
      public $thumb_prefix;
     */

    public $image_upload_field = 'image_uploads';

    // const IMAGE_PATH='upload';
    //const THUMB_PATH = ''; //'thumb';
    const THUMB_PREFIX = 'tn';
    const IMAGE_TYPE='jpeg';
    /*
      const STANDARD_IMAGE_WIDTH=1024;
      const STANDARD_IMAGE_HEIGHT=1024;
      //const THUMB_IMAGE_SIZE = 140;
      const THUMB_IMAGE_WIDTH=600;
      const THUMB_IMAGE_HEIGHT = 500;
     */

    protected $standard_image_width = 1024;
    protected $standard_image_height = 1024;
    protected $thumb_image_width = 160;
    protected $thumb_image_height = 160;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('image_url, tn_url', 'required'),
            array('display_order', 'numerical', 'integerOnly' => true),
            array('image_url, tn_url, original_image_url', 'length', 'max' => 255),
            array('image_type', 'length', 'max' => 10),
            array('date_created, date_updated, date_deleted', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, image_url, image_type, tn_url, original_image_url, display_order, date_created, date_updated, date_deleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'image_url' => 'Image URL',
            'image_type' => 'Image Type',
            'tn_url' => 'Thumbnail URL',
            'original_image_url' => 'Original Image URL',
            'display_order' => 'Display Order',
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
        $criteria->compare('image_url', $this->image_url, true);
        $criteria->compare('image_type', $this->image_type, true);
        $criteria->compare('tn_url', $this->tn_url, true);
        $criteria->compare('original_image_url', $this->original_image_url, true);
        $criteria->compare('display_order', $this->display_order);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('date_updated', $this->date_updated, true);
        $criteria->compare('date_deleted', $this->date_deleted, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    /**
     * gets the relative image upload root path.
     * @return type 
     */
    public function getImageUploadRootPath() {
        return Yii::app()->params['upload'];
    }

    /**
     * gets the image upload path of given foler name.
     * @param type $folderName
     * @return type 
     */
    public function getImageUploadPath($folderName) {
        return ($this->getImageUploadRootPath() . $folderName);
    }

    /**
     * get Image File System Path
     *
     * @param string        	
     * @return string
     */
    public function getImageFileSystemPath($folderName) {
        return (Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . $this->getImageUploadPath($folderName) . DIRECTORY_SEPARATOR); // . $folderName . DIRECTORY_SEPARATOR;
    }

    /**
     *  get file system path of an attribute (image url).
     * @param type $attribute
     * @return type 
     */
    public function getFileSystemPathByAttribute($attribute) {
        return (Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . $this->{$attribute});
    }

    /**
     * get Trip Thumbs File System Path
     *
     * @param item $model        	
     * @return string
     */
    public function getThumbImageFileSystemPath($folderName) {
        return ($this->getImageFileSystemPath($folderName) . DIRECTORY_SEPARATOR);
    }

    /**
     *  creates unique random image name.
     * @param string $prefix of image name.
     * @return type 
     */
    public function generateRandomImageName($prefix) {
        return $prefix . dechex(time()) . $this->generateRandomString();
    }

    /**
     * Save Image into database and file system
     * @param ImageModel $model
     * @throws CException
     * @throws CDbException
     */
    public function saveImages($id) {
        //  ini_set('memory_limit', '32M');
        //Filesystem path.
        $filesysDir = $this->getImageFileSystemPath($id);
        $filesysThumbDir = $this->getThumbImageFileSystemPath($id);

        //URL Path.
        $imageUploadDir = $this->getImageUploadPath($id);

        // create the directory
        createDirectory($filesysDir);
        //  createDirectory($filesysThumbDir);
        // get the upload image from submitted form
        $images = CUploadedFile::getInstancesByName($this->image_upload_field);

        if (isset($images) && empty($images) === false) {
            $baseImageName = $this->generateRandomImageName($id);

            $imageIdx = 1;
            foreach ($images as $image) {

                $imageName = $baseImageName . $imageIdx;
                //$imageNameWithExt = $imageName . getFileExtension($image);
                $imageNameWithExt = $imageName . '.' . self::IMAGE_TYPE;
                $imagePath = $filesysDir . $imageNameWithExt;
                $imageUrl = $imageUploadDir . '/' . $imageNameWithExt;

                //Original image path.
                $originalNameWithExt = $imageName . '.' . self::IMAGE_TYPE;
                $originalPath = $filesysDir . $originalNameWithExt;
                $originalUrl = $imageUploadDir . '/' . $originalNameWithExt;

                //Create thumb nail from original image and save it as .jpeg.
                $thumbNameWithExt = self::THUMB_PREFIX . $imageName . '.' . self::IMAGE_TYPE;
                $thumbPath = $filesysThumbDir . $thumbNameWithExt;
                $thumbUrl = $imageUploadDir . '/' . $thumbNameWithExt;

                //Save original image.
                $originalImage = Yii::app()->image->load($image->getTempName());
                // $originalImage->save($originalPath);
                //Resize and save original image.
               // $originalImage->resize($this->standard_image_width, $this->standard_image_height);
                $originalImage->save($imagePath);

                $thumbImage = Yii::app()->image->load($image->getTempName());
                $thumbImage->resize($this->thumb_image_width, $this->thumb_image_height);
                $thumbImage->save($thumbPath);

                //* Thumbnail.
                /*
                  if ($this->resize($image->getTempName(), $thumbPath, $this->thumb_image_width, $this->thumb_image_height) === false) {
                  //Failed to pad white background, so do normal resize.
                  $thumbImage = Yii::app()->image->load($image->getTempName());
                  $thumbImage->resize($this->thumb_image_width, $this->thumb_image_height);
                  $thumbImage->save($thumbPath);
                  }
                 */
                // save the image record into database
                $this->saveNewModel($id, $imageUrl, $thumbUrl, $originalUrl, $imageIdx);

                $imageIdx++;
            }
        }
    }

    public function deleteModelFiles($attribute=null) {
        try {
            if ($attribute === null) {
                foreach ($this->attributes as $attribute => $value) {
                    if (endsWith($attribute, 'url')) {
                        $filePath = $this->getFileSystemPathByAttribute($attribute);
                        deleteFile($filePath);
                    }
                }
            } else {
                if ($this->hasAttribute($attribute)) {
                    $filePath = $this->getFileSystemPathByAttribute($attribute);
                    deleteFile($filePath);
                }
            }
        } catch (Exception $ex) {
            //TODO: handle the exception.
            return false;
        }
        return true;
    }

    public function deleteImageUploadDirectory() {
        $dirPath = $this->getImageFileSystemPath('');
        try {
            deleteDirectory($dirPath);
        } catch (Exception $ex) {
            //TODO: handle the exception.
            return false;
        }
        return true;
    }

    //Reize, crop and pad white background.
    private function resize($source_image, $destination, $tn_w, $tn_h, $quality = 70) {
        $info = getimagesize($source_image);
        $imgtype = image_type_to_mime_type($info[2]);

        #assuming the mime type is correct
        switch ($imgtype) {
            case 'image/jpeg':
                $source = imagecreatefromjpeg($source_image);
                break;
            case 'image/gif':
                $source = imagecreatefromgif($source_image);
                break;
            case 'image/png':
                $source = imagecreatefrompng($source_image);
                break;
            default:
                die('Invalid image type.');
        }

        #Figure out the dimensions of the image and the dimensions of the desired thumbnail
        $src_w = imagesx($source);
        $src_h = imagesy($source);


        #Do some math to figure out which way we'll need to crop the image
        #to get it proportional to the new size, then crop or adjust as needed

        $x_ratio = $tn_w / $src_w;
        $y_ratio = $tn_h / $src_h;

        if (($src_w <= $tn_w) && ($src_h <= $tn_h)) {
            $new_w = $src_w;
            $new_h = $src_h;
        } elseif (($x_ratio * $src_h) < $tn_h) {
            $new_h = ceil($x_ratio * $src_h);
            $new_w = $tn_w;
        } else {
            $new_w = ceil($y_ratio * $src_w);
            $new_h = $tn_h;
        }

        $newpic = imagecreatetruecolor(round($new_w), round($new_h));
        imagecopyresampled($newpic, $source, 0, 0, 0, 0, $new_w, $new_h, $src_w, $src_h);
        $final = imagecreatetruecolor($tn_w, $tn_h);
        $backgroundColor = imagecolorallocate($final, 255, 255, 255);
        imagefill($final, 0, 0, $backgroundColor);
        //imagecopyresampled($final, $newpic, 0, 0, ($x_mid - ($tn_w / 2)), ($y_mid - ($tn_h / 2)), $tn_w, $tn_h, $tn_w, $tn_h);
        imagecopy($final, $newpic, (($tn_w - $new_w) / 2), (($tn_h - $new_h) / 2), 0, 0, $new_w, $new_h);

        if (imagejpeg($final, $destination, $quality)) {
            return true;
        }
        return false;
    }

    private function generateRandomString($length = 10) {
        return(substr(str_shuffle(MD5(microtime())), 0, $length));
    }

    /**
     * This method has to be implemented by sub classes.
     * @param type $id
     * @param type $imageUrl
     * @param type $thumbUrl
     * @param type $imageIdx 
     */
    protected function saveNewModel($id, $imageUrl, $thumbUrl, $originalUrl, $imageIdx) {
        throw new CDbException("Error saving image into database.");
    }

    public function deleteModel($absolute=true) {
        $success = $this->delete($absolute);
        if ($absolute) {
            //delete all images referenced by model.
             $success = $this->deleteModelFiles();
            //deletes directory and all its files.
            //$success = $this->deleteImageUploadDirectory();
        }
        return $success;
    }

    /*     * ****** Accessors ******* */

    public function getAbsoluteImageUrl() {
        return Yii::app()->getBaseUrl(true) . '/' . $this->getImageUrl();
    }

    public function getAbsoluteThumbnailUrl() {
        return Yii::app()->getBaseUrl(true) . '/' . $this->getThumbnailUrl();
    }

    public function getImageUrl() {
        return $this->image_url;
    }

    public function getImageType() {
        return $this->image_type;
    }

    public function getThumbnailUrl() {
        return $this->tn_url;
    }

    public function getOriginalImageUrl() {
        return $this->original_image_url;
    }

    public function getDisplayOrder() {
        return $this->display_order;
    }

    public function setImageUrl($v) {
        $this->image_url = $v;
    }

    public function setImageType($v) {
        $this->image_type = $v;
    }

    public function setThumbnailUrl($v) {
        $this->tn_url = $v;
    }

    public function setOriginalImageUrl($v) {
        $this->original_image_url = $v;
    }

    public function setDisplayOrder($v) {
        $this->display_order = $v;
    }

}

