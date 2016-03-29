$(function () {

    var domForm = $("#doctor-form"), // form - html dom object.
            btnSubmit = $("#btnSubmit"),
            returnUrl = domForm.attr("data-url-return");

    btnSubmit.click(function () {
        var bool = validator.form();
        if (bool) {
            formAjaxSubmit();
        }
    });

    //医生认证表单验证板块
    var validator = domForm.validate({
        //focusInvalid: true,
        rules: {
            'doctor[name]': {
                required: true,
                maxlength: 45
            },
            'doctor[state_id]': {
                required: true
            },
            'doctor[city_id]': {
                required: true
            },
            'doctor[hospital_name]': {
                required: true
            },
            'doctor[hp_dept_name]': {
                required: true
            },
            'doctor[clinical_title]': {
                required: true
            },
            'doctor[academic_title]': {
                required: true
            },
            'doctor[mobile]': {
                required: true,
                isMobile: true
            },
            'doctor[verify_code]': {
                required: true,
                digits: true,
                maxlength: 6,
                minlength: 6
            },
            'doctor[password]': {
                required: true,
                minlength: 4
            },
            'doctor[password_repeat]': {
                required: true,
                equalTo: "#doctor_password"
            },
            'doctor[terms]': {
                required: true,
                min: 1,
                max: 1
            }
        },
        messages: {
            'doctor[name]': {
                required: "请填写称呼",
                maxlength: "请将字数控制在45以内"
            },
            'doctor[state_id]': {
                required: "请选择省份"
            },
            'doctor[city_id]': {
                required: "请选择城市"
            },
            'doctor[hospital_name]': {
                required: "请填写您所在的医院名称"
            },
            'doctor[hp_dept_name]': {
                required: "请填写您所在的科室名称"
            },
            'doctor[clinical_title]': {
                required: "请选择临床职称"
            },
            'doctor[academic_title]': {
                required: "请选择学术职称"
            },
            'doctor[mobile]': {
                required: "请填写手机号码",
                isMobile: '请输入正确的中国手机号码'
            },
            'doctor[verify_code]': {
                required: '请填写验证码',
                digits: '验证码只能为6位数字',
                maxlength: '验证码只能为6位数字',
                minlength: '验证码只能为6位数字'
            },
            'doctor[password]': {
                required: '请填写密码',
                minlength: '密码长度不得小于4'
            },
            'doctor[password_repeat]': {
                required: '请确认密码',
                equalTo: '密码不一致'
            },
            'doctor[terms]': {
                required: '请同意在线服务条款',
                min: '请同意在线服务条款',
                max: '请同意在线服务条款'
            }
        },
//        errorContainer: "div.error",
//        errorLabelContainer: $("#DoctorForm-form div .error"),
//        wrapper: "div",
        errorElement: "div",
        errorPlacement: function (error, element) {                             //错误信息位置设置方法  
            error.appendTo(element.parents("li"));                        //这里的element是录入数据的对象  
        }
    });
    function formAjaxSubmit() {
        //form插件的异步无刷新提交
        requestUrl = domForm.attr('data-url-action');
        var formdata = domForm.serializeArray();
        disabledBtn(btnSubmit);
        domForm.ajaxSubmit({
            type: 'post',
            url: requestUrl,
            data: formdata,
            success: function (data) {
                //success.
                if (data.status == 'ok') {
                    J.popup({
                        html: '<div><div class="popup-title">提示</div><div class="popup-content"><h4>提交成功！</h4><div class="mt20"><a data-target="link" href="' + returnUrl + '" class="btn btn-yes btn-block">确定</a></div></div></div>',
                        pos: 'center'
                    });
                } else {
                    //error.
                    domForm.find("div.error").remove();
                    for (error in data.errors) {
                        errerMsg = data.errors[error];
                        inputKey = '#doctor_' + error;
                        $(inputKey).focus();
                        $(inputKey).parent().after("<div class='error'>" + errerMsg + "</div> ");
                    }
                    enableBtn(btnSubmit);
                }
            },
            error: function (XmlHttpRequest, textStatus, errorThrown) {
                console.log(XmlHttpRequest);
                console.log(textStatus);
                console.log(errorThrown);
            },
            complete: function () {
                //enableBtn(btnSubmit);
            }
        });
    }
});

