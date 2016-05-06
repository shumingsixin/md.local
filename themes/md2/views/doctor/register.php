<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.form.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.validate.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/register.js', CClientScript::POS_END);
?>
<?php
$this->setPageTitle('用户注册');
$urlRegister = $this->createUrl("doctor/register");
$urlGetSmsVerifyCode = $this->createAbsoluteUrl('/auth/sendSmsVerifyCode');
$urlDoctorValiCaptcha = $this->createUrl("doctor/valiCaptcha");
$urlDoctorAjaxRegister = $this->createUrl('doctor/ajaxRegister');
$urlDoctorView = $this->createUrl('doctor/view');
$authActionType = AuthSmsVerify::ACTION_USER_REGISTER;
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$this->show_footer = false;
?>
<header class="bg-green">
    <nav class="left">
        <a href="" data-target="back">
            <div class="pl5">
                <img src="<?php echo $urlResImage; ?>back.png" class="w11p">
            </div>
        </a>
    </nav>
    <h1 class="title">用户注册</h1>
</header>
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
                    'htmlOptions' => array('role' => 'form', 'autocomplete' => 'off', 'data-ajax' => 'false', 'data-url-checkCode' => $urlDoctorValiCaptcha, 'data-url-action' => $urlDoctorAjaxRegister, 'data-url-return' => $urlDoctorView),
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
                <input type="hidden" name="UserRegisterForm[role]" value="<?php echo $model->role; ?>">
                <input type="hidden" name="UserRegisterForm[terms]" value="<?php echo $model->terms; ?>">
                <div class="input mt30">
                    <div class="">
                        <div class="inputBorder mb10">
                            <?php echo $form->textField($model, 'username', array('placeholder' => '请输入您的手机号', 'class' => 'noPaddingInput')); ?>
                        </div>
                        <?php echo $form->error($model, 'username'); ?>
                    </div>
                </div>
                <div class="input mt30">
                    <div id="captchaCode" class="grid inputBorder mb10">
                        <div class="col-1">
                            <input type="text" id="UserRegisterForm_captcha_code" class="noPaddingInput" name="UserRegisterForm[captcha_code]" placeholder="请输入图形验证码">
                        </div>
                        <div class="col-0 w2p mt5 mb5 br-gray">
                        </div>
                        <div class="col-0 w95p text-center">
                            <div class="input-group-addon">
                                <a href="javascript:void(0);"><img src="<?php echo Yii::app()->request->baseUrl; ?>/mobiledoctor/doctor/getCaptcha" class="h40" onclick="this.src = '<?php echo Yii::app()->request->baseUrl; ?>/mobiledoctor/doctor/getCaptcha/' + Math.random()"></a>
                            </div>
                        </div>
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
                    <a id="btnSubmit" class="btn btn-yes btn-full">注册</a>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </article>
    </section>
</div>
<script>
    $(document).ready(function () {
        vailcode();
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
            checkForm($(this));
        });
    });
    function vailcode() {
        $("#vailcode").attr("src", "<?php echo $this->createUrl('user/getCaptcha'); ?>/" + Math.random());
    }
    function checkForm(domBtn) {
        var domForm = $("#register-form");
        var domMobile = domForm.find("#UserRegisterForm_username");
        var captchaCode = $('#UserRegisterForm_captcha_code').val();
        var mobile = domMobile.val();
        if (mobile.length === 0) {
            $("#UserRegisterForm_username-error").remove();
            $("#UserRegisterForm_username").parents('div.input').append("<div id='UserRegisterForm_username-error' class='error'>请输入手机号码</div>");
            //domMobile.parent().addClass("error");
        } else if (!validatorMobile(mobile)) {
            $("#UserRegisterForm_username-error").remove();
            $("#UserRegisterForm_username").parents('div.input').append("<div id='UserRegisterForm_username-error' class='error'>请输入正确的中国手机号码!</div>");
        } else if (captchaCode == '') {
            $('#UserRegisterForm_captcha_code-error').remove();
            $('#captchaCode').after('<div id="UserRegisterForm_captcha_code-error" class="error">请输入图形验证码</div>');
        } else {
            $('#UserRegisterForm_captcha_code-error').remove();
            var formdata = domForm.serializeArray();
            //check图形验证码
            $.ajax({
                type: 'post',
                url: '<?php echo $urlDoctorValiCaptcha; ?>?co_code=' + captchaCode,
                data: formdata,
                success: function (data) {
                    //console.log(data);
                    if (data.status == 'ok') {
                        sendSmsVerifyCode(domBtn, domForm, mobile, captchaCode);
                    } else {
                        $('#captchaCode').after('<div id="UserRegisterForm_captcha_code-error" class="error">' + data.error + '</div>');
                    }
                }
            });
        }
    }
    function sendSmsVerifyCode(domBtn, domForm, mobile, captchaCode) {
        $(".error").html("");//删除错误信息
        var actionUrl = domForm.find("input[name='smsverify[actionUrl]']").val();
        var actionType = domForm.find("input[name='smsverify[actionType]']").val();
        var formData = new FormData();
        formData.append("AuthSmsVerify[mobile]", mobile);
        formData.append("AuthSmsVerify[actionType]", actionType);
        $.ajax({
            type: 'post',
            url: actionUrl + '?captcha_code=' + captchaCode,
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
            'success': function (data) {
                if (data.status === true || data.status === 'ok') {
                    //domForm[0].reset();
                    buttonTimerStart(domBtn, 60000);
                }
                else {
                    console.log(data);
                    if (data.errors.captcha_code != undefined) {
                        $('#captchaCode').after('<div id="UserRegisterForm_captcha_code-error" class="error">' + data.errors.captcha_code + '</div>');
                    }
                }
            },
            'error': function (data) {
                console.log(data);
            },
            'complete': function () {
            }
        });
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