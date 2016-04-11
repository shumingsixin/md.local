<?php
/*
 * $model DoctorForm.
 */
$this->setPageID('pPatientInfo');
$this->setPageTitle('患者详情');
$user = $this->loadUser();
$patientInfo = $data->results->patientInfo;
$patientBooking = $data->results->patientBooking;
$urlUpdatePatientMR = $this->createUrl('patient/updatePatientMR', array('id' => $patientInfo->id, 'addBackBtn' => 1));
$urlUploadMRFile = $this->createUrl('patient/uploadMRFile', array('id' => $patientInfo->id, 'type' => 'update', 'addBackBtn' => 1));
$urlPatientFiles = 'http://192.168.31.119/file.myzd.com/api/loadpatientmr?userId=' . $user->id . '&patientId=' . $patientInfo->id . '&reportType=mr'; //$this->createUrl('patient/patientMRFiles', array('id' => $patientInfo->id ? $patientInfo->id : 0));
$urlPatientBookingCreate = $this->createUrl('patientbooking/create', array('pid' => $patientInfo->id, 'addBackBtn' => 1));
?>
<div id="section_container" <?php echo $this->createPageAttributes(); ?>>
    <section id="centerDetail_section" class="active">
        <article id="a1" class="active" data-scroll="true">
            <div class="pb20 mt20">
                <?php
                if ($patientBooking) {
                    ?>
                    <div class="font-type ml10 mr10 mt00 text-center">
                        <div class="color-green"><?php echo $patientBooking->status; ?></div>
                    </div>
                    <div class="bg-img w100 h30 text-center mt20">
                        <span class="label bg-green color-fff">就诊意向</span>
                    </div>
                    <div class="ml10 mr10">
                        <div class="mb10">
                            <?php echo $patientBooking->travelType; ?>
                        </div>
                        <div class="mb10">
                            <?php echo $patientBooking->expectedDoctor; ?>
                        </div>
                        <div class="line-h">
                            <?php echo $patientBooking->detail; ?>
                        </div>
                    </div>
                    <div class="bg-img w100 h30 text-center mt20">
                        <span class="label bg-green color-fff">患者资料</span>
                    </div>
                    <?php
                }
                ?>
                <div class="ml10 mr10 mt20">
                    <?php
                    $yearly = $patientInfo->age;
                    $yearlyText = '';
                    $monthly = "";
                    if ($yearly == 0 && $patientInfo->ageMonth >= 0) {
                        $yearlyText = '';
                        $monthly = $patientInfo->ageMonth . '个月';
                    } else if ($yearly <= 5 && $patientInfo->ageMonth > 0) {
                        $yearlyText = $yearly . '岁';
                        $monthly = $patientInfo->ageMonth . '个月';
                    } else if ($yearly > 5 && $patientInfo->ageMonth > 0) {
                        $yearly++;
                        $yearlyText = $yearly . '岁';
                    } else {
                        $yearlyText = $yearly . '岁';
                    }
                    ?>
                    <div class="grid mb20">
                        <div class="col-0 font-type w80">
                            病情描述：
                        </div>
                        <div class="col-0 w20 text-center">
                            <a href="<?php echo $urlUpdatePatientMR; ?>" class="color-green" data-target="link">修改</a>
                        </div>
                    </div>
                    <div class="mb20">
                        <?php echo $patientInfo->name ?> | <?php echo $patientInfo->gender ?> | <?php echo $yearlyText . $monthly; ?> | <?php echo $patientInfo->cityName ?>
                    </div>
                    <div class="mb30 line-h">
                        <?php echo $patientInfo->diseaseDetail; ?>
                    </div>
                </div>
                <div class="bg-img h30"></div>
                <div class="ml10 mr10 mt10">
                    <div class="grid">
                        <div class="col-0 font-20 w80">
                            影像资料：
                        </div>
                        <div class="col-0 w20 text-center">
                            <a href="<?php echo $urlUploadMRFile; ?>" class="color-green" data-target="link">修改</a>
                        </div>
                    </div>
                    <div class="imglist mb20">

                    </div>
                    <?php
                    if (!$patientBooking) {
                        ?>
                        <div class="text-center mt40">
                            <a href="<?php echo $urlPatientBookingCreate; ?>" class="btn-green pl10 pr10 pt10 pb10 h50 text-center" data-target="link">创建就诊信息</a>
                        </div>
                    <?php }
                    ?>

                </div>
            </div>
        </article>
    </section>
</div>
<script type="text/javascript">
    Zepto(function ($) {
        id = "<?php echo $patientInfo->id; ?>";
        if (id) {
            ajaxPatientFiles();
        }
        $(".confirmPage").click(function () {
            $(this).hide();
        });
    });
    function ajaxPatientFiles() {
        urlPatientFiles = "<?php echo $urlPatientFiles; ?>";
        $.ajax({
            url: urlPatientFiles,
            success: function (data) {
                setImgHtml(data.results.files);
            }
        });
    }
    function setImgHtml(imgfiles) {
        var innerHtml = '';
        var uiBlock = '';
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
            innerHtml += '无';
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
