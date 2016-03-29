<?php
/*
 * $data
 */
$this->setPageID('pBookingInfo');
$this->setPageTitle('预约详情');
$booking = $data->results['patientBooking'];
$patient = $data->results['patientInfo'];
$user = $this->loadUser();
$urlPatientMRFiles = 'http://file.mingyizhudao.com/api/loadpatientbookingmr?userId='.$user->id.'&pbId='.$booking->id.'&reportType=mr';//$this->createUrl('patient/patientMRFiles', array('id' => $patient->id));
$urlPayOrder = $this->createUrl('order/view', array('addBackBtn' => 1, 'bookingId' => $booking->id, 'refNo' => ''));
?>
<div id="section_container" <?php echo $this->createPageAttributes(); ?>>
    <section id="yy_section" class="active" data-init="true">
        <article id="patientBookingView" class="active" data-scroll="true">
            <div class="">
                <div class="grid pt8 pb8 pl10 pr10">
                    <div class="col-1 w30">预约单号</div>
                    <div class="col-1 w70 text-right"><?php echo $booking->refNo; ?></div>
                </div>
                <div class="gridDiv"></div>
                <div class="pl10 pr10">
                    <div class="grid pt8 pb8 b-gray-b">
                        <div class="col-1 w30">患者姓名</div>
                        <div class="col-1 w70 text-right"><?php echo $patient->name; ?></div>
                    </div>
                    <div class="grid pt8 pb8 b-gray-b">
                        <div class="col-1 w30">患者性别</div>
                        <div class="col-1 w70 text-right"><?php echo $patient->gender; ?></div>
                    </div>
                    <?php
                    $yearly = $patient->age;
                    $monthly = "";
                    if ($yearly <= 5 && $patient->ageMonth > 0) {
                        $monthly = $patient->ageMonth . '个月';
                    } else if ($yearly > 5 && $patient->ageMonth > 0) {
                        $yearly++;
                    }
                    ?>
                    <div class="grid pt8 pb8">
                        <div class="col-1 w30">患者年龄</div>
                        <div class="col-1 w70 text-right"><?php echo $yearly; ?>岁<?php echo $monthly; ?></div>
                    </div>
                </div>
                <div class="gridDiv"></div>
                <div class="pl10 pr10">
                    <div class="grid pt8 pb8 b-gray-b">
                        <div class="col-1 w30">处理状态</div>
                        <div class="col-1 w70 text-right color-green"><?php echo $booking->status; ?></div>
                    </div>
                    <div class="grid pt8 pb8 b-gray-b">
                        <div class="col-1 w30">所在城市</div>
                        <div class="col-1 w70 text-right"><?php echo $patient->placeCity; ?></div>
                    </div>
                    <div class="grid pt8 pb8 b-gray-b">
                        <div class="col-1 w30">就诊方式</div>
                        <div class="col-1 w70 text-right"><?php echo $booking->travelType; ?></div>
                    </div>
                    <div class="pt8 pb8">就诊时间</div>
                    <div class="pb8 b-gray-b font-s15"><?php echo $booking->dateStart; ?>--<?php echo $booking->dateEnd; ?></div>
                    <div class="pt8 pb8 b-gray-b">
                        <span>详情描述:</span>
                        <span class=""><?php echo $booking->detail; ?></span>
                    </div>
                    <div class="pt8 pb8 b-gray-b">
                        <span>疾病描述:</span>
                        <span class=""><?php echo $patient->diseaseDetail; ?></span>
                    </div>
                </div>
                <div>
                    <div class="grid middle h40 pl10 pr10">
                        <div class="w100">影像资料</div>
                    </div>
                    <div class="imglist">
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
