$(function () {

    var domForm = $("#patient-form"), // form - html dom object.
            btnSubmit = $("#btnSubmit"),
            type = domForm.attr('data-type'),
            returnUrl = domForm.attr("data-url-return");
    // 手机号码验证
    $.validator.addMethod("isMobile", function (value, element) {
        var length = value.length;
        var mobile = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;
        return this.optional(element) || (mobile.test(value));
    }, "请填写正确的电话号码");

    btnSubmit.click(function () {
        var bool = validator_patient.form();
        if (bool) {
            formAjaxSubmit();
        }
    });
    //医生认证表单验证板块
    var validator_patient = domForm.validate({
        //focusInvalid: true,
        rules: {
            'patient[name]': {
                required: true,
                maxlength: 45
            },
            'patient[mobile]': {
                required: true,
                isMobile: true
            },
            'patient[gender]': {
                required: true
            },
            'patient[birth_year]': {
                required: true
            },
            'patient[birth_month]': {
                required: true
            },
            'patient[state_id]': {
                required: true
            },
            'patient[city_id]': {
                required: true
            },
            'patient[disease_name]': {
                required: true,
                maxlength: 50
            },
            'patient[disease_detail]': {
                required: true,
                maxlength: 1000
            }
        },
        messages: {
            'patient[name]': {
                required: "请填写真实姓名",
                maxlength: "请将字数控制在45以内"
            },
            'patient[mobile]': {
                required: '请填写患者手机号码',
                isMobile: '请填写正确的手机号码'
            },
            'patient[gender]': {
                required: '请选择性别'
            },
            'patient[birth_year]': {
                required: '请选择出生年份'
            },
            'patient[birth_month]': {
                required: '请选择出生月份'
            },
            'patient[state_id]': {
                required: "请选择省份"
            },
            'patient[city_id]': {
                required: "请选择城市"
            },
            'patient[disease_name]': {
                required: "请输入疾病诊断",
                maxlength: "疾病诊断最长为50字"
            },
            'patient[disease_detail]': {
                required: "请输入病史描述",
                maxlength: "病史描述最长为1000字"
            }
        },
//        errorContainer: "div.error",
//        errorLabelContainer: $("#DoctorForm-form div .error"),
//        wrapper: "div",
        errorElement: "div",
        errorPlacement: function (error, element) {                             //错误信息位置设置方法  
            error.appendTo(element.parent());                        //这里的element是录入数据的对象  
        }
    });
    function formAjaxSubmit() {
        //form插件的异步无刷新提交
        disabledBtn(btnSubmit);
        requestUrl = domForm.attr('data-url-action');
        var formdata = domForm.serialize();
        $.ajax({
            type: 'post',
            url: requestUrl,
            data: formdata,
            success: function (data) {
                //success.
                if (data.status == 'ok') {
                    returnUrl += '/addBackBtn/1?id=' + data.patient.id + '&returnUrl=' + $returnUrl;
                    if (type == 'update') {
                        J.showToast('修改成功', '', '1000');
                    }else{
                        J.showToast('创建成功', '', '1000');
                    }
                    setTimeout(function () {
                        location.href = returnUrl;
                    }, 1000);
                } else {
                    domForm.find("div.error").remove();
                    for (error in data.errors) {
                        errerMsg = data.errors[error];
                        inputKey = '#patient_' + error;
                        $(inputKey).focus();
                        $(inputKey).parent().after("<div class='error'>" + errerMsg + "</div> ");
                    }
                    enableBtn(btnSubmit);
                    //error.
                }
            },
            error: function (XmlHttpRequest, textStatus, errorThrown) {
                if (type == 'update') {
                    J.showToast('网络异常，修改失败', '', '2000');
                }
                //enableBtn(btnSubmit);
                console.log(XmlHttpRequest);
                console.log(textStatus);
                console.log(errorThrown);
            },
            complete: function () {
                enableBtn(btnSubmit);
            }
        });
    }
});

