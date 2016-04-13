<?php
/*
 * $model DoctorForm.
 */
$this->setPageID('pUserDoctorProfile');
$this->setPageTitle('个人中心');
$urlPatientCreate = $this->createUrl('patient/create', array('addBackBtn' => 1));
$urlPatientList = $this->createUrl('patient/list', array('addBackBtn' => 1));
$urlPatientBookingList = $this->createUrl('patientbooking/list', array('status' => 0, 'addBackBtn' => 1));
$urlDoctorPatientBookingList = $this->createUrl('patientbooking/doctorPatientBookingList', array('addBackBtn' => 1));
$urlDoctorAccount = $this->createUrl('doctor/account', array('addBackBtn' => 1));
$urlDoctorInfo = $this->createUrl('doctor/doctorInfo', array('addBackBtn' => 1));
$urlDoctorContract = $this->createUrl('doctor/contract', array('addBackBtn' => 1));
$urlDoctorDrView = $this->createUrl('doctor/drView', array('addBackBtn' => 1));
$urlDoctorProfile = $this->createUrl('doctor/profile');
$urlDoctorTerms = $this->createUrl('doctor/doctorTerms');
$urlDoctorUploadCert = $this->createUrl('doctor/uploadCert');
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$verified = $user->verified;
$teamDoctor = $user->teamDoctor;
?>
<header class="bg-green">
    <h1 class="title">个人中心</h1>
</header>
<div id="section_container">
    <section id="main_section" class="active">
        <article id="doctorView_article" class="active" data-scroll="true">
            <div class="">
                <div class="bg-green">
                    <div class="pad20 grid">
                        <div class="col-0 w77p">
                            <img src="<?php echo $urlResImage; ?>center/user.png">
                        </div>
                        <div class="col-1 color-white pl20 grid">
                            <div class="col-1">
                                <div class="pt10">
                                    您好!<?php echo $user->name; ?>
                                </div>
                                <div class="pt10">
                                    <span class="realNameIcon">
                                        <?php
                                        if ($user->verified) {
                                            echo '实名认证';
                                        } else {
                                            echo '未实名认证';
                                        }
                                        ?>
                                    </span>
                                </div>
                            </div>
                            <div id="userCenter" class="col-0 w15p grid middle">
                                <img src="<?php echo $urlResImage; ?>nextImg.png" class="w8p">
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="list mt10">
                    <li class="nextImg hide">
                        <a id="createCheck" class="color-000" data-target="link">
                            <div class="grid font-type">
                                <div class="col-0 w20"></div>
                                <div class="col-0 w80">
                                    创建患者
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="nextImg">
                        <a id="patientListCheck" class="color-000" data-target="link">
                            <div class="grid font-type">
                                <div class="col-0 w20 myPatients"></div>
                                <div class="col-0 w80">
                                    我的患者
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="nextImg">
                        <a id="patientBookingListCheck" class="color-000" data-target="link">
                            <div class="grid font-type">
                                <div class="col-0 w20 myBooking"></div>
                                <div class="col-0 w80">
                                    我的订单
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="nextImg">
                        <a href="<?php echo $urlDoctorPatientBookingList; ?>" class="color-000" data-target="link">
                            <div class="grid font-type">
                                <div class="col-0 w20 receivedBooking"></div>
                                <div class="col-0 w80">
                                    收到预约
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
                <ul class="list mt10">
                    <li class="nextImg">
                        <div id="checkInf" class="grid font-type">
                            <div class="col-0 w20 consultingAgreement"></div>
                            <div class="col-0 w80">
                                名医主刀顾问协议
                            </div>
                        </div>
                    </li>
                    <li class="nextImg">
                        <a href="<?php echo $urlDoctorContract; ?>" class="color-000" data-target="link">
                            <div class="grid font-type">
                                <div class="col-0 w20 signDoctor"></div>
                                <div class="col-0 w80">
                                    成为签约主刀专家
                                </div>
                            </div>
                        </a>
                    </li>
                    <li id="phoneService" class="nextImg">
                        <div class="grid font-type">
                            <div class="col-0 w20 customerService"></div>
                            <div class="col-0 w80">
                                联系客服
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </article>
    </section>
</div>
<script>
    $(document).ready(function () {
        //个人中心
        $('#userCenter').click(function () {
            location.href = '<?php echo $urlDoctorAccount; ?>';
        });

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

        //医生顾问协议
        $('#checkInf').tap(function (e) {
            e.preventDefault();
            console.log('<?php echo $user->doctorCerts; ?>');
            if ('<?php echo $user->isProfile; ?>' == '') {
                J.hideMask();
                J.customConfirm('',
                        '<div class="mt10 mb10">您尚未完善个人信息</div>',
                        '<a id="closeLogout" class="w50">暂不</a>',
                        '<a data="ok" class="color-green w50">完善信息</a>',
                        function () {
                            location.href = '<?php echo $urlDoctorProfile; ?>';
                        },
                        function () {
                        });
                $('#closeLogout').click(function () {
                    J.closePopup();
                });
            } else if ('<?php echo $user->doctorCerts; ?>' == '') {
                J.hideMask();
                J.customConfirm('',
                        '<div class="mt10 mb10">您尚未上传实名认证证件</div>',
                        '<a id="closeLogout" class="w50">暂不</a>',
                        '<a data="ok" class="color-green w50">上传证件</a>',
                        function () {
                            location.href = '<?php echo $urlDoctorUploadCert; ?>';
                        },
                        function () {
                        });
                $('#closeLogout').click(function () {
                    J.closePopup();
                });
            } else if ('<?php echo $user->verified; ?>' == '') {
                J.hideMask();
                J.customConfirm('',
                        '<div class="mt10 mb10">请等待信息审核</div>',
                        '<a id="closeLogout" class="">确定</a>',
                        '',
                        function () {
                        },
                        function () {
                        });
                $('#closeLogout').click(function () {
                    J.closePopup();
                });
            } else {
                location.href = '<?php echo $urlDoctorTerms; ?>';
            }
        });

        $('#phoneService').tap(function () {
            J.customAlert('<div><a href="tel://4001197900" class="color-green"><div class="pad10 bb-gray">立即拨打免费客服电话</div></a></div><div id="closeContract" class="color-red2 pad10">取消</div>');
            $('#closeContract').click(function () {
                J.closePopup();
            });
        });
    });
</script>