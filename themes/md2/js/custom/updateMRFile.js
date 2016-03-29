$(function () {

    var domForm = $("#patient-form"), // form - html dom object.
            btnSubmit = $("#btnSubmit"),
            returnUrl = domForm.attr("data-url-return");
    // 手机号码验证
    jQuery.validator.addMethod("isMobile", function (value, element) {
        var length = value.length;
        var mobile = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;
        return this.optional(element) || (length == 11 && mobile.test(value));
    }, "请填写正确的手机号码");

    //医生认证表单验证板块
    var validator_docform = domForm.validate({
        //focusInvalid: true,
        rules: {
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
            if (error[0].id == 'patient_state_id-error' || error[0].id == 'patient_city_id-error') {
                error.appendTo(element.parent().parent().next());
            }
            if (error[0].id == 'patient[gender]-error') {
                //error.appendTo(element.parents(".ui-controlgroup-controls").next());
                error.appendTo(element.parents(".ui-field-contain"));
            } else {
                error.appendTo(element.parents(".ui-field-contain"));                        //这里的element是录入数据的对象  
            }
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
                        returnUrl += '/id/' + data.patient.id;
                        window.location.href = returnUrl;
                    } else {
                        //error.
                        enableBtn(btnSubmit);
                        console.log(data);
                    }
                },
                error: function (XmlHttpRequest, textStatus, errorThrown) {
                    enableBtn(btnSubmit);
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
});

