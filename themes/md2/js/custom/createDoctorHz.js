$(function () {
    var domForm = $("#docHz-form"), // form - html dom object.
            btnSubmit = $("#btnSubmit"),
            actionUrl = domForm.attr('action'),
            returnUrl = domForm.attr("data-url-return");
    // 手机号码验证
    $.validator.addMethod("feeValidator", function (value, element) {
        var fee_max = value;
        var fee_min = $('#DoctorHuizhenForm_fee_min').val();
        return this.optional(element) || (fee_max - fee_min >= 0);
    }, "最高额度需大于最低额度");
    //input改变时验证此input，防止修改之后错误提示依旧存在
    $("input").change(function () {
        var inputId = $(this).attr("id");
        validator.element("#" + inputId);
    });
    //外出会诊要求手术台数
    $(".checkNumber").tap(function (e) {
        e.preventDefault();
        $("#otherSurgery").html("<input type='radio' name='DoctorHuizhenForm[min_no_surgery]' id='surgery4d' class='surgery' checked='checked' value=''/>");
        var innerHtml = "<div class='col-1 checkSurgery p11 selectSurgery1'>" +
                "<input type='radio' name='DoctorHuizhenForm[min_no_surgery]' id='surgery1d' class='surgery' value='1'/>" +
                "<label for='surgery1d' class='ui-btn ui-corner-all'> 1台</label>" +
                "</div>" +
                "<div class='col-1 checkSurgery p11 selectSurgery2'>" +
                "<input type='radio' name='DoctorHuizhenForm[min_no_surgery]' id='surgery2d' class='surgery' value='2'/>" +
                "<label for='surgery2d' class='ui-btn ui-corner-all'> 2台</label>" +
                "</div>" +
                "<div class='col-1 checkSurgery p11 selectSurgery3'>" +
                "<input type='radio' name='DoctorHuizhenForm[min_no_surgery]' id='surgery3d' class='surgery' value='3'/>" +
                "<label for='surgery3d' class='ui-btn ui-corner-all'> 3台</label>" +
                "</div>";
        $(".numberSurgery").html(innerHtml);
        initJs();
        $(".checkNumber").removeAttr("readonly");
    });
    initJs();
    //重绘问题4
    $(".checkDay").tap(function (e) {
        e.preventDefault();
        var isCheck = $(this).find("input[name='DoctorHuizhenForm[week_days]']").attr('checked');
        if (isCheck == "checked") {
            var value = $(this).find("input[name='DoctorHuizhenForm[week_days]']").val();
            emptyDaySelect(value);
        }
    });
    function emptyDaySelect(value) {
        if (value == '1') {
            $('.select-1').html('<input name="DoctorHuizhenForm[week_days]" id="week_days1" value="1" type="checkbox"><label for="week_days1" class="ui-btn ui-corner-all"> 周一</label>');
        }
        if (value == '2') {
            $('.select-2').html('<input name="DoctorHuizhenForm[week_days]" id="week_days2" value="2" type="checkbox"><label for="week_days2" class="ui-btn ui-corner-all"> 周二</label>');
        }
        if (value == '3') {
            $('.select-3').html('<input name="DoctorHuizhenForm[week_days]" id="week_days3" value="3" type="checkbox"><label for="week_days3" class="ui-btn ui-corner-all"> 周三</label>');
        }
        if (value == '4') {
            $('.select-4').html('<input name="DoctorHuizhenForm[week_days]" id="week_days4" value="4" type="checkbox"><label for="week_days4" class="ui-btn ui-corner-all"> 周四</label>');
        }
        if (value == 5) {
            $('.select-5').html('<input name="DoctorHuizhenForm[week_days]" id="week_days5" value="5" type="checkbox"><label for="week_days5" class="ui-btn ui-corner-all"> 周五</label>');
        }
        if (value == '6') {
            $('.select-6').html('<input name="DoctorHuizhenForm[week_days]" id="week_days6" value="6" type="checkbox"><label for="week_days6" class="ui-btn ui-corner-all"> 周六</label>');
        }
        if (value == '7') {
            $('.select-7').html('<input name="DoctorHuizhenForm[week_days]" id="week_days7" value="7" type="checkbox"><label for="week_days7" class="ui-btn ui-corner-all"> 周日</label>');
        }
    }

//时间成本控制要求

    $(".checkDuration").tap(function (e) {
        var checkDuration = $(this).find("input[name='DoctorHuizhenForm[travel_duration]']").val();
        if (checkDuration == "train3h") {
            $('.train5hSelect').html("<input type='checkbox' name='DoctorHuizhenForm[travel_duration]' id='train5h' value='train5h' /><label for='train5h' class='ui-btn ui-corner-all'> 高铁5小时内</label>");
            $('.noneSelect').html("<input type='checkbox' name='DoctorHuizhenForm[travel_duration]' id='none' value='none'/><label for='none' class='ui-btn ui-corner-all'> 无</label>");
        }
        if (checkDuration == "plane2h") {
            $('.plane3hSelect').html("<input type='checkbox' name='DoctorHuizhenForm[travel_duration]' id='plane3h' value='plane3h'/><label for='plane3h' class='ui-btn ui-corner-all'> 飞机3小时内</label>");
            $('.noneSelect').html("<input type='checkbox' name='DoctorHuizhenForm[travel_duration]' id='none' value='none'/><label for='none' class='ui-btn ui-corner-all'> 无</label>");
        }
        if (checkDuration == "train5h") {
            $('.train3hSelect').html("<input type='checkbox' name='DoctorHuizhenForm[travel_duration]' id='train3h' value='train3h'/><label for='train3h' class='ui-btn ui-corner-all'> 高铁3小时内</label>");
            $('.noneSelect').html("<input type='checkbox' name='DoctorHuizhenForm[travel_duration]' id='none' value='none'/><label for='none' class='ui-btn ui-corner-all'> 无</label>");
        }
        if (checkDuration == "plane3h") {
            $('.plane2hSelect').html("<input type='checkbox' name='DoctorHuizhenForm[travel_duration]' id='plane2h' value='plane2h'/><label for='plane2h' class='ui-btn ui-corner-all'> 飞机2小时内</label>");
            $('.noneSelect').html("<input type='checkbox' name='DoctorHuizhenForm[travel_duration]' id='none' value='none'/><label for='none' class='ui-btn ui-corner-all'> 无</label>");
        }
        if (checkDuration == "none") {
            $('.train3hSelect').html("<input type='checkbox' name='DoctorHuizhenForm[travel_duration]' id='train3h' value='train3h'/><label for='train3h' class='ui-btn ui-corner-all'> 高铁3小时内</label>");
            $('.plane2hSelect').html("<input type='checkbox' name='DoctorHuizhenForm[travel_duration]' id='plane2h' value='plane2h'/><label for='plane2h' class='ui-btn ui-corner-all'> 飞机2小时内</label>");
            $('.train5hSelect').html("<input type='checkbox' name='DoctorHuizhenForm[travel_duration]' id='train5h' value='train5h'/><label for='train5h' class='ui-btn ui-corner-all'> 高铁5小时内</label>");
            $('.plane3hSelect').html("<input type='checkbox' name='DoctorHuizhenForm[travel_duration]' id='plane3h' value='plane3h'/><label for='plane3h' class='ui-btn ui-corner-all'> 飞机3小时内</label>");
        }
    });
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
            'DoctorHuizhenForm[min_no_surgery]': {
                required: true
            },
            'DoctorHuizhenForm[travel_duration]': {
                required: true
            },
            'DoctorHuizhenForm[fee_min]': {
                required: true,
                number: true,
                min: 0
            },
            'DoctorHuizhenForm[fee_max]': {
                required: true,
                number: true,
                min: 0,
                feeValidator: true
            },
            'DoctorHuizhenForm[week_days]': {
                required: true
            },
            'DoctorHuizhenForm[patients_prefer]': {
                required: true
            },
            'DoctorHuizhenForm[freq_destination]': {
                required: true
            },
            'DoctorHuizhenForm[destination_req]': {
                required: true
            }
        },
        messages: {
            'DoctorHuizhenForm[min_no_surgery]': {
                required: '请选择台数'
            },
            'DoctorHuizhenForm[travel_duration]': {
                required: '请选择对时间成本的要求'
            },
            'DoctorHuizhenForm[fee_min]': {
                required: '请填写最低额度',
                number: '请输入合法的数字',
                min: '最低额度不能小于0'
            },
            'DoctorHuizhenForm[fee_max]': {
                required: '请填写最高额度',
                number: '请输入合法的数字',
                min: '最高额度不能小于0',
                feeValidator: '最高额度需大于最低额度'
            },
            'DoctorHuizhenForm[week_days]': {
                required: '请选择哪几天比较方便会诊'
            },
            'DoctorHuizhenForm[patients_prefer]': {
                required: '请填写您更愿意会诊什么样的病人'
            },
            'DoctorHuizhenForm[freq_destination]': {
                required: '请填写您常去哪些地区或医院'
            },
            'DoctorHuizhenForm[destination_req]': {
                required: '请填写您对手术地点/条件有什么要求'
            }
        },
//        errorContainer: "div.error",
//        errorLabelContainer: $("#DoctorForm-form div .error"),
//        wrapper: "div",
        errorElement: "div",
        errorPlacement: function (error, element) {                             //错误信息位置设置方法  
            error.appendTo(element.parents('li')); //这里的element是录入数据的对象  
        },
        submitHandler: function () {
        }
    });
    function ajaxSubmitForm() {
        disabledBtn($("#btnSubmit"));
        var domForm = $("#docHz-form");
        var formData = toFormData(domForm);
        var encryptContext = do_encrypt(formData, pubkey);
        var param = {param: encryptContext};
        var min_no_surgery = checkSurgery();
        if ((isNaN(min_no_surgery)) || (min_no_surgery < 1)) {
            $('.surgeryNum').after('<div id="surgery-error" class="error">请输入正确台数</div>');
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
                enableBtn($("#btnSubmit"));
            }
        });
    }
    function toFormData(domForm) {
        var weeks = '';
        var travel_duration = '';
        var min_no_surgery = '';
        $("input[name='DoctorHuizhenForm[week_days]']").each(function () {
            if ($(this).attr('checked')) {
                weeks += $(this).val() + ',';
            }
        });
        $("input[name='DoctorHuizhenForm[travel_duration]']").each(function () {
            if ($(this).attr('checked')) {
                travel_duration += $(this).val() + ',';
            }
        });
        $("input[name='DoctorHuizhenForm[min_no_surgery]']").each(function () {
            if ($(this).attr('checked')) {
                min_no_surgery = $(this).val();
            }
        });
        if (($(".checkNumber").val() != null) && ($(".checkNumber").val() != '')) {
            min_no_surgery = $(".checkNumber").val();
        }
        weeks = weeks.substring(0, weeks.length - 1);
        travel_duration = travel_duration.substring(0, travel_duration.length - 1);
        var id = $("#DoctorHuizhenForm_id").val();
        var is_join = $("#DoctorHuizhenForm_is_join").val();
        var fee_min = $("#DoctorHuizhenForm_fee_min").val();
        var fee_max = $("#DoctorHuizhenForm_fee_max").val();
        var patients_prefer = $("#DoctorHuizhenForm_patients_prefer").val();
        var freq_destination = $("#DoctorHuizhenForm_freq_destination").val();
        var destination_req = $("#DoctorHuizhenForm_destination_req").val();
        var formData = '{"DoctorHuizhenForm":{"is_join":"' + encodeURIComponent(is_join) +
                '","fee_min":"' + encodeURIComponent(fee_min) +
                '","fee_max":"' + encodeURIComponent(fee_max) +
                '","week_days":"' + encodeURIComponent(weeks) +
                '","patients_prefer":"' + encodeURIComponent(patients_prefer) +
                '","freq_destination":"' + encodeURIComponent(freq_destination) +
                '","destination_req":"' + encodeURIComponent(destination_req) +
                '","travel_duration":"' + encodeURIComponent(travel_duration) +
                '","min_no_surgery":"' + encodeURIComponent(min_no_surgery) +
                '"}}';
        return formData;
    }
    function checkSurgery() {
        var min_no_surgery = '';
        $("input[name='DoctorHuizhenForm[min_no_surgery]']").each(function () {
            if ($(this).attr('checked')) {
                min_no_surgery = $(this).val();
            }
        });
        if (($(".checkNumber").val() != null) && ($(".checkNumber").val() != '')) {
            min_no_surgery = $(".checkNumber").val();
        }
        return min_no_surgery;
    }
    function checkSurerySelect() {
        var min_no_surgery = '';
        $("input[name='DoctorHuizhenForm[min_no_surgery]']").each(function () {
            if ($(this).attr('checked')) {
                min_no_surgery = $(this).attr("id");
            }
        });
        return min_no_surgery;
    }
    function initJs() {
        $(".checkSurgery").tap(function (e) {
            e.preventDefault();
            var id = $(this).find("input[name='DoctorHuizhenForm[min_no_surgery]']").attr('id');
            if (id != 'surgery4d') {
                $("#otherSurgery").html("<input type='radio' name='DoctorHuizhenForm[min_no_surgery]' id='surgery4d' class='surgery' value=''/>");
                emptySurerySelect(id);
                $(".checkNumber").val("");
                $(".checkNumber").attr("readonly", "true");
            }
        });
        $(".checkSurgery").tap(function (e) {
            e.preventDefault();
            $('#surgery-error').remove();
        });
        $(".checkNumber").on("change", function () {
            $('#surgery-error').remove();
        });
    }
