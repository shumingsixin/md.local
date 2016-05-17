$(function () {
    var domForm = $("#docZz-form"), // form - html dom object.
            btnSubmit = $("#btnSubmit"),
            actionUrl = domForm.attr('action'),
            returnUrl = domForm.attr("data-url-return");
    // 手机号码验证
    $.validator.addMethod("feeValidator", function (value, element) {
        var fee_max = value;
        var fee_min = $('#DoctorZhuanzhenForm_fee_min').val();
        return this.optional(element) || (fee_max >= fee_min);
    }, "最高额度需大于最低额度");

    //input改变时验证此input，防止修改之后错误提示依旧存在
    $("input").change(function () {
        var inputId = $(this).attr("id");
        validator.element("#" + inputId);
    });

    $(".checkNumber").tap(function (e) {
        e.preventDefault();
        $("#otherFee").html("<input type='radio' name='DoctorZhuanzhenForm[fee]' id='fee4' checked='checked' value=''/>");
        var innerHtml = "<div class='col-1 checkFee p11 selectFee0'>" +
                "<input type='radio' name='DoctorZhuanzhenForm[fee]' id='fee0' value='0'/>" +
                "<label for='fee0' class='ui-btn ui-corner-all'> 不需要</label>" +
                "</div>" +
                "<div class='col-1 checkFee p11 selectFee500'>" +
                "<input type='radio' name='DoctorZhuanzhenForm[fee]' id='fee500' value='500'/>" +
                "<label for='fee500' class='ui-btn ui-corner-all'> 500元</label>" +
                "</div>" +
                "<div class='col-1 checkFee p11 selectFee1000'>" +
                "<input type='radio' name='DoctorZhuanzhenForm[fee]' id='fee1000' value='1000'/>" +
                "<label for='fee1000' class='ui-btn ui-corner-all'> 1000元</label>" +
                "</div>";
        $(".numberFee").html(innerHtml);
        initJs();
        $(".checkNumber").removeAttr("readonly");
    });

    initJs();

    //重绘单选(多久能够安排床位)
    $(".checkPrepDay").tap(function (e) {
        e.preventDefault();
        var id = $(this).find("input[name='DoctorZhuanzhenForm[prep_days]']").val();
        emptyPrepDaySelect(id);
    });

    function emptyPrepDaySelect(id) {
        if (id == '3d') {
            $('.select-1w').html("<input type='radio' name='DoctorZhuanzhenForm[prep_days]' id='1w' value='1w'/><label for='1w' class='ui-btn ui-corner-all checkPrepDay'> 一周内</label>");
            $('.select-2w').html("<input type='radio' name='DoctorZhuanzhenForm[prep_days]' id='2w' value='2w'/><label for='2w' class='ui-btn ui-corner-all checkPrepDay'> 两周内</label>");
            $('.select-3w').html("<input type='radio' name='DoctorZhuanzhenForm[prep_days]' id='3w' value='3w'/><label for='3w' class='ui-btn ui-corner-all checkPrepDay'> 三周内</label>");
        } else if (id == '1w') {
            $('.select-3d').html("<input type='radio' name='DoctorZhuanzhenForm[prep_days]' id='3d' value='3d'/><label for='3d' class='ui-btn ui-corner-all checkPrepDay'> 三天内</label>");
            $('.select-2w').html("<input type='radio' name='DoctorZhuanzhenForm[prep_days]' id='2w' value='2w'/><label for='2w' class='ui-btn ui-corner-all checkPrepDay'> 两周内</label>");
            $('.select-3w').html("<input type='radio' name='DoctorZhuanzhenForm[prep_days]' id='3w' value='3w'/><label for='3w' class='ui-btn ui-corner-all checkPrepDay'> 三周内</label>");
        } else if (id == '2w') {
            $('.select-3d').html("<input type='radio' name='DoctorZhuanzhenForm[prep_days]' id='3d' value='3d'/><label for='3d' class='ui-btn ui-corner-all checkPrepDay'> 三天内</label>");
            $('.select-1w').html("<input type='radio' name='DoctorZhuanzhenForm[prep_days]' id='1w' value='1w'/><label for='1w' class='ui-btn ui-corner-all checkPrepDay'> 一周内</label>");
            $('.select-3w').html("<input type='radio' name='DoctorZhuanzhenForm[prep_days]' id='3w' value='3w'/><label for='3w' class='ui-btn ui-corner-all checkPrepDay'> 三周内</label>");
        } else if (id == '3w') {
            $('.select-3d').html("<input type='radio' name='DoctorZhuanzhenForm[prep_days]' id='3d' value='3d'/><label for='3d' class='ui-btn ui-corner-all checkPrepDay'> 三天内</label>");
            $('.select-1w').html("<input type='radio' name='DoctorZhuanzhenForm[prep_days]' id='1w' value='1w'/><label for='1w' class='ui-btn ui-corner-all checkPrepDay'> 一周内</label>");
            $('.select-2w').html("<input type='radio' name='DoctorZhuanzhenForm[prep_days]' id='2w' value='2w'/><label for='2w' class='ui-btn ui-corner-all checkPrepDay'> 两周内</label>");
        }
    }

    //提交按钮点击事件
    btnSubmit.click(function (e) {
        e.preventDefault();
        if (validator.form()) {
            ajaxSubmitForm();
        }
    });
    //申请成为签约专家表单验证板块
    var validator = domForm.validate({
        //focusInvalid: true,
        rules: {
            'DoctorZhuanzhenForm[fee]': {
                required: true
            },
            'DoctorZhuanzhenForm[preferred_patient]': {
                required: true
            },
            'DoctorZhuanzhenForm[prep_days]': {
                required: true
            }
        },
        messages: {
            'DoctorZhuanzhenForm[fee]': {
                required: '请选择转诊费'
            },
            'DoctorZhuanzhenForm[preferred_patient]': {
                required: '请填写对转诊病例的要求'
            },
            'DoctorZhuanzhenForm[prep_days]': {
                required: '请填写您最快多久能安排手术'
            }
        },
//        errorContainer: "div.error",
//        errorLabelContainer: $("#DoctorForm-form div .error"),
//        wrapper: "div",
        errorElement: "div",
        errorPlacement: function (error, element) {                             //错误信息位置设置方法  
            error.appendTo(element.parents('li'));                        //这里的element是录入数据的对象  
        },
        submitHandler: function () {
        }
    });
    function ajaxSubmitForm() {
        var domForm = $("#docHz-form");
        var formData = toFormData(domForm);
        var encryptContext = do_encrypt(formData);
        var param = {param: encryptContext};
        var fee = checkFee();
        if ((fee == "") || (isNaN(fee)) || (fee < 0)) {
            $('.feeNum').after('<div id="fee-error" class="error">请输入金额</div>');
            J.closePopup();
            J.hideMask();
            btnSubmit.removeAttr("disabled");
            return;
        }
        $.ajax({
            type: 'post',
            url: actionUrl,
            data: param,
            dataType: "json",
            'success': function (data) {
                if (data.status) {
                    location.href = returnUrl;
                }
            },
            'error': function (data) {
                console.log(data);
            },
            'complete': function () {
            }
        });
    }
    function toFormData(domForm) {
        var preferred_patient = '';
        var fee = '';
        var prep_days = '';
        preferred_patient = $("textarea[name='DoctorZhuanzhenForm[preferred_patient]']").val();
        $("input[name='DoctorZhuanzhenForm[fee]']").each(function () {
            if ($(this).attr('checked')) {
                fee = $(this).val();
            }
        });
        $("input[name='DoctorZhuanzhenForm[prep_days]']").each(function () {
            if ($(this).attr('checked')) {
                prep_days = $(this).val();
            }
        });
        if (($(".checkNumber").val() != null) && ($(".checkNumber").val() != '')) {
            fee = $(".checkNumber").val();
        }
        var id = $("#DoctorZhuanzhenForm_id").val();
        var is_join = $("#DoctorZhuanzhenForm_is_join").val();
        var formData = '{"DoctorZhuanzhenForm":{"is_join":"' + encodeURIComponent(is_join) +
                '","preferred_patient":"' + encodeURIComponent(preferred_patient) +
                '","fee":"' + encodeURIComponent(fee) +
                '","prep_days":"' + encodeURIComponent(prep_days) +
                '"}}';
        return formData;
    }
    function checkFee() {
        var fee = '';
        $("input[name='DoctorZhuanzhenForm[fee]']").each(function () {
            if ($(this).attr('checked')) {
                fee = $(this).val();
            }
        });
        if (($(".checkNumber").val() != null) && ($(".checkNumber").val() != '')) {
            fee = $(".checkNumber").val();
        }
        return fee;
    }
    function checkFeeSelect() {
        var fee = '';
        $("input[name='DoctorZhuanzhenForm[fee]']").each(function () {
            if ($(this).attr('checked')) {
                fee = $(this).attr("id");
            }
        });
        return fee;
    }
    function initJs() {
        $(".checkFee").tap(function (e) {
            e.preventDefault();
            var id = $(this).find("input[name='DoctorZhuanzhenForm[fee]']").attr('id');
            if (id != "fee4") {
                $("#otherFee").html("<input type='radio' name='DoctorZhuanzhenForm[fee]' id='fee4' value=''/>");
                emptyFeeSelect(id);
                $(".checkNumber").val("");
                $(".checkNumber").attr("readonly", "true");
            }
        });
        $(".checkFee").tap(function (e) {
            e.preventDefault();
            $('#fee-error').remove();
        });
        $(".checkNumber").on("change", function () {
            $('#fee-error').remove();
        });
    }
    //重绘除本身所有的单选(转诊费)
    function emptyFeeSelect(id) {
        if (id == 'fee0') {
            $('.selectFee500').html("<input type='radio' name='DoctorZhuanzhenForm[fee]' id='fee500' value='500'/><label for='fee500' class='ui-btn ui-corner-all'> 500元</label>");
            $('.selectFee1000').html("<input type='radio' name='DoctorZhuanzhenForm[fee]' id='fee1000' value='1000'/><label for='fee1000' class='ui-btn ui-corner-all'> 1000元</label>");
        } else if (id == 'fee500') {
            $('.selectFee0').html("<input type='radio' name='DoctorZhuanzhenForm[fee]' id='fee0' value='0'/><label for='fee0' class='ui-btn ui-corner-all'> 不需要</label>");
            $('.selectFee1000').html("<input type='radio' name='DoctorZhuanzhenForm[fee]' id='fee1000' value='1000'/><label for='fee1000' class='ui-btn ui-corner-all'> 1000元</label>");
        } else if (id == 'fee1000') {
            $('.selectFee0').html("<input type='radio' name='DoctorZhuanzhenForm[fee]' id='fee0' value='0'/><label for='fee0' class='ui-btn ui-corner-all'> 不需要</label>");
            $('.selectFee500').html("<input type='radio' name='DoctorZhuanzhenForm[fee]' id='fee500' value='500'/><label for='fee500' class='ui-btn ui-corner-all'> 500元</label>");
        }
    }
});

