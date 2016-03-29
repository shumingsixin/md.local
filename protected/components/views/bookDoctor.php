<!--
<style>
    #site-header,#site-footer{display: none;}
    .form-wrapper{margin-left:20px;}
    #uploader .queueList{max-height:340px;overflow-y:scroll;}
    .page-container{border:1px solid #ddd;padding-left: 15px;padding-right: 15px;}
    #header-nav{display: none;}
    .header-menu{border: 0!important;}
    #booking-form .control-label{padding-top:7px;float: left;padding-left: 0;padding-right: 0;width: 70px;text-align: right}
    #booking-form .controls{width:220px;padding-right:0;float:left;}   
    .error{color: #f00;}
</style>
-->
<?php
/*
  Yii::app()->clientScript->registerCssFile('http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/webuploader/css/webuploader.css');
  Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/js/webuploader/css/webuploader.custom.css');
  //Yii::app()->clientScript->registerScriptFile('http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/bootstrap.min.js', CClientScript::POS_HEAD);
  Yii::app()->clientScript->registerScriptFile('http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/jquery.form.js', CClientScript::POS_END);
  Yii::app()->clientScript->registerScriptFile('http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/jquery.validate.min.js', CClientScript::POS_END);
  Yii::app()->clientScript->registerScriptFile('http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/webuploader/js/webuploader.min.js', CClientScript::POS_END);
  Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/booking.js', CClientScript::POS_END);
 * 
 */
/**
 * $model BookingDoctorForm
 */
$urlGetSmsVerifyCode = Yii::app()->createUrl('/auth/sendSmsVerifyCode');
$authActionType = AuthSmsVerify::ACTION_USER_REGISTER;
$urlSubmitForm = Yii::app()->createUrl("booking/ajaxCreate");
$urlUploadFile = Yii::app()->createUrl("booking/ajaxUploadFile");
$urlReturn = '#success';
?>
<div class="form-wrapper">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'booking-form',
        'action' => $urlSubmitForm,
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'htmlOptions' => array('class' => "form-horizontal", 'role' => 'form', 'autocomplete' => 'off', "enctype" => "multipart/form-data", 'data-url-uploadFile' => $urlUploadFile, 'data-url-return' => $urlReturn),
        'enableClientValidation' => false,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnType' => true,
            'validateOnDelay' => 500,
            'errorCssClass' => 'error',
        ),
        'enableAjaxValidation' => false,
    ));
    echo CHtml::hiddenField("smsverify[actionUrl]", $urlGetSmsVerifyCode);
    echo CHtml::hiddenField("smsverify[actionType]", $authActionType);
    echo $form->hiddenField($model, 'doctor_id', array('name' => 'booking[doctor_id]'));
    ?>
    <div class="form-group">
        <label for="" class="padright0 col-sm-3 col-md-3 control-label">专家:</label>
        <div class="col-sm-8 controls">        
            <h4><?php echo $model->doctor_name; ?></h4>
            <h4><?php echo $model->hospital_name; ?></h4>
            <h4><?php echo $model->hp_dept_name; ?></h4> 
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="form-group">
        <label for="" class="padright0 col-sm-3 col-md-3 control-label">患者姓名:</label>
        <div class="col-sm-8 controls">
            <?php
            echo $form->textfield($model, 'contact_name', array('name' => 'booking[contact_name]', 'placeholder' => '请填写患者的真实姓名', 'class' => 'form-control', 'maxlength' => 45));
            echo $form->error($model, 'contact_name');
            ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="form-group">
        <label for="" class="padright0 col-sm-3 col-md-3 control-label">手机:</label>
        <div class="col-sm-8 controls">
            <?php
            echo $form->textField($model, 'mobile', array('name' => 'booking[mobile]', 'placeholder' => '请输入手机号', 'class' => 'form-control', 'maxlength' => 11));
            echo $form->error($model, 'mobile');
            ?>                     
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="form-group">
        <label for="" class="padright0 col-sm-3 col-md-3 control-label">验证码:</label>
        <div class="col-sm-8 controls">
            <div class="input-group">
                <?php echo $form->textField($model, 'verify_code', array('name' => 'booking[verify_code]', 'placeholder' => '请输入验证码', 'class' => 'form-control', 'maxlength' => 6)); ?>
                <div id="btn-sendSmsCode" class="btn input-group-addon  btn-verifycode">获取验证码</div>
            </div>
            <?php echo $form->error($model, 'verify_code'); ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="form-group">
        <label for="" class="padright0 col-sm-3 col-md-3 control-label">疾病诊断:</label>
        <div class="col-sm-8 controls">            
            <?php echo $form->textField($model, 'disease_name', array('name' => 'booking[disease_name]', 'placeholder' => '请填写确诊疾病', 'class' => 'form-control', 'maxlength' => 50)); ?>                
            <?php echo $form->error($model, 'disease_name'); ?>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="form-group">
        <label for="" class="padright0 col-sm-3 control-label">病情:</label>
        <div class="col-sm-8 controls">   
            <?php
            echo $form->textarea($model, 'disease_detail', array('name' => 'booking[disease_detail]', 'placeholder' => '请详细的描述患者的病情', 'class' => 'form-control', 'maxlength' => 1000, 'rows' => 3));
            echo $form->error($model, 'disease_detail');
            ?>                              
        </div>
    </div>
    <div class="form-group">    
        <div class="col-sm-12">
            <?php echo $this->render('_uploadFile'); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12">
            <button id="btnSubmit" type="button" class="btn btn-lg btn-yes btn-block" name="">提&nbsp;交</button>       
        </div>
        <div class="clearfix"></div>
    </div>

    <?php
    $this->endWidget();
    ?>
</div>
<!-- tip Modal -->
<div class="modal fade" id="tipModal" tabindex="-1" role="dialog" aria-labelledby="tipModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="tipModallLabel">错误提示</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">确认</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#btn-sendSmsCode").click(function () {
            sendSmsVerifyCode($(this));
        });
    });

    function sendSmsVerifyCode(domBtn) {
        var domMobile = $("#booking_mobile");
        var mobile = domMobile.val();
        if (mobile.length === 0) {
            $("#booking_mobile-error").remove();
            $("#booking_mobile").after('<div id="booking_mobile-error" class="error">请填写手机号码</div>');
        } else if (domMobile.parent().hasClass("error")) {
            // mobile input field as error, so do nothing.
        } else {
            buttonTimerStart(domBtn, 60000);
            $domForm = $("#booking-form");
            var actionUrl = $domForm.find("input[name='smsverify[actionUrl]']").val();
            var actionType = $domForm.find("input[name='smsverify[actionType]']").val();
            var formData = new FormData();
            formData.append("AuthSmsVerify[mobile]", mobile);
            formData.append("AuthSmsVerify[actionType]", actionType);

            $.ajax({
                type: 'post',
                url: actionUrl,
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                'success': function (data) {
                    if (data.status === true) {
                        //domForm[0].reset();
                    }
                    else {
                        console.log(data);
                    }
                },
                'error': function (data) {
                    console.log(data);
                },
                'complete': function () {
                }
            });
        }
    }
</script>