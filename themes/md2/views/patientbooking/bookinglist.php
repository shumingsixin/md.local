<?php
/*
 * $model DoctorForm.
 */
$this->setPageID('pMyBooking');
$this->setPageTitle('发出的预约');
$urlCreatePatient = $this->createUrl('patient/create', array('addBackBtn' => 1));
$currentUrl = $this->getCurrentRequestUrl();
$urlDoctorTerms = $this->createAbsoluteUrl('doctor/doctorTerms');
$urlDoctorTerms.='?returnUrl='.$currentUrl;
$urlDoctorView = $this->createUrl('doctor/view');
$checkTeamDoctor = $teamDoctor;
?>
<div id="section_container" <?php echo $this->createPageAttributes(); ?>>
    <section id="bookinglist_section" class="active" data-init="true">
        <article id="a1" class="active" data-scroll="true">
            <div class="pb20">
                <div class="mt20 ml10 mr10">
                    <?php
                    $bookings = $data->results;
                    if ($bookings) {
                        for ($i = 0; $i < count($bookings); $i++) {
                            $booking = $bookings[$i];
                            $yearly = $booking->age;
                            $monthly = "";
                            if ($yearly <= 5 && $booking->ageMonth > 0) {
                                $monthly = $booking->ageMonth . '个月';
                            } else if ($yearly > 5 && $booking->ageMonth > 0) {
                                $yearly++;
                            }
                            ?>
                            <a href="<?php echo $this->createUrl('patientbooking/view', array('id' => $booking->id, 'addBackBtn' => 1)); ?>" data-target="link">
                                <div class="grid vertical b-leftGreen mb20">
                                    <div class="col-1 mt10 ml10 mb10">
                                        预约单号：<?php echo $booking->refNo; ?>
                                    </div>
                                    <div class="col-1 ml10 mb10">
                                        患者姓名：<?php echo $booking->name; ?>
                                    </div>
                                    <div class="col-1 grid ml10 mb10">
                                        疾病名称：<?php echo $booking->diseaseName; ?>
                                    </div>
                                    <div class="col-1 ml10 mb10">
                                        就诊意向：邀请专家过来
                                    </div>
                                    <div class="col-1 mb5 text-right mr10">
                                        提交日期：<?php echo $booking->dateUpdated; ?>
                                    </div>
                                </div>
                            </a>
                            <?php
                        }
                    } else {
                        ?>
                        <h4 class="text-center">暂无预约信息</h4>
                        <div class="mt30">
                            <a href="<?php echo $urlCreatePatient; ?>" data-target="link" class="btn btn-yes btn-block">马上创建</a>
                        </div>
                        <?php
                    }
                    ?>

                </div>
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
    });
</script>