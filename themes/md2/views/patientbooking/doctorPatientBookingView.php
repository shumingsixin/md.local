<?php
/*
 * $data
 */
$this->setPageID('pBookingInfo');
$this->setPageTitle('预约详情');
$booking = $data->results->booking;
$user = $this->loadUser();
$urlPatientMRFiles = 'http://file.mingyizhudao.com/api/loadpatientbookingmr?userId=' . $user->id . '&pbId=' . $booking->id . '&reportType=mr'; //$this->createUrl('patient/patientMRFiles', array('id' => $patient->id));
$urlPayOrder = $this->createUrl('order/view', array('addBackBtn' => 1, 'bookingId' => $booking->id, 'refNo' => ''));
$urlAjaxDoctorOpinion = $this->createUrl('patientBooking/ajaxDoctorOpinion');
$urlDoctorView = $this->createUrl('doctor/view');
?>
<div id="section_container" <?php echo $this->createPageAttributes(); ?>>
    <section id="yy_section" class="active" data-init="true">
        <article id="patientBookingView" class="active" data-scroll="true">
            <div class="">
                <?php
                if (isset($booking->doctorAccept)) {
                    ?>
                    <div class="pl10 pr10 mb10 mt10">
                        <div class="bd-gray pad5">
                            <span class="color-green">您的答复：</span>
                            <?php echo $booking->doctorOpinion ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <ul class="list">
                    <?php
                    if ($booking->bkType == 2) {
                        ?>
                        <li class="grid">
                            <div class="col-1 w30">就诊意向</div>
                            <div class="col-1 w70 text-right"><?php echo $booking->travelType; ?></div>
                        </li>
                        <?php
                    }
                    ?>
                    <li class="grid">
                        <div class="col-1 w30">意向专家</div>
                        <div class="col-1 w70 text-right"><?php echo $booking->expected_doctor; ?></div>
                    </li>
                </ul>
                <?php
                if ($booking->bkType == 2) {
                    ?>
                    <div class="pad10">
                        <div>诊疗意见</div>
                        <div class="mt5"><?php echo $booking->detail; ?></div>
                    </div>
                    <?php
                    $noBorderTop = '';
                } else {
                    $noBorderTop = 'noBorderTop';
                }
                ?>
                <ul class="list">
                    <li class="grid <?php echo $noBorderTop; ?>">
                        <div class="col-1 w30">患者姓名</div>
                        <div class="col-1 w70 text-right"><?php echo $booking->patientName; ?></div>
                    </li>
                    <?php
                    if ($booking->bkType == 2) {
                        ?>
                        <li class="grid">
                            <div class="col-1 w30">患者性别</div>
                            <div class="col-1 w70 text-right"><?php echo $booking->gender; ?></div>
                        </li>
                        <?php
                    }
                    ?>
                    <?php
                    if ($booking->bkType == 2) {
                        $yearly = $booking->age;
                        $monthly = "";
                        if ($yearly <= 5 && $booking->ageMonth > 0) {
                            $monthly = $booking->ageMonth . '个月';
                        } else if ($yearly > 5 && $booking->ageMonth > 0) {
                            $yearly++;
                        }
                        ?>
                        <li class="grid">
                            <div class="col-1 w30">患者年龄</div>
                            <div class="col-1 w70 text-right"><?php echo $yearly; ?>岁<?php echo $monthly; ?></div>
                        </li>
                        <li class="grid">
                            <div class="col-1 w30">所在城市</div>
                            <div class="col-1 w70 text-right"><?php echo $booking->placeCity; ?></div>
                        </li>
                        <?php
                    }
                    ?>
                    <li class="grid">
                        <div class="col-1 w30">疾病诊断</div>
                        <div class="col-1 w70 text-right"><?php echo $booking->diseaseName; ?></div>
                    </li>
                </ul>
                <div class="pad10 bb-gray">
                    <div>疾病描述</div>
                    <div class="mt5"><?php echo $booking->diseaseDetail; ?></div>
                </div>
                <div>
                    <div class="grid middle h40 pl10 pr10">
                        <div class="w100">影像资料</div>
                    </div>
                    <div class="imglist">
                    </div>
                </div>
                <div class="pl10 pr10">
                    <div class="mt20">
                        名医助手补充说明：
                    </div>
                    <div>
                        <?php echo $booking->csExplain == '' ? '暂无' : $booking->csExplain; ?>
                    </div>
                    <?php
                    if (!isset($booking->doctorAccept)) {
                        ?>
                        <div class="mt20">
                            您的反馈意见：
                        </div>
                        <div class="mt5">
                            <textarea></textarea>
                        </div>
                        <div class="grid">
                            <div class="col-1 w40">
                                <button id="disAgree" class="btnSubmit btn-full b-gray br5 text-center bg-white color-black">拒绝</button>
                            </div>
                            <div class="col-1 w20"></div>
                            <div class="col-1 w40">
                                <button id="agree" class="btnSubmit btn-full br5 text-center bg-green color-white">同意</button>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="font-s12 color-red pt50">
                        *如有疑问，请拨打客服热线：400-6277-120
                    </div>
                    <div class="text-center mb20">
                        <a href="tel://4006277120" class="btn-red pl10 pr10">点击拨号</a>
                    </div>
                </div>
                <?php //var_dump($booking);  ?>
            </div>
        </article>
    </section>
</div>
<script>
    $(document).ready(function () {
        ajaxPatientFiles();
        $(".confirmPage").click(function () {
            $(this).hide();
        });

        $('.btnSubmit').click(function () {
            var option = $('textarea').val();
            if (option == '') {
                J.showToast('请输入反馈意见', '', 1000);
                return;
            }
            $('.btnSubmit').each(function () {
                $(this).attr("disabled", true);
            });
            var requestUrl = '<?php echo $urlAjaxDoctorOpinion; ?>';
            var type = '';
            if ('<?php echo $booking->bkType; ?>' == 1) {
                type = 1;
            } else {
                type = 2;
            }
            if ($(this).attr('id') == 'disAgree') {
                requestUrl += '/id/<?php echo $booking->id; ?>/accept/0/type/' + type + '/opinion/' + option;
            } else {
                requestUrl += '/id/<?php echo $booking->id; ?>/accept/1/type/' + type + '/opinion/' + option;
            }
            $.ajax({
                url: requestUrl,
                success: function (data) {
                    //console.log(data);
                    J.customConfirm('',
                            '<div class="mb10 text-left">感谢您的爱心和辛勤付出，名医助手将尽快和您联系</div>',
                            '<a id="backCenter" class="color-green">返回个人中心</a>',
                            '',
                            function () {
                            },
                            function () {
                            });
                    $('#backCenter').click(function () {
                        location.href = "<?php echo $urlDoctorView; ?>";
                    });
                },
                error: function (data) {
                }
            });
        });
    });
    function ajaxPatientFiles() {
        urlPatientFiles = "<?php echo $urlPatientMRFiles; ?>";
        $.ajax({
            url: urlPatientFiles,
            success: function (data) {
                setImgHtml(data.results.files);
            }
        });
    }
    function setImgHtml(imgfiles) {
        var innerHtml = '';
        if (imgfiles && imgfiles.length > 0) {
            for (i = 0; i < imgfiles.length; i++) {
                if (i % 2 == 0) {
                    innerHtml += '<div class="grid mt10">';
                }
                innerHtml +=
                        '<div class="col-0 pl10 pr10 w50 text-center"><a class="btn_alert"><img class="" data-src="' + imgfiles[i].absFileUrl + '" src="' +
                        imgfiles[i].thumbnailUrl + '" /></div>';
                if (i % 2 == 1) {
                    innerHtml += '</div>';
                }
                //'<div class="' + uiBlock + '"><img data-src="' + imgfiles[i].absFileUrl + '" src="' + imgfiles[i].absThumbnailUrl + '"></div>';
            }
        } else {
            innerHtml += '<div class="col-0 pl10 pr10">无</div>';
        }
        $(".imglist").html(innerHtml);
        $('.btn_alert').tap(function () {
            var imgUrl = $(this).find("img").attr("data-src");
            J.popup({
                html: '<div class="imgpopup"><img src="' + imgUrl + '"></div>',
                pos: 'top-second',
                showCloseBtn: true
            });
        });
    }
</script>
