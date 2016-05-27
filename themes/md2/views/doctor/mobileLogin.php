<?php
//Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.form.js', CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.validate.js', CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/loginValidator.js?ts=' . time(), CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.formvalidate.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/loginValidator.min.js?ts=' . time(), CClientScript::POS_END);
/*
 * $model UserDoctorMobileLoginForm.
 */
$this->setPageID('pDoctorLogin');
$this->setPageTitle('医生登录');
$urlRegister = $this->createUrl("doctor/register", array('addBackBtn' => 1));
$urlForgetPassword = $this->createUrl('doctor/forgetPassword', array('addBackBtn' => 1));
$urlPage = Yii::app()->request->getQuery('page', '0');
$urlGetSmsVerifyCode = $this->createAbsoluteUrl('/auth/sendSmsVerifyCode');
$urlDoctorValiCaptcha = $this->createUrl("doctor/valiCaptcha");
$urlAjaxLogin = $this->createUrl('doctor/ajaxLogin');
$authActionType = AuthSmsVerify::ACTION_USER_LOGIN;
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
?>
<header id="login_header" class="bg-green">
    <?php
    if ($loginType == 'sms') {
        $smsActive = 'active';
        $smsHide = '';
        $pawActive = '';
        $pawHide = 'hide';
    } else {
        $smsActive = '';
        $smsHide = 'hide';
        $pawActive = 'active';
        $pawHide = '';
    }
    ?>
    <ul class="control-group">
        <li data-page="smsLogin" class="pageSwitch <?php echo $smsActive; ?>">
            快速登录
        </li>
        <li data-apge="pawLogin" class="pageSwitch <?php echo $pawActive; ?>">
            密码登录
        </li>
    </ul>
