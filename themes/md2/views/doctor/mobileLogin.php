<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.form.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.validate.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/loginValidator.js', CClientScript::POS_END);
/*
 * $model UserDoctorMobileLoginForm.
 */
$this->setPageID('pDoctorLogin');
$this->setPageTitle('医生登录');
$urlRegister = $this->createUrl("doctor/register", array('addBackBtn' => 1));
$urlForgetPassword = $this->createUrl('doctor/forgetPassword', array('addBackBtn' => 1));
$urlPage = Yii::app()->request->getQuery('page', '0');
$urlGetSmsVerifyCode = $this->createAbsoluteUrl('/auth/sendSmsVerifyCode');
$authActionType = AuthSmsVerify::ACTION_USER_LOGIN;
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
?>
<style>
    header .control-group{
        width:180px;
    }
</style>
<header class="bg-green">
    <?php
    if (($loginType == 'sms') && ($urlPage == 1)) {
        $loginType = 'paw';
    }
    $smsActive = 'active';
    $smsHide = '';
    $pawActive = '';
    $pawHide = 'hide';
    if (isset($loginType)) {
        if ($loginType == 'paw') {
            $smsActive = '';
            $smsHide = 'hide';
            $pawActive = 'active';
            $pawHide = '';
        }
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
                        'action' => $this->createUrl('doctor/mobileLogin'),
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
                    <div class="input">
                        <?php echo $form->textField($model, 'username', array('placeholder' => '请输入您的手机号')); ?>
                        <?php echo $form->error($model, 'username'); ?>
                        <div class="error"></div>
                    </div>
                    <div class="mt40 input">
                        <div class="grid inputBorder mb10">
                            <div class="col-1">
                                <?php echo $form->textField($model, 'verify_code', array('placeholder' => '请输入验证码', 'class' => 'noPaddingInput')); ?>
                            </div>
                            <div class="col-0 w2p mt5 mb5 br-gray">
                            </div>
                            <div class="col-0 sendSmsCodeBtn">
                                <button id="btn-sendSmsCode" class="btn btn-sendSmsCode ui-corner-all ui-shadow">获取验证码</button>
                            </div>
                        </div>
                        <?php echo $form->error($model, 'verify_code'); ?>
                        <div class="error"></div>
                    </div>
                    <div class="mt40">
    <!--                            <input id="btnSubmit" class="btn btn-yes btn-block" type="button" data-ajax="false"  name="yt0" value="登录/注册"> -->
                        <a id="btnSubmitSms" class="btn btn-yes btn-block">登录</a>
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
                        'action' => $this->createUrl('doctor/mobileLogin'),
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
                        <?php echo $form->error($pawModel, 'username'); ?>
                        <div class="error"></div>
                    </div>
                    <div class="mt50 input">
                        <div class="grid inputBorder mb10">
                            <div class="col-0 lockIcon">
                            </div>
                            <div class="col-0 w2p br-gray mt10 mb10">
                            </div>
                            <div class="col-1">
                                <?php echo $form->passwordField($pawModel, 'password', array('placeholder' => '请输入密码', 'class' => 'noPaddingInput')); ?>
                            </div>
                        </div>
                        <?php echo $form->error($pawModel, 'password'); ?>
                        <div class="error"></div>
                    </div>
                    <div class="mt40">
    <!--                            <input id="btnSubmit" class="btn btn-yes btn-block" type="button" data-ajax="false"  name="yt0" value="登录/注册"> -->
                        <a id="btnSubmitPaw" class="btn btn-yes btn-block">登录</a>
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
    <?php //$this->renderPartial("//doctor/_leftPanel");  ?>
    <!-- /panel -->
    <script>
        $(document).ready(function () {
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
                sendSmsVerifyCode($(this));
            });
        });
        function sendSmsVerifyCode(domBtn) {
            var domForm = $("#smsLogin-form");
            var domMobile = domForm.find("#UserDoctorMobileLoginForm_username");
            var mobile = domMobile.val();
            if (mobile.length === 0) {
                $("#UserDoctorMobileLoginForm_username-error").remove();
                $("#UserDoctorMobileLoginForm_username").parents('div.input').append("<div id='UserDoctorMobileLoginForm_username-error' class='error'>请输入手机号码</div>");
                //domMobile.parent().addClass("error");
            } else if (!validatorMobile(mobile)) {
                $("#UserDoctorMobileLoginForm_username-error").remove();
                $("#UserDoctorMobileLoginForm_username").parents('div.input').append("<div id='UserDoctorMobileLoginForm_username-error' class='error'>请输入正确的中国手机号码!</div>");
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
</div>

