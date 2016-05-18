$(function () {
    var domForm = $("#booking-form"), // form - html dom object.
            btnSubmit = $("#btnSubmit"),
            returnUrl = domForm.attr("data-url-return");
    //input改变时验证此input，防止修改之后错误提示依旧存在
    $("input").change(function () {
        var inputId = $(this).attr("id");
        validator.element("#" + inputId);
    });
    //日期验证
    $.validator.addMethod("dataBeforeToday", function (value, element) {
        var today = new Date();
        var dateval = new Date(value);
        return this.optional(element) || (dateval > today);
    }, "日期必须大于今天");
    $.validator.addMethod("startdataBeforeEnddate", function (value, element) {
        var startdate = new Date($("#booking_date_start").val());
        var enddate = new Date(value);
        var dates = Math.abs((startdate - enddate)) / (1000 * 60 * 60 * 24);
        return this.optional(element) || (enddate > startdate);
    }, "最迟时间必须大于最早时间");
    btnSubmit.click(function () {
        $('.noTravelType').remove();
        var travelType = $('input[name="booking[travel_type]"]').attr('value');
        //console.log(travelType);
        if (travelType == '') {
            $('#travel_type').after('<div class="noTravelType">请选择就诊意向</div>');
        }
        var bool = validator.form();
        if (bool) {
            if ($('input[name="booking[expected_doctor]"]').val() != '' || $('input[name="booking[expected_hospital]"]').val() != '' || $('input[name="booking[expected_dept]"]').val() != '') {
                if (!($('input[name="booking[expected_doctor]"]').val() != '' && $('input[name="booking[expected_hospital]"]').val() != '' && $('input[name="booking[expected_dept]"]').val() != '')) {
                    $('#expectedError.error').remove();
                    $('#expectedInfo').after('<div id="expectedError" class="error">请补全信息</div> ');
                    return;
                }
            }
            formAjaxSubmit();
        }
    });
    //医生认证表单验证板块
    var validator = domForm.validate({
        //focusInvalid: true,
        rules: {
            'booking[travel_type]': {
                required: true,
            },
            'booking[detail]': {
                required: true,
                minlength: 1,
                maxlength: 1000
            }
        },
        messages: {
            'booking[travel_type]': {
                required: '请选择就诊方式',
            },
            'booking[detail]': {
                required: '如无任何需求，请填写‘无’',
                minlength: '如无任何需求，请填写‘无’',
                maxlength: '请将字数控制在1000以内'
            }
        },
//        errorContainer: "div.error",
//        errorLabelContainer: $("#DoctorForm-form div .error"),
//        wrapper: "div",
        errorElement: "div",
        errorPlacement: function (error, element) {
            //element.parents("li").find("div.error").remove();
            error.appendTo(element.parent()); //这里的element是录入数据的对象  
        }
    });
    function formAjaxSubmit() {
        //form插件的异步无刷新提交
        disabledBtn(btnSubmit);
        var formdata = domForm.serializeArray();
        var dataArray = structure_formdata('booking', formdata);
        var encryptContext = do_encrypt(dataArray, pubkey);
        var param = {param: encryptContext};
        requestUrl = domForm.attr('action');
        $.ajax({
            type: 'post',
            url: requestUrl,
            data: param,
            success: function (data) {
                //success.
                if (data.status == 'ok') {
                    if ($realName == 0) {
                        J.customConfirm('就诊信息提交成功',
                                '<div class="mt10 mb10">请您填写个人信息并通过实名认证，以便进行后续操作。</div>',
                                '<a data="cancel" class="w50">暂不操作</a>',
                                '<a data="ok" class="color-green w50">填写信息</a>',
                                function () {
                                    location.href = $urlRealName;
                                },
                                function () {
                                    returnUrl += '?bookingid=' + data.booking.id + '&status=1&addBackBtn=1';
                                    window.location.href = returnUrl;
                                });
                    } else if ($userDoctorCerts == 0) {
                        J.hideMask();
                        J.customConfirm('就诊信息提交成功',
                                '<div class="mt10 mb10">请您上传证件，以便进行后续操作。</div>',
                                '<a data="cancel" class="w50">暂不操作</a>',
                                '<a data="ok" class="color-green w50">上传证件</a>',
                                function () {
                                    location.href = $userDoctorUploadCert;
                                },
                                function () {
                                    returnUrl += '?bookingid=' + data.booking.id + '&status=1&addBackBtn=1';
                                    window.location.href = returnUrl;
                                });
                    } else {
                        returnUrl += '?bookingid=' + data.booking.id + '&status=1&addBackBtn=1';
                        window.location.href = returnUrl;
                    }
                } else {
                    domForm.find("div.error").remove();
                    for (error in data.errors) {
                        errerMsg = data.errors[error];
                        inputKey = '#booking_' + error;
                        $(inputKey).focus();
                        $(inputKey).parent().after("<div class='error'>" + errerMsg + "</div> ");
                    }
                    //error.
                    enableBtn(btnSubmit);
                    J.showToast('网络异常，请稍后预约', '', '2000');
                }
            },
            error: function (XmlHttpRequest, textStatus, errorThrown) {
                J.showToast('网络异常，请稍后预约', '', '2000');
                enableBtn(btnSubmit);
                console.log(XmlHttpRequest);
                console.log(textStatus);
                console.log(errorThrown);
            },
            complete: function () {
                //enableBtn(btnSubmit);
                //btnSubmit.show();
            }
        });
    }
});

