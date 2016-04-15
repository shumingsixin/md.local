<?php
/*
 * $model DoctorForm.
 */
$this->setPageID('pUserDoctorProfile');
$this->setPageTitle('我的账户');
$urlDoctorInfo = $this->createUrl('doctor/doctorInfo', array('addBackBtn' => 1));
$urlUploadCert = $this->createUrl('doctor/uploadCert', array('addBackBtn' => 1));
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$urlDoctorProfile = $this->createUrl('doctor/profile');
$urlDoctorTerms = $this->createUrl('doctor/doctorTerms');
$urlDoctorUploadCert = $this->createUrl('doctor/uploadCert');
$urlLogout = $this->createUrl('doctor/logout');
$userProfile = $userDoctorProfile;
$userVerified = $verified;
$userDoctorCerts = $doctorCerts;
?>
<div id="section_container" <?php echo $this->createPageAttributes(); ?>>
    <section id="account_section" class="active">
        <article class="active" data-scroll="true">
            <div class="">
                <ul class="list">
                    <li>
                        <a href="<?php echo $urlDoctorInfo; ?>" class="color-000 text-center" data-target="link">
                            <div class="grid font-type">
                                <div class="col-0 w20 color-000 text-center" data-icon="user"></div>
                                <div class="col-0 w40 text-left">
                                    个人信息
                                </div>
                                <div class="col-0 ml20"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $urlUploadCert; ?>" class="color-000 text-center" data-target="link">
                            <div class="grid font-type">
                                <div class="col-0 w20 color-000 text-center" data-icon="images"></div>
                                <div class="col-0 w40 text-left">
                                    实名认证
                                </div>
                                <div class="col-0 ml20"></div>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="mt50 pl10 pr10">
                    <div id="btn_out" class="br5 bg-red pad10 text-center color-white">退出登录</div>
                </div>
            </div>
        </article>
    </section>
</div>
<script>
    $(document).ready(function () {
        //退出登录
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