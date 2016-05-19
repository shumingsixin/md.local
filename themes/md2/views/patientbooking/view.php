<?php
/*
 * $data
 */
$this->setPageID('pBookingInfo');
$this->setPageTitle('预约详情');
$user = $this->loadUser();
$booking = $data->results->booking;
$urlUploadMRFile = $this->createUrl('patient/uploadMRFile', array('id' => $booking->patientId, 'type' => 'update', 'addBackBtn' => 1));
$urlPatientMRFiles = 'http://file.mingyizhudao.com/api/loadpatientmr?userId=' . $user->id . '&patientId=' . $booking->patientId . '&reportType=mr'; //$this->createUrl('patient/patientMRFiles', array('id' => $booking->patientId));
$urlPayOrder = $this->createUrl('order/view', array('addBackBtn' => 1, 'bookingId' => $booking->id, 'refNo' => ''));
?>
<div id="section_container" <?php echo $this->createPageAttributes(); ?>>
    <section class="active" data-init="true">
        <article id="patientBookingView_article" class="active" data-scroll="true">
            <div class="pad10">
                <div class="border-gray bg-white br8">
                    <div class="grid pl10 pr10 pt5 pb5 color-green bb-gray">
                        <div class="col-1">基本信息</div>
                        <div class="col-0">
                            <img src="http://7xsq2z.com2.z0.glb.qiniucdn.com/146364029000449" class="w22p">
                        </div>
                    </div>
                    <div class="grid pad10 bb-gray">
                        <div class="col-1 w30">就诊意向</div>
                        <div class="col-1 w70 text-right"><?php echo $booking->travelType; ?></div>
                    </div>
                    <div class="grid pad10 bb-gray">
                        <div class="col-1 w30">意向专家</div>
                        <div class="col-1 w70 text-right"><?php echo $booking->expected_doctor; ?></div>
                    </div>
                    <div class="pad10">
                        <div>诊疗意见</div>
                        <div class="mt5"><?php echo $booking->detail; ?></div>
                    </div>
                </div>
                <div class="border-gray bg-white br8 mt10 mb20">
                    <div class="grid pl10 pr10 pt5 pb5 color-green bb-gray">
                        <div class="col-1">患者资料</div>
                        <div class="col-0">
                            <img src="http://7xsq2z.com2.z0.glb.qiniucdn.com/146364052256387" class="w24p">
                        </div>
                    </div>
                    <div class="grid pad10 bb-gray">
                        <div class="col-1 w30">患者姓名</div>
                        <div class="col-1 w70 text-right"><?php echo $booking->patientName; ?></div>
                    </div>
                    <div class="grid pad10 bb-gray">
                        <div class="col-1 w30">患者性别</div>
                        <div class="col-1 w70 text-right"><?php echo $booking->gender; ?></div>
                    </div>
                    <?php
                    $yearly = $booking->age;
                    $monthly = "";
                    if ($yearly <= 5 && $booking->ageMonth > 0) {
                        $monthly = $booking->ageMonth . '个月';
                    } else if ($yearly > 5 && $booking->ageMonth > 0) {
                        $yearly++;
                    }
                    ?>
                    <div class="grid pad10 bb-gray">
                        <div class="col-1 w30">患者年龄</div>
                        <div class="col-1 w70 text-right"><?php echo $yearly; ?>岁<?php echo $monthly; ?></div>
                    </div>
                    <div class="grid pad10 bb-gray">
                        <div class="col-1 w30">所在城市</div>
                        <div class="col-1 w70 text-right"><?php echo $booking->cityName; ?></div>
                    </div>
                    <div class="grid pad10 bb-gray">
                        <div class="col-1 w30">疾病名称</div>
                        <div class="col-1 w70 text-right"><?php echo $booking->diseaseName; ?></div>
                    </div>
                    <div class="pad10 bb-gray">
                        <div>疾病描述</div>
                        <div class="mt5"><?php echo $booking->diseaseDetail; ?></div>
                    </div>
                    <div class="pad10 bb-gray">
                        <div>
                            影像资料
                        </div>
                        <div class="imglist">
                        </div>
                    </div>
                    <div>
                        <a href="<?php echo $urlUploadMRFile; ?>/patientBookingId/<?php echo $booking->id; ?>" data-target="link">
                            <div class="color-green pad5 text-center">点击编辑</div>
                        </a>
                    </div>
                </div>
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
                if (i % 3 == 0) {
                    innerHtml += '<div class="grid mt10">';
                }
                innerHtml +=
                        '<div class="col-0 pl10 pr10 w33 text-center"><a class="btn_alert"><img class="" data-src="' + imgfiles[i].absFileUrl + '" src="' +
                        imgfiles[i].thumbnailUrl + '" /></div>';
                if (i % 3 == 2) {
                    innerHtml += '</div>';
                }
                //'<div class="' + uiBlock + '"><img data-src="' + imgfiles[i].absFileUrl + '" src="' + imgfiles[i].absThumbnailUrl + '"></div>';
            }
        } else {
            innerHtml += '<div class="pl10">暂无</div>';
        }
        $(".imglist").html(innerHtml);
        $('.btn_alert').tap(function () {
            var imgUrl = $(this).find("img").attr("data-src");
            J.popup({
                html: '<div class="imgpopup"><img src="' + imgUrl + '"></div>',
                pos: 'top-second',
                showCloseBtn: true
            });
            $('.imgpopup').click(function () {
                J.closePopup()
            });
        });
    }
</script>
