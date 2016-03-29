<?php
/*
 * $model DoctorForm.
 */
$this->setPageID('pPersonalCenter');
$this->setPageTitle('个人信息');
$urlDoctorProfile = $this->createUrl('doctor/profile', array('addBackBtn' => 1));
$doctor = $data->results;
?>
<div id="section_container" <?php echo $this->createPageAttributes(); ?>>
    <section id="doctorInfo_section" class="active" data-init="true">
        <article id="a1" class="active" data-scroll="true">
            <div class="doctorInfo pb20">
                <?php
                if ($doctor) {
                    ?>
                    <div class="ml10 mr10 b-gray-b">
                        <div class="grid font-type mb10 mt20">
                            <div class="col-0 title ml20 b-gray-r">
                                姓名
                            </div>
                            <div class="col-0 ml40">
                                <?php echo $doctor->name; ?>
                            </div>
                        </div>
                    </div>
                    <div class="ml10 mr10 b-gray-b">
                        <div class="grid font-type mb10 mt20">
                            <div class="col-0 title ml20 b-gray-r">
                                地区
                            </div>
                            <div class="col-0 ml40">
                                <?php echo $doctor->stateName; ?> <?php echo $doctor->cityName; ?>
                            </div>
                        </div>
                    </div>
                    <div class="ml10 mr10 b-gray-b">
                        <div class="grid font-type mb10 mt20">
                            <div class="col-0 title ml20 b-gray-r">
                                医院
                            </div>
                            <div class="col-0 ml40">
                                <?php echo $doctor->hospitalName; ?>
                            </div>
                        </div>
                    </div>
                    <div class="ml10 mr10 b-gray-b">
                        <div class="grid font-type mb10 mt20">
                            <div class="col-0 title ml20 b-gray-r">
                                科室
                            </div>
                            <div class="col-0 ml40">
                                <?php echo $doctor->hpDeptName; ?>
                            </div>
                        </div>
                    </div>
                    <div class="ml10 mr10 b-gray-b">
                        <div class="grid font-type mb10 mt20">
                            <div class="col-0 title ml20 b-gray-r">
                                医学职称
                            </div>
                            <div class="col-0 ml40">
                                <?php echo $doctor->cTitle; ?>
                            </div>
                        </div>
                    </div>
                    <div class="ml10 mr10 b-gray-b">
                        <div class="grid font-type mb10 mt20">
                            <div class="col-0 title ml20 b-gray-r">
                                学术职称
                            </div>
                            <div class="col-0 ml40">
                                <?php echo $doctor->aTitle; ?>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt60">
                        <?php
                        if ($isVerified) {
                            echo '<p>您已通过实名认证,信息不可以再修改。</p>';
                        }else {
                            echo '<a href="' . $urlDoctorProfile . '" class="btn btn-yes btn-block" data-target="link">修改</a>';
                        }
                        ?>
                    </div>
                    <?php
                } else {
                    echo '<h4 class="text-center">还未填写个人信息</h4><div class="text-center mt30"><a href="' . $urlDoctorProfile . '" class="btn btn-yes btn-block" data-target="link">马上填写</a></div>';
                }
                ?>
            </div>
        </article>
    </section>
</div>
