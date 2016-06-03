<?php
/*
 * $model DoctorForm.
 */
$this->setPageID('pPatientInfo');
$this->setPageTitle('患者详情');
$user = $this->loadUser();
$patientInfo = $data->results->patientInfo;
$addBooking = Yii::app()->request->getQuery('addBooking', '1');
$urlUpdatePatientMR = $this->createUrl('patient/updatePatientMR', array('id' => $patientInfo->id, 'addBackBtn' => 1));
$urlUploadMRFile = $this->createUrl('patient/uploadMRFile', array('id' => $patientInfo->id, 'type' => 'update', 'addBackBtn' => 1));
$urlPatientFiles = 'http://file.mingyizhudao.com/api/loadpatientmr?userId=' . $user->id . '&patientId=' . $patientInfo->id . '&reportType=mr'; //$this->createUrl('patient/patientMRFiles', array('id' => $patientInfo->id ? $patientInfo->id : 0));
$urlPatientBookingCreate = $this->createUrl('patientbooking/create', array('pid' => $patientInfo->id, 'addBackBtn' => 1));
?>
<div id="section_container" <?php echo $this->createPageAttributes(); ?>>
    <section id="centerDetail_section" class="active">
        <?php
        if ($addBooking == 1) {
            ?>
            <footer class='bg-white'>
                <button id='patientBookingCreate' class="btn btn-block bg-green">创建就诊信息</button>
            </footer>
        <?php }
        ?>
        <article id="patientView_article" class="active" data-scroll="true">
            <div class="pad10">
                <div class="border-gray bg-white br8 mb20">
                    <div class="grid pl10 pr10 pt5 pb5 color-green bb-gray">
                        <div class="col-1">患者资料</div>
                        <div class="col-0">
                            <img src="http://7xsq2z.com2.z0.glb.qiniucdn.com/146364052256387" class="w24p">
                        </div>
                    </div>
                    <div class="grid pad10 bb-gray">
                        <div class="col-1 w30">患者姓名</div>
                        <div class="col-1 w70 text-right"><?php echo $patientInfo->name; ?></div>
                    </div>
                    <div class="grid pad10 bb-gray">
                        <div class="col-1 w30">联系方式</div>
                        <div class="col-1 w70 text-right"><?php echo $patientInfo->mobile; ?></div>
                    </div>
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
                    <div class="grid pad10 bb-gray">
                        <div class="col-1 w30">患者年龄</div>
                        <div class="col-1 w70 text-right"><?php echo $yearlyText . $monthly; ?></div>
                    </div>
                    <div class="grid pad10 bb-gray">
                        <div class="col-1 w30">所在城市</div>
                        <div class="col-1 w70 text-right"><?php echo $patientInfo->cityName; ?></div>
                    </div>
                    <div class="grid pad10 bb-gray">
                        <div class="col-1 w30">疾病名称</div>
                        <div class="col-1 w70 text-right"><?php echo $patientInfo->diseaseName; ?></div>
                    </div>
                    <div class="pad10 bb-gray">
                        <div>疾病描述</div>
                        <div class="mt5"><?php echo $patientInfo->diseaseDetail; ?></div>
                    </div>
                    <div class="pad10 bb-gray">
                        <div>影像资料</div>
                        <div class="imglist">
                        </div>
                    </div>
                    <div>
                        <a href="<?php echo $urlUploadMRFile; ?>" data-target="link">
                            <div class="color-green pad5 text-center">点击编辑</div>
                        </a>
                    </div>
                </div>
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
        $(".confirmPage").tap(function () {
            $(this).hide();
        });
        $('#patientBookingCreate').tap(function () {
            location.href = '<?php echo $urlPatientBookingCreate; ?>'
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
            var url = $('.imgUrl').attr('href');
            innerHtml += '<div class="pad10 color-red1">暂未上传该患者的影像资料</div>';
        }
        $(".imglist").html(innerHtml);
        $('.btn_alert').tap(function () {
            var imgUrl = $(this).find("img").attr("data-src");
            J.popup({
                html: '<div class="imgpopup"><img src="' + imgUrl + '"></div>',
                pos: 'top-second',
                showCloseBtn: true
            });
            $('.imgpopup').tap(function () {
                J.closePopup();
            });
        });
    }
</script>
