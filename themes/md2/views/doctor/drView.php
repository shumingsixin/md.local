<?php
/*
 * $model UserDoctorMobileLoginForm.
 */
$this->setPageID('pUserDrView');
$this->setPageTitle('专家签约');
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$urlCreateDoctorHz = $this->createUrl("doctor/createDoctorHz", array('addBackBtn' => 1));
$urlCreateDoctorZz = $this->createUrl("doctor/createDoctorZz", array('addBackBtn' => 1));
$urlAjaxViewDoctorHz = $this->createUrl("doctor/ajaxViewDoctorHz");
$urlAjaxViewDoctorZz = $this->createUrl("doctor/ajaxViewDoctorZz");
$urlDoctorHzSubmit = $this->createUrl('doctor/ajaxDoctorHz');
$urlDoctorZzSubmit = $this->createUrl('doctor/ajaxDoctorZz');
$urlDoctorView = $this->createUrl('doctor/view');
?>
<div id="section_container" <?php echo $this->createPageAttributes(); ?>>
    <section id="createPatinal_section" class="active" data-init="true">
        <article id="sign" class="active" data-scroll="true">
            <div class="color-black6">
                <div class="grid mt15">
                    <div class="col-1 grid b-gray-r1">
                        <div class="col-1"></div>
                        <div class="col-0 w50">
                            <a href="<?php echo $urlCreateDoctorHz; ?>" data-target="link">
                                <img src="<?php echo $urlResImage; ?>/huizhen.png">
                            </a>
                        </div>
                        <div class="col-1"></div>
                    </div>
                    <div class="col-1 grid">
                        <div class="col-1"></div>
                        <div class="col-0 w50">
                            <a href="<?php echo $urlCreateDoctorZz; ?>" data-target="link">
                                <img src="<?php echo $urlResImage; ?>/zhuanzhen.png">
                            </a>
                        </div>
                        <div class="col-1"></div>
                    </div>
                </div>
                <div class="grid font-s18">
                    <div class="col-0 w50 grid pt5 b-gray-r1">
                        <div class="col-1"></div>
                        <div class="col-0 mt11 line-h1e">
                            去外地会诊
                        </div>
                        <div class="col-1"></div>
                    </div>
                    <div class="col-0 w50 grid pt5">
                        <div class="col-1"></div>
                        <div class="col-0 mt11 line-h1e">
                            接受病人转诊
                        </div>
                        <div class="col-1"></div>
                    </div>
                </div>
                <div class="mt10 ml15 mr15" style="border-bottom:1px solid #dddddd;"></div>
                <div class="ml30 mr30 mt15 font-s16 huizhenInfo">

                </div>
                <div class="ml30 mr30 mt12 mb10 font-s16 zhuanzhenInfo">

                </div>
            </div>
        </article>
    </section>
