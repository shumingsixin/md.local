<?php
Yii::app()->clientScript->registerCssFile('http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/webuploader/css/webuploader.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/js/webuploader/css/webuploader.custom.css');
Yii::app()->clientScript->registerScriptFile('http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/webuploader/js/webuploader.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/uploadMRFile.js', CClientScript::POS_END);
?>	
<?php
/*
 * $model PatientMRForm.
 */
$this->setPageID('pCreatePatientMR');
$this->setPageTitle('上传病历');
$urlLogin = $this->createUrl('doctor/login');

$urlSubmitMR = $this->createUrl("patient/ajaxCreatePatientMR");
$urlUploadFile = $this->createUrl("patient/ajaxUploadMRFile");
$type = Yii::app()->request->getQuery('type', 'create');
$patientId = $output['id'];
//if ($type == 'update') {
//    $urlReturn = $this->createUrl('patient/view', array('id' => $patientId));
//} else {
//    $urlReturn = $this->createUrl('patientbooking/create', array('pid' => $patientId));
//}
$urlReturn = $this->createUrl('patientbooking/create', array('pid' => $patientId));

$urlResImage = Yii::app()->theme->baseUrl . "/images/";
?>


<div id="<?php echo $this->getPageID(); ?>" data-role="page" data-title="<?php echo $this->getPageTitle(); ?>" style="margin-top: 39px;">
    <style>
        .ui-grid-b .ui-block-a,.ui-grid-b .ui-block-c{width: 45%;}
        .ui-grid-b .ui-block-b{width: 10%;padding: 14px 0;text-align: center;}
        .ui-popup-container{max-width: 375px;width: 100%;bottom:16em!important;top:auto!important;}
        .example{border: 1px dotted #888;margin: 30px 10px 10px;padding: 10px;}
        .example .ui-grid-b .ui-block-a,.example .ui-grid-b .ui-block-c{width: 40%}
        .example .ui-grid-b .ui-block-b{width: 20%;text-align: center;padding-top: 30px;}
        .example .ui-grid-b .ui-block-b span{vertical-align: middle;}
    </style>
    <div data-role="content">
        <div class="form-wrapper">
            <form id="patient-form" data-url-uploadfile="<?php echo $urlUploadFile; ?>" data-url-return="<?php echo $urlReturn; ?>">
                <input id="patientId" type="hidden" name="patient[id]" value="<?php echo $output['id']; ?>" />                
            </form>
            <!--
            <div class="urlReturn hide"><?php echo $urlReturn . "?id=" . $output['id']; ?></div>
            <div class="patient_id hide"><?php echo $output['id']; ?></div>
            <div class="urlUploadFile hide"><?php echo $urlUploadFile; ?></div>
            -->
            <div class="ui-field-contain">
                <label for="btn-addfiles" class="">上传影像资料：<a href="<?php echo $urlReturn; ?>" class="pull-right btn btn-yes" data-ajax="false">跳过</a></label>

                <div class="">    
                    <!--图片上传区域 -->
                    <div id="uploader" class="wu-example">
                        <div class="imglist">
                            <ul class="filelist"></ul>
                        </div>
                        <div class="queueList">
                            <div id="dndArea" class="placeholder">
                                <div id="filePicker"></div>
                                <!-- <p>或将照片拖到这里，单次最多可选10张</p>-->
                            </div>
                        </div>
                        <div class="statusBar" style="display:none; padding-bottom: 40px;">
                            <div class="progress">
                                <span class="text">0%</span>
                                <span class="percentage"></span>
                            </div>
                            <div class="info"></div>
                            <div class="">
                                <!-- btn 继续添加 -->
                                <div id="filePicker2" class="pull-right"></div>                                
                            </div>
                            <div class="ui-field-contain">
                                <br />
                                <input id="btnSubmit" class="statusBar uploadBtn state-pedding" type="button" name="yt0" value="提交">                                   
                            </div>
                        </div>
                        <!--一开始就显示提交按钮就注释上面的提交 取消下面的注释 -->
                        <!--                         <div class="statusBar uploadBtn">提交</div>-->

                    </div>
                    <div class="example">
                        <label class="color-red">示例:</label>
                        <div class="ui-grid-b">
                            <div class="ui-block-a">
                                <img src="<?php echo $urlResImage; ?>patientexample1.jpg"/>
                            </div>
                            <div class="ui-block-b">
                                <span>或</span>
                            </div>
                            <div class="ui-block-c">
                                <img src="<?php echo $urlResImage; ?>patientexample2.jpg"/>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <a id="toTip" class="hide" href="#tipPage" data-rel="popup">提示页</a>
        <div class="mt30"></div>
    </div> 
    <div data-role="popup" id="tipPage" class="" data-title="错误提示">
        <a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Close</a>
        <div data-role="header">
            <h1>错误提示</h1>
        </div>

        <div data-role="content" class="tipcontent">
            <p>文件添加失败</p>
            <a class="mt20" href="javascript:;" data-role="button" data-rel="back" >确 定</a> 
        </div>
    </div>
</div>

