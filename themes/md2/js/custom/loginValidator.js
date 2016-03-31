$(function () {
    //验证码登录
    var domSmsForm = $("#smsLogin-form"), // form - html dom object.;
            btnSubmitSms = $("#btnSubmitSms");
    // 手机号码验证
    $.validator.addMethod("isMobile", function (value, element) {
        var length = value.length;
        var mobile = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;
        return this.optional(element) || (length == 11 && mobile.test(value));
    }, "请填写正确的手机号码");
    
    btnSubmitSms.click(function(){
        var bool = validator.form();
        if(bool){
            domSmsForm.submit();
        }
    });
    //登陆页面表单验证模块
    var validator = domSmsForm.validate({
        //focusInvalid: true,
        rules: {
            'UserDoctorMobileLoginForm[username]': {
                required: true,
                isMobile: true
            },
            'UserDoctorMobileLoginForm[verify_code]': {
                required: true,
                digits: true,
                maxlength: 6,
                minlength: 6
            }
        },
        messages: {
            'UserDoctorMobileLoginForm[username]': {
                required: "请输入手机号码",
                isMobile: '请输入正确的中国手机号码!'
            },
            'UserDoctorMobileLoginForm[verify_code]': {
                required: "请输入短信验证码",
                digits: "请输入正确的短信验证码",
                maxlength: "请输入正确的短信验证码",
                minlength: "请输入正确的短信验证码"
            }
        },
        errorElement: "div",
        errorPlacement: function (error, element) {                             //错误信息位置设置方法  
            element.parents('div.input').find("div.error").remove();
            element.parents('div.input').find("div.errorMessage").remove();
            error.appendTo(element.parents('div.input'));                        //这里的element是录入数据的对象  
        }
    });
    
    //密码登录
    var domPawForm = $("#pawLogin-form"), // form - html dom object.;
            btnSubmitPaw = $("#btnSubmitPaw");
    // 手机号码验证
    $.validator.addMethod("isMobile", function (value, element) {
        var length = value.length;
        var mobile = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;
        return this.optional(element) || (length == 11 && mobile.test(value));
    }, "请填写正确的手机号码");
    
    btnSubmitPaw.click(function(){
        var bool = validator.form();
        if(bool){
            domPawForm.submit();
        }
    });
    //登陆页面表单验证模块
    var validator = domPawForm.validate({
        //focusInvalid: true,
        rules: {
            'UserLoginForm[username]': {
                required: true,
                isMobile: true
            },
            'UserLoginForm[password]': {
                required: true,
                minlength: 1
            }
        },
        messages: {
            'UserLoginForm[username]': {
                required: "请输入手机号码",
                isMobile: '请输入正确的中国手机号码!'
            },
            'UserLoginForm[password]': {
                required: "请输入密码",
                minlength: "请输入正确的密码"
            }
        },
        errorElement: "div",
        errorPlacement: function (error, element) {                             //错误信息位置设置方法  
            element.parents('div.input').find("div.error").remove();
            element.parents('div.input').find("div.errorMessage").remove();
            error.appendTo(element.parents('div.input'));                        //这里的element是录入数据的对象  
        }
    });

});

