<?php
/*
 * $model DoctorForm.
 */
$this->setPageID('pMyBooking');
$this->setPageTitle('发出预约');
$hasBookingList = $data->results->hasBookingList;
$noBookingList = $data->results->noBookingList;
$urlCreatePatient = $this->createUrl('patient/create', array('addBackBtn' => 1, 'status' => 0));
$currentUrl = $this->getCurrentRequestUrl();
$urlDoctorTerms = $this->createAbsoluteUrl('doctor/doctorTerms');
$urlSearchView = $this->createUrl('patient/searchView', array('addBackBtn' => 1));
$urlDoctorTerms.='?returnUrl=' . $currentUrl;
$urlDoctorView = $this->createUrl('doctor/view');
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$checkTeamDoctor = $teamDoctor;
$this->show_header = false;
?>
<header class="bg-green">
    <nav class="left">
        <a href="<?php echo $urlDoctorView; ?>" data-target="link">
            <div class="pl5">
                <img src="<?php echo $urlResImage; ?>back.png" class="w11p">
            </div>
        </a>
    </nav>
    <ul class="control-group">
        <li data-booking="yes" class="bookingMenu active">已预约</li>
        <li data-booking="no" class="bookingMenu">未预约</li>
    </ul>
    <nav class="right">
        <a class="header-user" data-target="link" data-icon="user" href="<?php echo $urlDoctorView ?>">
            <i class="icon user"></i>
        </a>
    </nav>
</header>
<div id="section_container" <?php echo $this->createPageAttributes(); ?>>
    <section class="active">
        <nav id="patientList_nav" class="header-secondary">
            <div class="w100 pl10 pr10">
                <a href="<?php echo $urlSearchView; ?>">
                    <div class="searchDiv grid">
                        <div class="col-0 searchIcon">

                        </div>
                        <div class="col-1 text-left">
                            搜索
                        </div>
                    </div>
                </a>
            </div>
        </nav>
        <footer class='bg-white'>
            <button id='patientCreate' class="btn btn-block bg-green">创建新患者</button>
        </footer>
        <article id="patientList_article" class="active" data-scroll="true">
            <div class="">
                <div class="hasBookingList mt10">
                    <?php
                    if ($hasBookingList) {
                        for ($i = 0; $i < count($hasBookingList); $i++) {
                            $hasBookingPatient = $hasBookingList[$i];
                            $patientInfo = $hasBookingPatient['patientInfo'];
                            $patientBooking = $hasBookingPatient['patientBooking'];
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
                            <div class="bb5-gray">
                                <div class="mt10 ml10 mr10 mb10">
                                    <a href="<?php echo $this->createUrl('patientBooking/view', array('id' => $patientBooking->id, 'addBackBtn' => 1)); ?>" class="color-000" data-target="link">
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
                <div class="noBookingList mt10 hide">
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
                            <div class="bb5-gray">
                                <div class="mt10 ml10 mr10 mb10">
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
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<p class="text-center">暂无病人信息</p>';
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
        $(".bookingMenu").click(function () {
            var dataBooking = $(this).attr('data-booking');
            if (dataBooking == 'yes') {
                $('.noBookingList').addClass('hide');
                $('.hasBookingList').removeClass('hide');
                $('#patientList_article').scrollTop(0);
            } else {
                $('.hasBookingList').addClass('hide');
                $('.noBookingList').removeClass('hide');
                $('#patientList_article').scrollTop(0);
            }
        });
        $('#patientCreate').click(function () {
            location.href = '<?php echo $urlCreatePatient; ?>';
        });
    });
</script>
