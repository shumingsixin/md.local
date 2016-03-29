<?php
/*
 * $model DoctorForm.
 */
$this->setPageID('pMyBooking');
$this->setPageTitle('我的患者');
$hasBookingList = $data->results->hasBookingList;
$noBookingList = $data->results->noBookingList;
$urlCreatePatient = $this->createUrl('patient/create', array('addBackBtn' => 1));
$currentUrl = $this->getCurrentRequestUrl();
$urlDoctorTerms = $this->createAbsoluteUrl('doctor/doctorTerms');
$urlDoctorTerms.='?returnUrl=' . $currentUrl;
$urlDoctorView = $this->createUrl('doctor/view');
$checkTeamDoctor = $teamDoctor
?>

<div id="section_container" <?php echo $this->createPageAttributes(); ?>>
    <section class="active">
        <article id="a1" class="active" data-scroll="true">
            <div class="pb20">
                <?php
                if (!$hasBookingList && !$noBookingList) {
                    echo '<h4 class="text-center">暂无病人信息</h4><div><a class="btn btn-yes btn-block" href="' . $urlCreatePatient . '" data-target="link">马上创建患者</a></div>';
                } else {
                    ?>
                    <div class="headerMenu">
                        <div class="grid">
                            <div class="col-1 text-center">
                                <div class="bookingMenu active">已预约（<?php echo count($hasBookingList) ?>）</div>
                            </div>
                            <div class="col-1 text-center">
                                <div class="bookingMenu">未预约（<?php echo count($noBookingList) ?>）</div>
                            </div>
                        </div>
                    </div>
                    <div class="hasBookingList mt20 ml10 mr10">
                        <?php
                        if ($hasBookingList) {
                            for ($i = 0; $i < count($hasBookingList); $i++) {
                                $hasBookingPatient = $hasBookingList[$i];
                                $patientInfo = $hasBookingPatient['patientInfo'];
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
                                <div class="b-leftGreen mb20">
                                    <div class="mt10 ml10 mr10">
                                        <a href="<?php echo $this->createUrl('patient/view', array('id' => $patientInfo->id, 'addBackBtn' => 1)); ?>" class="color-000" data-target="link">
                                            <div class="">
                                                <div class=" mb10">
                                                    <?php echo $patientInfo->name; ?>
                                                </div>
                                                <div class=" mb10">
                                                    <?php echo $patientInfo->gender; ?> &nbsp;|&nbsp; <?php echo $yearlyText . $monthly; ?> &nbsp;|&nbsp; <?php echo $patientInfo->cityName; ?>
                                                </div>
                                                <div class=" mb10">
                                                    <?php echo $patientInfo->diseaseName; ?>
                                                </div>
                                                <div class="text-right mb10">
                                                    更新日期: <?php echo $patientInfo->dateUpdated; ?>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <!--                                <div class="col-0 w20 mt10 pr10 text-center">
                                                                        <a href="#" class="color-000 text-center" id="btn_out">删除</a>
                                                                    </div>-->
                                </div>
                                <?php
                            }
                        } else {
                            echo '<p class="text-center">暂无病人信息</p>';
                        }
                        ?>
                    </div>
                    <div class="mt20 ml10 mr10 noBookingList">
                        <?php
                        if ($noBookingList) {
                            for ($i = 0; $i < count($noBookingList); $i++) {
                                $noBookingPatient = $noBookingList[$i];
                                $patientInfo = $noBookingPatient['patientInfo'];
                                $yearly = $patientInfo->age;
                                $yearlyText = '';
                                $monthly = "";
                                if ($yearly == 0 && $patientInfo->ageMonth > 0) {
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
                                <div class="b-leftGreen mb20">
                                    <div class="mt10 ml10 mr10">
                                        <a href="<?php echo $this->createUrl('patient/view', array('id' => $patientInfo->id, 'addBackBtn' => 1)); ?>" class="color-000" data-target="link">
                                            <div class="">
                                                <div class=" mb10">
                                                    <?php echo $patientInfo->name; ?>
                                                </div>
                                                <div class=" mb10">
                                                    <?php echo $patientInfo->gender; ?> &nbsp;|&nbsp; <?php echo $yearlyText . $monthly; ?> &nbsp;|&nbsp; <?php echo $patientInfo->cityName; ?>
                                                </div>
                                                <div class=" mb10">
                                                    <?php echo $patientInfo->diseaseName; ?>
                                                </div>
                                                <div class="text-right mb10">
                                                    更新日期: <?php echo $patientInfo->dateUpdated; ?>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <!--                                <div class="col-0 w20 mt10 pr10 text-center">
                                                                        <a href="#" class="color-000 text-center" id="btn_out">删除</a>
                                                                    </div>-->
                                </div>
                                <?php
                            }
                        } else {
                            echo '<p class="text-center">暂无病人信息</p>';
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>
        </article>
    </section>
</div>
<script>
    $(document).ready(function () {
        if ('<?php echo $checkTeamDoctor; ?>' == 1) {
            J.customConfirm('您已实名认证',
                    '<div class="mt10 mb10">尚未签署《医生顾问协议》</div>',
                    '<a data="cancel" class="w50">暂不</a>',
                    '<a data="ok" class="color-green w50">签署协议</a>',
                    function () {
                        location.href = "<?php echo $urlDoctorTerms; ?>";
                    },
                    function () {
                        location.href = "<?php echo $urlDoctorView; ?>";
                    });
        }
        $(".bookingMenu").click(function () {
            $(".bookingMenu").removeClass("active");
            $(this).addClass('active');
            $(".hasBookingList").toggle();
            $(".noBookingList").toggle();
        });
    });
</script>
