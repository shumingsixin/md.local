<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.form.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.validate.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/register.js', CClientScript::POS_END);
?>
<?php
$this->setPageTitle('用户注册');
$urlRegister = $this->createUrl("doctor/register");
$urlGetSmsVerifyCode = $this->createAbsoluteUrl('/auth/sendSmsVerifyCode');
$authActionType = AuthSmsVerify::ACTION_USER_REGISTER;
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$this->show_footer = false;
?>
<style>
    header .control-group{
        width:160px;
    }
</style>
<div id="section_container" <?php echo $this->createPageAttributes(); ?> >
    <section id="" class="active" data-init="true">
        <article id="register_article" class="active" data-scroll="true">
            <div class="ml10 mr10">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'register-form',
                    'action' => $this->createUrl('doctor/register'),
                    // Please note: When you enable ajax validation, make sure the corresponding
                    // controller action is handling ajax validation correctly.
                    // There is a call to performAjaxValidation() commented in generated controller code.
                    // See class documentation of CActiveForm for details on this.
                    'htmlOptions' => array('role' => 'form', 'autocomplete' => 'off', 'data-ajax' => 'false'),
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
                ?>
                <div class="input mt30">
                    <div class="">
                        <div class="inputBorder mb10">
                            <?php echo $form->textField($model, 'username', array('placeholder' => '请输入您的手机号', 'class' => 'noPaddingInput')); ?>
                        </div>
                        <?php echo $form->error($model, 'username'); ?>
                    </div>
                </div>
                <div class="input mt30">
                    <div class="grid inputBorder mb10">
                        <div class="col-1">
                            <?php echo $form->textField($model, 'verify_code', array('placeholder' => '请输入验证码', 'class' => 'noPaddingInput')); ?>
                        </div>
                        <div class="col-0 w2p mt5 mb5 br-gray">
                        </div>
                        <div class="col-0 w95p text-center">
                            <button id="btn-sendSmsCode" class="btn btn-sendSmsCode ui-corner-all ui-shadow">获取验证码</button>
                        </div>
                    </div>
                    <?php echo $form->error($model, 'verify_code'); ?>
                </div>
                <div class="input mt30">
                    <div class="grid inputBorder mb10">
                        <div class="col-1">
                            <?php echo $form->passwordField($model, 'password', array('placeholder' => '请输入您的密码', 'class' => 'noPaddingInput')); ?>
                        </div>
                        <div class="col-0 w2p mt5 mb5 br-gray">
                        </div>
                        <div class="col-0 w95p smsHide smsSwitch">
                        </div>
                    </div>
                    <?php echo $form->error($model, 'password'); ?>
                </div>
                <div class="mt40">
                    <a id="btnSubmit" class="btn btn-yes btn-block">注册</a>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </article>
    </section>
</div>
<script>
    $(document).ready(function () {
        //密码可见切换
        $('.smsSwitch').click(function () {
            if ($(this).hasClass('smsHide')) {
                $('#UserRegisterForm_password').attr('type', 'text');
                $(this).removeClass('smsHide');
                $(this).addClass('smsDisplay');
            } else {
                $('#UserRegisterForm_password').attr('type', 'password');
                $(this).removeClass('smsDisplay');
                $(this).addClass('smsHide');
            }
        });

        $("#btn-sendSmsCode").click(function (e) {
            e.preventDefault();
            sendSmsVerifyCode($(this));
        });
    });
    function sendSmsVerifyCode(domBtn) {
        var domForm = $("#register-form");
        var domMobile = domForm.find("#UserRegisterForm_username");
        var mobile = domMobile.val();
        if (mobile.length === 0) {
            $("#UserRegisterForm_username-error").remove();
            $("#UserRegisterForm_username").parents('div.input').append("<div id='UserRegisterForm_username-error' class='error'>请输入手机号码</div>");
            //domMobile.parent().addClass("error");
        } else if (!validatorMobile(mobile)) {
            $("#UserRegisterForm_username-error").remove();
            $("#UserRegisterForm_username").parents('div.input').append("<div id='UserRegisterForm_username-error' class='error'>请输入正确的中国手机号码!</div>");
        } else {
            $(".error").html("");//删除错误信息
            buttonTimerStart(domBtn, 60000);
            var actionUrl = domForm.find("input[name='smsverify[actionUrl]']").val();
            var actionType = domForm.find("input[name='smsverify[actionType]']").val();
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
                    if (data.status === true || data.status === 'ok') {
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
    function buttonTimerStart(domBtn, timer) {
        timer = timer / 1000 //convert to second.
        var interval = 1000;
        var timerTitle = '秒后重发';
        domBtn.attr("disabled", true);
        domBtn.html(timer + timerTitle);

        timerId = setInterval(function () {
            timer--;
            if (timer > 0) {
                domBtn.html(timer + timerTitle);
            } else {
                clearInterval(timerId);
                timerId = null;
                domBtn.html("重新发送");
                domBtn.attr("disabled", false).removeAttr("disabled");
                ;
            }
        }, interval);
    }
    function validatorMobile(mobile) {
        var mobileReg = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;
        return mobileReg.test(mobile);
    }
</script>