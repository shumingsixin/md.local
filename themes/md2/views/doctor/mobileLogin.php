<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.form.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.validate.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/loginValidator.js', CClientScript::POS_END);
/*
 * $model UserDoctorMobileLoginForm.
 */
$this->setPageID('pDoctorLogin');
$this->setPageTitle('医生登录');
$urlRegister = $this->createUrl("/mobiledoctor/doctor/register");
$urlGetSmsVerifyCode = $this->createAbsoluteUrl('/auth/sendSmsVerifyCode');
$authActionType = AuthSmsVerify::ACTION_USER_LOGIN;
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
?>
<div id="section_container">
    <section id="login_section" class="active" data-init="true">
        <article class="active bg-gary" data-scroll="true">
            <div class="">
                <div class="text-center mt50 ml20 mr20">
                    <div class="">
                        <img src="<?php echo $urlResImage; ?>icons/logo.png" />
                    </div>
                </div>
                <div class="mt30">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'login-form',
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
                    <ul class="list">
                        <li>
                            <?php echo $form->labelEx($model, 'username', array('class' => 'ui-hidden-accessible')); ?>
                            <?php echo $form->numberField($model, 'username', array('placeholder' => '输入手机号码')); ?>
                            <?php echo $form->error($model, 'username'); ?>
                            <div class="error"></div>
                        </li>
                        <li>
                            <?php echo $form->labelEx($model, 'verify_code', array('class' => 'ui-hidden-accessible')); ?>
                            <div class="grid">
                                <div class="col-1">
                                    <?php echo $form->numberField($model, 'verify_code', array('placeholder' => '请输入短信验证码')); ?>
                                </div>
                                <div class="">
                                    <button id="btn-sendSmsCode" class="btn btn-sendSmsCode ui-corner-all ui-shadow">获取短信验证码</button>
                                </div>
                            </div>
                            <?php echo $form->error($model, 'verify_code'); ?>
                            <div class="error"></div>
                        </li>
                        <li>
<!--                            <input id="btnSubmit" class="btn btn-yes btn-block" type="button" data-ajax="false"  name="yt0" value="登录/注册"> -->
                            <a id="btnSubmit" class="btn btn-yes btn-block">登录/注册</a>
                        </li>
                    </ul>
                    <div class="">                
                        <div class="mt20 text-right">
        <!--                    <a href='<?php echo $urlRegister ?>' data-ajax="false" data-transition="slidefade">没有账号？立即注册</a>-->
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </article>

    </section>
    <!-- leftPanel -->
    <?php //$this->renderPartial("//doctor/_leftPanel");  ?>
    <!-- /panel -->
    <script>
        $(document).ready(function () {
            $("#btn-sendSmsCode").click(function (e) {
                e.preventDefault();
                sendSmsVerifyCode($(this));
            });
        });
        function sendSmsVerifyCode(domBtn) {
            var domForm = $("#login-form");
            var domMobile = domForm.find("#UserDoctorMobileLoginForm_username");
            var mobile = domMobile.val();
            if (mobile.length === 0) {
                $("#UserDoctorMobileLoginForm_username-error").remove();
                $("#UserDoctorMobileLoginForm_username").parents('li').append("<div id='UserDoctorMobileLoginForm_username-error' class='error'>请输入手机号码</div>");
                //domMobile.parent().addClass("error");
            } else if (!validatorMobile(mobile)) {
                $("#UserDoctorMobileLoginForm_username-error").remove();
                $("#UserDoctorMobileLoginForm_username").parents('li').append("<div id='UserDoctorMobileLoginForm_username-error' class='error'>请输入正确的中国手机号码!</div>");
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
                    domBtn.attr("disabled",false).removeAttr("disabled");;
                }
            }, interval);
        }
        function validatorMobile(mobile) {
            var mobileReg = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;
            return mobileReg.test(mobile);
        }
    </script>
</div>

