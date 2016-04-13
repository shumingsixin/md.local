$(function () {
    var domForm = $("#booking-form"), // form - html dom object.
            btnSubmit = $("#btnSubmit"),
            returnUrl = domForm.attr("data-url-return");

    btnSubmit.click(function () {
        $('.noTravelType').remove();
        var travelType = $('input[name="booking[travel_type]"]').attr('value');
        //console.log(travelType);
        if (travelType == '') {
            $('#travel_type').after('<div class="noTravelType">请选择就诊意向</div>');
            return;
        }
        var bool = validator.form();
        if (bool) {
            formAjaxSubmit();
        }
    });
    //医生认证表单验证板块
    var validator = domForm.validate({
        //focusInvalid: true,
        rules: {
            'booking[detail]': {
                required: true,
                minlength: 1,
                maxlength: 1000
            }
        },
        messages: {
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
        var formdata = domForm.serialize();
        requestUrl = domForm.attr('action');
        $.ajax({
            type: 'post',
            url: requestUrl,
            data: formdata,
            success: function (data) {
                //success.
                if (data.status == 'ok') {
                    returnUrl += '?refNo=' + data.salesOrderRefNo + "&bookingId=" + data.booking.id;
                    window.location.href = returnUrl;
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

