<?php
Yii::app()->clientScript->registerCssFile('http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/webuploader/css/webuploader.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/js/webuploader/css/webuploader.custom.css');
Yii::app()->clientScript->registerScriptFile('http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/bootstrap.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/jquery.form.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/jquery.validate.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/webuploader/js/webuploader.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/webuploader/js/custom/patientmr.js', CClientScript::POS_END);
?>	
<?php
/*
 * $model PatientMRForm.
 */
$this->setPageID('pCreatePatientMR');
$this->setPageTitle('上传患者病历');
$urlLogin = $this->createUrl('doctor/login');

$urlSubmitMR = $this->createUrl("patient/ajaxCreatePatientMR");
$urlUploadFile = $this->createUrl("patient/ajaxUploadMRFile");
$urlReturn = $this->createUrl('patientbooking/create');

if (isset($model->id)) {
    $urlPatientMRFiles = $this->createUrl('patient/patientMRFiles', array('id' => $model->id));
    $urldelectPatientMRFile = $this->createUrl('patient/delectPatientMRFile');
} else {
    $urlPatientMRFiles = "";
    $urldelectPatientMRFile = "";
}
?>

<style>
    .patientinfo span{padding: 0 9px;}
    .border-right{border-right: 1px solid #888;}
    .ui-grid-b .ui-block-a,.ui-grid-b .ui-block-c{width: 45%;}
    .ui-grid-b .ui-block-b{width: 10%;padding: 14px 0;text-align: center;}
    .ui-popup-container{max-width: 375px;width: 100%;bottom:16em!important;top:auto!important;}
</style>
<div id="<?php echo $this->getPageID(); ?>" data-role="page" data-title="<?php echo $this->getPageTitle(); ?>">
    <div data-role="content">
        <div class="form-wrapper">
            <?php
            //var_dump($model);
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'patient-form',
                'action' => $urlSubmitMR,
                'htmlOptions' => array("enctype" => "multipart/form-data", 'data-url-uploadFile' => $urlUploadFile, 'data-url-return' => $urlReturn),
                'enableClientValidation' => false,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'validateOnType' => true,
                    'validateOnDelay' => 500,
                    'errorCssClass' => 'error',
                ),
                'enableAjaxValidation' => false,
            ));

            //echo $form->hiddenField($model, 'patient_id', array('name' => 'patient[id]'));
            echo $form->hiddenField($model, 'id', array('name' => 'patient[id]'));
            ?>
            <div class="ui-field-contain">
                <label for="booking_info" class="patientinfo">
                    <span>患者：</span><span class="patientname border-right"><?php echo $model->getPatientName(); ?></span><span class="patientage border-right"><?php echo $model->getPatientAge(); ?>岁</span><span class="patientgender border-right"><?php echo $model->getPatientGender(); ?></span><span class="patientcity"><?php echo $model->getPatientCity(); ?></span>
                </label>
            </div>
            <div class="ui-field-contain">
                <?php echo CHtml::activeLabel($model, 'disease_name'); ?>
                <?php echo $form->textField($model, 'disease_name', array('name' => 'patient[disease_name]', 'placeholder' => '', 'maxlength' => 50)); ?>
                <?php echo $form->error($model, 'disease_name'); ?> 
            </div>
            <div class="ui-field-contain">
                <?php echo CHtml::activeLabel($model, 'disease_detail'); ?>                                           
                <?php echo $form->textArea($model, 'disease_detail', array('name' => 'patient[disease_detail]', 'placeholder' => '请对病情进行详细得描述', 'maxlength' => 1000)); ?>
                <?php echo $form->error($model, 'disease_detail'); ?> 
            </div>
            <div class="ui-field-contain">
                <label for="btn-addfiles" class="">上传影像资料：</label>
                <p>请上传至少一张影像报告</p>
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
                        </div>
                        <!--一开始就显示提交按钮就注释上面的提交 取消下面的注释 -->
                        <!--                         <div class="statusBar uploadBtn">提交</div>-->
                        <div class="ui-field-contain">
                            <br />
                            <input id="btnSubmit" class="statusBar uploadBtn state-pedding" type="button" name="yt0" value="提交">                                   
                        </div>
                    </div>

                </div>
            </div>

            <?php $this->endWidget(); ?>            
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
    <div data-role="popup" id="confirmPopup" style="padding:10px 20px;">
        <p>确认删除这张资格证?</p>
        <div class="mt20">
            <span><a href="#" data-rel="back" class="ui-btn btn-default">取消</a></span>
            <span><a href="#" data-rel="back" data-id="" class="confirm ui-btn btn-yse">确认</a></span>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            //加载病人病历图片
            urlPatientMRFiles = "<?php echo $urlPatientMRFiles; ?>";
            $.ajax({
                url: urlPatientMRFiles,
                success: function (data) {
                    setImgHtml(data.files);
                }
            });
        });
        function setImgHtml(imgfiles) {
            var innerHtml = '';
            if (imgfiles && imgfiles.length > 0) {
                for (i = 0; i < imgfiles.length; i++) {
                    imgfile = imgfiles[i];
                    innerHtml +=
                            '<li id="' +
                            imgfile.id + '"><p class="imgWrap"><img src="' +
                            imgfile.absFileUrl + '"></p><div class="file-panel"><span class="cancel">删除</span></div></li>';
                }
            } else {
                innerHtml += '';
            }
            $(".imglist .filelist").html(innerHtml);
            initDelete();
        }
        function initDelete() {
            $(".imglist .cancel").click(function () {
                domLi = $(this).parents("li");
                id = domLi.attr("id");
                $("#confirmPopup .confirm").attr("data-id", id);
                $("#confirmPopup").popup('open');
            });
            $("#confirmPopup .confirm").click(function () {
                id = $(this).attr("data-id");
                domId = "#" + id;
                domLi = $(domId);
                deleteImg(id, domLi);
            });
        }
        function deleteImg(id, domLi) {
            urlDelectDoctorCert = '<?php echo $urldelectPatientMRFile ?>/id/' + id;
            $.ajax({
                url: urlDelectDoctorCert,
                beforeSend: function () {
                    $(".ui-loading").show();
                },
                success: function (data) {
                    if (data.status == 'ok') {
                        domLi.remove();
                    }
                },
                complete: function () {
                    $(".ui-loading").hide();
                }
            });
        }
    </script>
</div>

