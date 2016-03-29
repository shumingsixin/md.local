<?php
/*
 * $model DoctorForm.
 */
$this->setPageID('pUserDoctorProfile');
$this->setPageTitle('个人中心');
$urlPatientCreate = $this->createUrl('patient/create', array('addBackBtn' => 1));
$urlPatientList = $this->createUrl('patient/list', array('addBackBtn' => 1));
$urlPatientBookingList = $this->createUrl('patientbooking/list', array('addBackBtn' => 1));
$urlDoctorPatientBookingList = $this->createUrl('patientbooking/doctorPatientBookingList', array('addBackBtn' => 1));
$urlDoctorAccount = $this->createUrl('doctor/account', array('addBackBtn' => 1));
$urlDoctorInfo = $this->createUrl('doctor/doctorInfo', array('addBackBtn' => 1));
$urlDoctorContract = $this->createUrl('doctor/contract', array('addBackBtn' => 1));
$urlDoctorDrView = $this->createUrl('doctor/drView', array('addBackBtn' => 1));
$urlLogout = $this->createUrl('doctor/logout');
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$verified = $user->verified;
$teamDoctor = $user->teamDoctor;
$urlDoctorTerms = $this->createUrl('doctor/doctorTerms');
?>
<div id="section_container">
    <section id="main_section" class="active">
        <article class="active" data-scroll="true">
            <div class="">
                <ul class="list">
                    <li class="">
                        <div class="grid mt20 mb20">
                            <div class="col-0 text-center w10">
                                <img src="<?php echo $urlResImage; ?>homelogo.png" />
                            </div>
                            <div class="col-0 text-center w70 mt5">
                                您好！<?php echo $user->name; ?>
                            </div>
                            <div class="col-0 verified">
                                <?php
                                if ($user->verified) {
                                    echo '<img src="' . $urlResImage . 'icons/verified.png"/>';
                                } else {
                                    echo '<img src="' . $urlResImage . 'icons/noverified.png"/>';
                                }
                                ?>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a id="createCheck" class="color-000 text-center" data-target="link">
                            <div class="grid font-type">
                                <div class="col-0 w20 color-000 text-center" data-icon="plus"></div>
                                <div class="col-0 w40">
                                    创建患者
                                </div>
                                <div class="col-0 ml20"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a id="patientListCheck" class="color-000 text-center" data-target="link">
                            <div class="grid font-type">
                                <div class="col-0 w20 color-000 text-center" data-icon="users"></div>
                                <div class="col-0 w40">
                                    我的患者
                                </div>
                                <div class="col-0 ml20"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a id="patientBookingListCheck" class="color-000 text-center" data-target="link">
                            <div class="grid font-type">
                                <div class="col-0 w20 color-000 text-center" data-icon="list"></div>
                                <div class="col-0 w40">
                                    发出的预约
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $urlDoctorPatientBookingList; ?>" class="color-000 text-center" data-target="link">
                            <div class="grid font-type">
                                <div class="col-0 w20 color-000 text-center" data-icon="envelop"></div>
                                <div class="col-0 w40">
                                    收到的预约
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="bg-gray"></li>
                    <li>
                        <a href="<?php echo $urlDoctorAccount; ?>" class="color-000 text-center" data-target="link">
                            <div class="grid font-type">
                                <div class="col-0 w20 color-000 text-center" data-icon="info"></div>
                                <div class="col-0 w40">
                                    我的账户
                                </div>
                                <div class="col-0 ml20"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $urlDoctorContract; ?>" class="color-000 text-center" data-target="link">
                            <div class="grid font-type">
                                <div class="col-0 w20 color-000 text-center" data-icon="pencil-2"></div>
                                <div class="col-0 w40">
                                    专家签约
                                </div>
                                <div class="col-0 ml20"></div>
                            </div>
                        </a>
                    </li>
                    <li class="bg-gray"></li>
                    <li class="bg-red color-white">
                        <a href="javascript:;" class="color-000 text-center" id="btn_out">
                            <div class="grid font-type">
                                <div class="col-0 w20 text-center color-white" data-icon="switch"></div>
                                <div class="col-0 w40 color-white">
                                    退出登录
                                </div>
                                <div class="col-0 ml20"></div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </article>
    </section>
</div>
<script>
    $(document).ready(function () {
        //若医生已认证，但未签署协议，则不能创建患者
        $("#createCheck").tap(function (e) {
            e.preventDefault();
            var verified = '<?php echo $verified; ?>';
            var teamDoctor = '<?php echo $teamDoctor ?>';
            if (verified) {
                if (!teamDoctor) {
                    J.hideMask();
                    J.customConfirm('您已实名认证',
                            '<div class="mt10 mb10">尚未签署《医生顾问协议》</div>',
                            '<a id="closeLogout" class="w50">暂不</a>',
                            '<a data="ok" class="color-green w50">签署协议</a>',
                            function () {
                                location.href = "<?php echo $urlDoctorTerms; ?>";
                            },
                            function () {
                            });
                    $('#closeLogout').click(function () {
                        J.closePopup();
                    });
                } else {
                    location.href = "<?php echo $urlPatientCreate; ?>";
                }
            } else {
                location.href = "<?php echo $urlPatientCreate; ?>";
            }
        });

        $("#patientListCheck").tap(function (e) {
            e.preventDefault();
            var verified = '<?php echo $verified; ?>';
            var teamDoctor = '<?php echo $teamDoctor ?>';
            if (verified) {
                if (!teamDoctor) {
                    J.hideMask();
                    J.customConfirm('您已实名认证',
                            '<div class="mt10 mb10">尚未签署《医生顾问协议》</div>',
                            '<a id="closeLogout" class="w50">暂不</a>',
                            '<a data="ok" class="color-green w50">签署协议</a>',
                            function () {
                                location.href = "<?php echo $urlDoctorTerms; ?>";
                            },
                            function () {
                            });
                    $('#closeLogout').click(function () {
                        J.closePopup();
                    });
                } else {
                    location.href = "<?php echo $urlPatientList; ?>";
                }
            } else {
                location.href = "<?php echo $urlPatientList; ?>";
            }
        });

        $("#patientBookingListCheck").tap(function (e) {
            e.preventDefault();
            var verified = '<?php echo $verified; ?>';
            var teamDoctor = '<?php echo $teamDoctor ?>';
            if (verified) {
                if (!teamDoctor) {
                    J.hideMask();
                    J.customConfirm('您已实名认证',
                            '<div class="mt10 mb10">尚未签署《医生顾问协议》</div>',
                            '<a id="closeLogout" class="w50">暂不</a>',
                            '<a data="ok" class="color-green w50">签署协议</a>',
                            function () {
                                location.href = "<?php echo $urlDoctorTerms; ?>";
                            },
                            function () {
                            });
                    $('#closeLogout').click(function () {
                        J.closePopup();
                    });
                } else {
                    location.href = "<?php echo $urlPatientBookingList; ?>";
                }
            } else {
                location.href = "<?php echo $urlPatientBookingList; ?>";
            }
        });

        $("#btn_out").tap(function (e) {
            e.preventDefault();
            J.customConfirm('退出',
                    '<div class="mt10 mb10">您确定要退出该账号？</div>',
                    '<a id="closeLogout" class="w50">取消</a>',
                    '<a data="ok" class="color-green w50">确定</a>',
                    function () {
                        location.href = '<?php echo $urlLogout; ?>';
                    },
                    function () {
                    });
            $('#closeLogout').click(function () {
                J.closePopup();
            });
        });
    });
</script>