</div>  
<script>
    $(document).ready(function () {
        ajaxViewDoctorHz();
        ajaxViewDoctorZz();
        $(".huizhen").tap(function () {
            J.customConfirm('',
                    '<div class="mt10 mb10">确认暂不参与外地会诊吗?</div>',
                    '<a id="closeLogout" class="w50">取消</a>',
                    '<a data="ok" class="color-green w50">暂不参与</a>',
                    function () {
                        ajaxRemoveDoctorHz();
                    },
                    function () {
                    });
            $('#closeLogout').click(function () {
                J.closePopup();
            });
        });
        $(".zhuanzhen").tap(function () {
            J.customConfirm('',
                    '<div class="mt10 mb10">确认暂不参与病人转诊吗?</div>',
                    '<a id="closeLogout" class="w50">取消</a>',
                    '<a data="ok" class="color-green w50">暂不参与</a>',
                    function () {
                        ajaxRemoveDoctorZz();
                    },
                    function () {
                    });
            $('#closeLogout').click(function () {
                J.closePopup();
            });
        });
    });
    //加载会诊信息
    function ajaxViewDoctorHz() {
        $.ajax({
            url: '<?php echo $urlAjaxViewDoctorHz; ?>',
            async: false,
            success: function (data) {
                //构造json
                var structureData = structure_data(data);
                //解密
                var returnData = do_decrypt(structureData);
                //解析数据
                returnData = analysis_data(returnData);
                if (returnData.results.userDoctorHz != null) {
                    setDoctorHzInfo(returnData.results.userDoctorHz);
                }
            }
        });
    }
    //加载转诊信息
    function ajaxViewDoctorZz() {
        $.ajax({
            url: '<?php echo $urlAjaxViewDoctorZz; ?>',
            async: false,
            success: function (data) {
                //构造json
                var structureData = structure_data(data);
                //解密
                var returnData = do_decrypt(structureData);
                //解析数据
                returnData = analysis_data(returnData);
                if (returnData.results.userDoctorZz != null) {
                    setDoctorZzInfo(returnData.results.userDoctorZz);
                }
            }
        });
    }
    //设置会诊html
    function setDoctorHzInfo(userDoctorHz) {
        if (userDoctorHz && userDoctorHz.is_join != 0) {
            var infoHtml = '<div class="grid b-green-b1">' +
                    '<div class="col-0 w50 bgImgGreen pl13 pt2"><i>去外地会诊</i></div>' +
                    '<div class="col-0 w50 text-right color-yellow1 pt2"><i class="huizhen">暂不参与</i></div>' +
                    '</div>' +
                    '<div class="font-s14">';
            var prep_days = '';
            var travel_duration = travelDurationToString(userDoctorHz.travel_duration);
            var weeks = weeksToString(userDoctorHz.week_days);
            var patients_prefer = userDoctorHz.patients_prefer == '' ? '暂无信息' : userDoctorHz.patients_prefer;
            var fee_min = userDoctorHz.fee_min == null ? '无' : userDoctorHz.fee_min;
            var fee_max = userDoctorHz.fee_max == null ? '无' : userDoctorHz.fee_max;
            var freq_destination = userDoctorHz.freq_destination == '' ? '暂无信息' : userDoctorHz.freq_destination;
            var destination_req = userDoctorHz.destination_req == '' ? '暂无信息' : userDoctorHz.destination_req;
            var min_no_surgery = userDoctorHz.min_no_surgery == null ? '暂无信息' : userDoctorHz.min_no_surgery;
            infoHtml += '<div class="mt15"><span class="color-black3">外出会诊台数:</span>' + min_no_surgery + '</div>';
            infoHtml += '<div class="mt5"><span class="color-black3">时间成本要求:</span>' + travel_duration + '</div>';
            infoHtml += '<div class="mt5"><span class="color-black3">方便会诊时间:</span>' + weeks + '</div>';
            infoHtml += '<div class="mt5"><span class="color-black3">愿意会诊病例:</span>' + patients_prefer + '</div>';
            infoHtml += '<div class="mt5"><span class="color-black3">每台咨询费区间:</span>' + fee_min + '元 - ' + fee_max + '元</div>';
            infoHtml += '<div class="mt5"><span class="color-black3">常去地区或医院:</span>' + freq_destination + '</div>';
            infoHtml += '<div class="mt5"><span class="color-black3">对手术地点/要求条件:</span>' + destination_req + '</div>';
            infoHtml += '</div>';
            $(".huizhenInfo").html(infoHtml);
        }
    }

    //设置转诊html
    function setDoctorZzInfo(userDoctorZz) {
        if (userDoctorZz && userDoctorZz.is_join != 0) {
            var infoHtml = '<div class="grid b-green-b1">' +
                    '<div class="col-0 w50 bgImgGreen pl5 pt2"><i>接受病人转诊</i></div>' +
                    '<div class="col-0 w50 text-right color-yellow1 pt2"><i class="zhuanzhen">暂不参与</i></div>' +
                    '</div>' +
                    '<div class="font-s14">';
            var fee = '';
            if (userDoctorZz.fee == null) {
                fee = '暂无信息';
            } else if (userDoctorZz.fee == 0) {
                fee = '不需要';
            } else {
                fee = userDoctorZz.fee + '元';
            }
            var preferredPatient = userDoctorZz.preferredPatient == '' ? '暂无信息' : userDoctorZz.preferredPatient;
            var prep_days = userDoctorZz.prep_days == '' ? '暂无信息' : userDoctorZz.prep_days;
            infoHtml += '<div class="mt15"><span class="color-black3">转诊费:</span>' + fee + '</div>';
            infoHtml += '<div class="mt5"><span class="color-black3">对转诊病例的要求:</span>' + preferredPatient + '</div>';
            infoHtml += '<div class="mt5"><span class="color-black3">最快安排床位时间:</span>' + prep_days + '</div>';
            infoHtml += '</div>';
            $('.zhuanzhenInfo').html(infoHtml);
        }
    }

    //选择不参与异步修改会诊信息
    function ajaxRemoveDoctorHz() {
        var formdata = '{"form":{"disjoin":"0"}}';
        var encryptContext = do_encrypt(formdata);
        var param = {param: encryptContext};
        $.ajax({
            type: 'post',
            url: '<?php echo $urlDoctorHzSubmit ?>',
            data: param,
            'success': function (data) {
                if (data.status == 'ok') {
                    $('.huizhenInfo').remove();
                    //J.showToast('修改成功', '', 500);
                } else {
                    J.showToast('修改失败', '', 500);
                }
            },
            'error': function (data) {
                console.log(data);
            },
            'complete': function () {
            }
        });
    }
    //选择不参与异步修改转诊信息
    function ajaxRemoveDoctorZz() {
        var formdata = '{"form":{"disjoin":"0"}}';
        var encryptContext = do_encrypt(formdata);
        var param = {param: encryptContext};
        $.ajax({
            type: 'post',
            url: '<?php echo $urlDoctorZzSubmit ?>',
            data: param,
            'success': function (data) {
                if (data.status == 'ok') {
                    $('.zhuanzhenInfo').remove();
                    //J.showToast('修改成功', '', 500);
                } else {
                    J.showToast('修改失败', '', 500);
                }
            },
            'error': function (data) {
                console.log(data);
            },
            'complete': function () {
            }
        });
    }

    function travelDurationToString(travel_durations) {
        var travel_duration = '';
        for (var i = 0; i < travel_durations.length; i++) {
            var travel = travel_durations[i];
            if (travel == 'train3h') {
                travel_duration += '高铁3小时内、';
            } else if (travel == 'plane2h') {
                travel_duration += '飞机2小时内、';
            } else if (travel == 'train5h') {
                travel_duration += '高铁5小时内、';
            } else if (travel == 'plane3h') {
                travel_duration += '飞机3小时内、';
            } else if (travel == 'none') {
                travel_duration += '无特殊要求、';
            }
        }
        travel_duration = travel_duration.substring(0, travel_duration.length - 1);
        return travel_duration == '' ? '暂无信息' : travel_duration;
    }

    function weeksToString(week_days) {
        var weeks = '';
        for (var i = 0; i < week_days.length; i++) {
            var week = week_days[i];
            if (week == 1) {
                weeks += '周一、';
            } else if (week == 2) {
                weeks += '周二、';
            } else if (week == 3) {
                weeks += '周三、';
            } else if (week == 4) {
                weeks += '周四、';
            } else if (week == 5) {
                weeks += '周五、';
            } else if (week == 6) {
                weeks += '周六、';
            } else if (week == 7) {
                weeks += '周日、';
            }
        }
        weeks = weeks.substring(0, weeks.length - 1);
        return weeks == '' ? '暂无信息' : weeks;
    }
</script>
</div>

