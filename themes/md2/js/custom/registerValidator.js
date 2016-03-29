$(function () {
    var domForm = $("#user-form"), // form - html dom object.;
            btnSubmit = $("#btnSubmit"),
            returnUrl = domForm.attr("data-returnUrl");
    // 手机号码验证
    jQuery.validator.addMethod("isMobile", function (value, element) {
        var length = value.length;
        var mobile = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;
        return this.optional(element) || (length == 11 && mobile.test(value));
    }, "请填写正确的手机号码");
    //注册页面表单验证模块
    var validator = domForm.validate({
        //focusInvalid: true,
        rules: {
            'UserRegisterForm[username]': {
                required: true,
                isMobile: true
            },
            'UserRegisterForm[verify_code]': {
                required: true,
                digits: true,
                maxlength: 6,
                minlength: 6
            },
            'UserRegisterForm[password]': {
                required: true,
                maxlength: 40,
                minlength: 4
            },
            'UserRegisterForm[password_repeat]': {
                required: "请输入登录密码",
                equalTo: "#UserRegisterForm_password",
                minlength: 4
            }
        },
        messages: {
            'UserRegisterForm[username]': {
                required: "请输入手机号码",
                isMobile: '请输入正确的中国手机号码!'
            },
            'UserRegisterForm[verify_code]': {
                required: "请输入短信验证码",
                digits: "请输入正确的短信验证码",
                maxlength: "请输入正确的短信验证码",
                minlength: "请输入正确的短信验证码"
            },
            'UserRegisterForm[password]': {
                required: "请输入登录密码",
                maxlength: "最长为40个字母或数字",
                minlength: "最短为4个字母或数字"
            },
            'UserRegisterForm[password_repeat]': {
                required: "请输入登录密码",
                equalTo: "密码不一致",
                minlength: "最短为4个字母或数字"
            }
        },
        errorElement: "div",
        errorPlacement: function (error, element) {                             //错误信息位置设置方法  
            element.parent().next().html("");   //清除错误信息
            element.parent().removeClass("error");
            error.appendTo(element.parent().next());                        //这里的element是录入数据的对象  
        },
        submitHandler: function () {
            //form插件的异步无刷新提交
            disabledBtn(btnSubmit);
            requestUrl = domForm.attr('action');
            domForm.ajaxSubmit({
                type: 'post',
                url: requestUrl,
                success: function (data) {
                    //success.
                    if (data.status == 'ok') {
                        window.location.href = returnUrl;
                    } else {
                        //error.
                        enableBtn(btnSubmit);
                        error = data.error;
                        for (key in error) {
                            emid = "#UserRegisterForm_" + key;
                            $(emid).parent().next().text(error[key]).addClass("error").show();                            
                        }
                    }
                },
                error: function () {
                },
                complete: function () {
                    enableBtn(btnSubmit);
                }
            });
        }
    });

});

