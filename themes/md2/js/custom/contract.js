$(function () {

    var domForm = $("#doctor-form"), // form - html dom object.
            btnSubmit = $("#btnSubmit"),
            showTerms = $("#showTerms"),
            hideTerms = $(".hideTerms"),
            returnUrl = domForm.attr("data-url-return");

    //input改变时验证此input，防止修改之后错误提示依旧存在
    $("input").change(function () {
        var inputId = $(this).attr("id");
        validator.element("#" + inputId);
    });
    //点击提交显示协议
    showTerms.click(function () {
        var boolean = validator.form();
        if (boolean) {
            $("#terms").show();
        }
    });
    $("#termslink").click(function () {
        $("#termsShow").show();
    });
    //隐藏协议
    hideTerms.click(function () {
        $("#terms").hide();
        $("#termsShow").hide();
    });
    //提交按钮点击事件
    btnSubmit.click(function () {
        $("#terms").hide();
        ajaxSubmitForm();
    });
    //申请成为签约专家表单验证板块
    var validator = domForm.validate({
        //focusInvalid: true,
        rules: {
            'DoctorContractForm[preferred_patient]': {
                required: true,
                maxlength: 1000
            },
            'DoctorContractForm[terms]': {
                required: true,
                min: 1,
                max: 1
            }
        },
        messages: {
            'DoctorContractForm[preferred_patient]': {
                required: "请填写希望收到的病人/病历",
                maxlength: "请将字数控制在1000以内"
            },
            'DoctorContractForm[terms]': {
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
        },
        submitHandler: function () {
        }
    });
    function ajaxSubmitForm() {
        //form插件的异步无刷新提交
        disabledBtn(btnSubmit);
        requestUrl = domForm.attr('action');
        var formdata = domForm.serializeArray();
        domForm.ajaxSubmit({
            type: 'post',
            url: requestUrl,
            data: formdata,
            success: function (data) {
                //success.
                if (data.status == 'ok') {
                    J.popup({
                        html: '<div><div class="popup-title">提示</div><div class="popup-content"><h4>提交成功！</h4><div class="mt20"><a data-target="link" href="'+returnUrl+'" class="btn btn-yes btn-block">返回个人中心</a></div></div></div>',
                        pos: 'center'
                    });
                } else {
                    domForm.find("div.error").remove();
                    for (error in data.errors) {
                        errerMsg = data.errors[error];
                        inputKey = '#DoctorContractForm_' + error;
                        $(inputKey).focus();
                        $(inputKey).parent().after("<div class='error'>" + errerMsg + "</div> ");
                    }
                    //error.
                    enableBtn(btnSubmit);
                }
            },
            error: function (XmlHttpRequest, textStatus, errorThrown) {
                //enableBtn(btnSubmit);
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

