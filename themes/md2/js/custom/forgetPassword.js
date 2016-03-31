$(function () {
    //验证码登录
    var domForm = $("#forgetPassword-form"), // form - html dom object.;
            btnSubmit = $("#btnSubmit");
    // 手机号码验证
    $.validator.addMethod("isMobile", function (value, element) {
        var length = value.length;
        var mobile = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;
        return this.optional(element) || (length == 11 && mobile.test(value));
    }, "请填写正确的手机号码");

    btnSubmit.click(function () {
        var bool = validator.form();
        if (bool) {
            formAjaxSubmit();
        }
    });
    //登陆页面表单验证模块
    var validator = domForm.validate({
        //focusInvalid: true,
        rules: {
            'ForgetPasswordForm[username]': {
                required: true,
                isMobile: true
            },
            'ForgetPasswordForm[verify_code]': {
                required: true,
                digits: true,
                maxlength: 6,
                minlength: 6
            },
            'ForgetPasswordForm[password_new]': {
                required: true,
                maxlength: 40,
                minlength: 4
            }
        },
        messages: {
            'ForgetPasswordForm[username]': {
                required: "请输入手机号码",
                isMobile: '请输入正确的中国手机号码!'
            },
            'ForgetPasswordForm[verify_code]': {
                required: "请输入验证码",
                digits: "请输入正确的验证码",
                maxlength: "请输入正确的验证码",
                minlength: "请输入正确的验证码"
            },
            'ForgetPasswordForm[password_new]': {
                required: "请输入新密码",
                maxlength: "请输入40位以内密码",
                minlength: "密码至少4位"
            }
        },
        errorElement: "div",
        errorPlacement: function (error, element) {                             //错误信息位置设置方法  
            element.parents('div.input').find("div.error").remove();
            element.parents('div.input').find("div.errorMessage").remove();
            error.appendTo(element.parents('div.input'));                        //这里的element是录入数据的对象  
        }
    });


    function formAjaxSubmit() {
        //form插件的异步无刷新提交
        disabledBtn(btnSubmit);
        var formdata = domForm.serialize();
        requestUrl = domForm.attr("data-url-action");
        returnUrl = domForm.attr('data-url-return');
        $.ajax({
            type: 'post',
            url: requestUrl,
            data: formdata,
            success: function (data) {
                console.log(data);
                //success.
                if (data.status == 'ok') {
                    window.location.href = returnUrl + '?page=1';
                } else {
                    domForm.find("div.error").remove();
                    for (error in data.errors) {
                        errerMsg = data.errors[error];
                        inputKey = '#ForgetPasswordForm_' + error;
                        $(inputKey).focus();
                        $(inputKey).parents('.inputBorder').after("<div class='error'>" + errerMsg + "</div> ");
                    }
                    enableBtn(btnSubmit);
                }
            }
        });
    }
});