</header>
<div id="section_container">
    <section id="login_section" class="active" data-init="true">
        <article id="login_article" class="active bg-gary" data-scroll="true">
            <div>
                <?php //var_dump($pawModel); ?>
                <div id="smsLogin" class="mt30 ml10 mr10 <?php echo $smsHide; ?>">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'smsLogin-form',
                        // Please note: When you enable ajax validation, make sure the corresponding
                        // controller action is handling ajax validation correctly.
                        // There is a call to performAjaxValidation() commented in generated controller code.
                        // See class documentation of CActiveForm for details on this.
                        'htmlOptions' => array('data-url-action' => $urlAjaxLogin, 'data-url-return' => $returnUrl, 'data-url-checkCode' => $urlDoctorValiCaptcha),
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
                    <div class="input">
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
                                <input type="text" id="UserDoctorMobileLoginForm_captcha_code" class="noPaddingInput" name="UserDoctorMobileLoginForm[captcha_code]" placeholder="请输入图形验证码">
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
                    <div class="mt40">
    <!--                            <input id="btnSubmit" class="btn btn-yes btn-block" type="button" data-ajax="false"  name="yt0" value="登录/注册"> -->
                        <a id="btnSubmitSms" class="btn btn-yes btn-full">登录</a>
                    </div>
                    <div class="">                
                        <div class="mt20 text-right">
        <!--                    <a href='<?php echo $urlRegister ?>' data-ajax="false" data-transition="slidefade">没有账号？立即注册</a>-->
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
                <div id="pawLogin" class="mt30 ml10 mr10 <?php echo $pawHide; ?>">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'pawLogin-form',
                        // Please note: When you enable ajax validation, make sure the corresponding
                        // controller action is handling ajax validation correctly.
                        // There is a call to performAjaxValidation() commented in generated controller code.
                        // See class documentation of CActiveForm for details on this.
                        'htmlOptions' => array('data-url-action' => $urlAjaxLogin, 'data-url-return' => $returnUrl),
                        'enableClientValidation' => false,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'validateOnType' => true,
                            'validateOnDelay' => 500,
                            'errorCssClass' => 'error',
                        ),
                        'enableAjaxValidation' => false,
                    ));
                    ?>
                    <div class="input">
                        <div class="grid inputBorder mb10">
                            <div class="col-0 phoneIcon">
                            </div>
                            <div class="col-0 w2p br-gray mt10 mb10">
                            </div>
                            <div class="col-1">
                                <?php echo $form->textField($pawModel, 'username', array('placeholder' => '请输入您的手机号', 'class' => 'noPaddingInput')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="input mt30">
                        <div class="grid inputBorder mb10">
                            <div class="col-0 lockIcon">
                            </div>
                            <div class="col-0 w2p br-gray mt10 mb10">
                            </div>
                            <div class="col-1">
                                <?php echo $form->passwordField($pawModel, 'password', array('placeholder' => '请输入密码', 'class' => 'noPaddingInput')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="mt40">
    <!--                            <input id="btnSubmit" class="btn btn-yes btn-block" type="button" data-ajax="false"  name="yt0" value="登录/注册"> -->
                        <a id="btnSubmitPaw" class="btn btn-yes btn-full">登录</a>
                    </div>
                    <div class="">                
                        <div class="mt20 text-right">
        <!--                    <a href='<?php echo $urlRegister ?>' data-ajax="false" data-transition="slidefade">没有账号？立即注册</a>-->
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
                <div class="grid">
                    <div class="w50 text-right pr20">
                        <a href="<?php echo $urlRegister; ?>">注册账号</a>
                    </div>
                    <div class="w50 pl20">
                        <a href="<?php echo $urlForgetPassword; ?>">忘记密码</a>
                    </div>
                </div>
            </div>
        </article>

    </section>
    <!-- leftPanel -->
    <?php //$this->renderPartial("//doctor/_leftPanel");   ?>
    <!-- /panel -->
    <script>
        $(document).ready(function () {
            vailcode();
            $('.pageSwitch').click(function () {
                var page = $(this).attr('data-page');
                if (page == 'smsLogin') {
                    $('#smsLogin').removeClass('hide');
                    $('#pawLogin').addClass('hide');
                } else {
                    $('#smsLogin').addClass('hide');
                    $('#pawLogin').removeClass('hide');
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
            var domForm = $("#smsLogin-form");
            var domMobile = domForm.find("#UserDoctorMobileLoginForm_username");
            var captchaCode = $('#UserDoctorMobileLoginForm_captcha_code').val();
            var mobile = domMobile.val();
            if (mobile.length === 0) {
                $("#UserDoctorMobileLoginForm_username-error").remove();
                $("#UserDoctorMobileLoginForm_username").parents('div.input').append("<div id='UserDoctorMobileLoginForm_username-error' class='error'>请输入手机号码</div>");
                //domMobile.parent().addClass("error");
            } else if (!validatorMobile(mobile)) {
                $("#UserDoctorMobileLoginForm_username-error").remove();
                $("#UserDoctorMobileLoginForm_username").parents('div.input').append("<div id='UserDoctorMobileLoginForm_username-error' class='error'>请输入正确的中国手机号码!</div>");
            } else if (captchaCode == '') {
                $('#UserDoctorMobileLoginForm_captcha_code-error').remove();
                $('#captchaCode').after('<div id="UserDoctorMobileLoginForm_captcha_code-error" class="error">请输入图形验证码</div>');
            } else {
                $('#UserDoctorMobileLoginForm_captcha_code-error').remove();
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
                            $('#captchaCode').after('<div id="UserDoctorMobileLoginForm_captcha_code-error" class="error">' + data.error + '</div>');
                        }
                    }
                });
            }
        }
        function sendSmsVerifyCode(domBtn, domForm, mobile, captchaCode) {
            $(".error").html(""); //删除错误信息
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
                            $('#captchaCode').after('<div id="UserDoctorMobileLoginForm_captcha_code-error" class="error">' + data.errors.captcha_code + '</div>');
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
</div>