//重绘除本身所有的单选
    function emptySurerySelect(id) {
        if (id == 'surgery1d') {
            $('.selectSurgery2').html("<input type='radio' name='DoctorHuizhenForm[min_no_surgery]' id='surgery2d' class='surgery' value='2'/><label for='surgery2d' class='ui-btn ui-corner-all checkSurgery'> 2台</label>");
            $('.selectSurgery3').html("<input type='radio' name='DoctorHuizhenForm[min_no_surgery]' id='surgery3d' class='surgery' value='3'/><label for='surgery3d' class='ui-btn ui-corner-all checkSurgery'> 3台</label>");
        } else if (id == 'surgery2d') {
            $('.selectSurgery1').html("<input type='radio' name='DoctorHuizhenForm[min_no_surgery]' id='surgery1d' class='surgery' value='1'/><label for='surgery1d' class='ui-btn ui-corner-all checkSurgery'> 1台</label>");
            $('.selectSurgery3').html("<input type='radio' name='DoctorHuizhenForm[min_no_surgery]' id='surgery3d' class='surgery' value='3'/><label for='surgery3d' class='ui-btn ui-corner-all checkSurgery'> 3台</label>");
        } else if (id == 'surgery3d') {
            $('.selectSurgery1').html("<input type='radio' name='DoctorHuizhenForm[min_no_surgery]' id='surgery1d' class='surgery' value='1'/><label for='surgery1d' class='ui-btn ui-corner-all checkSurgery'> 1台</label>");
            $('.selectSurgery2').html("<input type='radio' name='DoctorHuizhenForm[min_no_surgery]' id='surgery2d' class='surgery' value='2'/><label for='surgery2d' class='ui-btn ui-corner-all checkSurgery'> 2台</label>");
        }
    }
});

