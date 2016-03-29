$(function () {

    var domForm = $("#login-form"), // form - html dom object.;
            btnSubmit = $("#btnSubmit");
    // 手机号码验证
    $.validator.addMethod("isMobile", function (value, element) {
        var length = value.length;
        var mobile = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;
        return this.optional(element) || (length == 11 && mobile.test(value));
    }, "请填写正确的手机号码");
    
    btnSubmit.click(function(){
        var bool = validator.form();
        if(bool){
            domForm.submit();
        }
    });
    //登陆页面表单验证模块
    var validator = domForm.validate({
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
            element.parents('li').find("div.error").remove();
            element.parents('li').find("div.errorMessage").remove();
            error.appendTo(element.parents('li'));                        //这里的element是录入数据的对象  
        }
    });

});

