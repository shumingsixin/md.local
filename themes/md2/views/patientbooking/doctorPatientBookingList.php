<?php
/*
 * $model DoctorForm.
 */
$this->setPageID('pMyBooking');
$this->setPageTitle('收到的预约');
$urlDoctorView = $this->createUrl('doctor/view');
?>
<div id="section_container" <?php echo $this->createPageAttributes(); ?>>
    <section id="getRequest_section" class="active" data-init="true">
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
                            <a href="<?php echo $this->createUrl('patientbooking/doctorPatientBooking', array('id' => $booking->id, 'addBackBtn' => 1)); ?>" data-target="link">
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
                            <a href="<?php echo $urlDoctorView; ?>" data-target="link" class="btn btn-yes btn-block">返回个人中心</a>
                        </div>
                        <?php
                    }
                    ?>

                </div>
            </div>
        </article>
    </section>
</div>
