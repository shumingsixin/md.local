<?php
/*
 * $model DoctorForm.
 */
$this->setPageID('pMyBooking');
$this->setPageTitle('我的订单');
$status = Yii::app()->request->getQuery('status', 0);
$currentUrl = $this->getCurrentRequestUrl();
$urlDoctorTerms = $this->createAbsoluteUrl('doctor/doctorTerms');
$urlPatientBookingList = $this->createUrl('patientBooking/list', array('addBackBtn' => 1, 'status' => ''));
$urlDoctorTerms.='?returnUrl=' . $currentUrl;
$urlDoctorView = $this->createUrl('doctor/');
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$checkTeamDoctor = $teamDoctor;
?>
<style>
    .header-secondary{top: 0px;height: 40px;}
    .header-secondary~article{top: 40px;}
    .control-group li:first-child{border-radius: 0px;}
    .control-group{border-radius: 0px;}
    .control-group li:last-child{border-radius: 0px;}
    .control-group li{border: inherit;}
    .control-group li>a{color: #333333;}
    .control-group li.active{background: #fff;}
    .control-group li.active a, .control-group li.active .icon{color: #06c1ae;}

</style>
<div id="section_container" <?php echo $this->createPageAttributes(); ?>>
    <section id="bookingList_section" class="active" data-init="true">
        <nav id="bookingList_nav" class="header-secondary bg-white color-black3">
            <ul class="control-group w100">
                <?php
                $statusActive = '';
                if ($status == 0) {
                    $statusActive = 'active';
                }
                ?>
                <li class="<?php echo $statusActive; ?>">
                    <a href="<?php echo $urlPatientBookingList; ?>/0" id="zhuanti" data-target="link">全部</a>
                </li>
                <?php
                $statusActive = '';
                if ($status == 1) {
                    $statusActive = 'active';
                }
                ?>
                <li class="<?php echo $statusActive; ?>">
                    <a href="<?php echo $urlPatientBookingList; ?>/1" id="story" data-target="link">待支付</a>
                </li>
                <?php
                $statusActive = '';
                if ($status == 2) {
                    $statusActive = 'active';
                }
                ?>
                <li class="<?php echo $statusActive; ?>">
                    <a href="<?php echo $urlPatientBookingList; ?>/2" id="story" data-target="link">安排中</a>
                </li>
                <?php
                $statusActive = '';
                if ($status == 5) {
                    $statusActive = 'active';
                }
                ?>
                <li class="<?php echo $statusActive; ?>">
                    <a href="<?php echo $urlPatientBookingList; ?>/5" id="story" data-target="link">待确认</a>
                </li>
                <?php
                $statusActive = '';
                if ($status == 6) {
                    $statusActive = 'active';
                }
                ?>
                <li class="<?php echo $statusActive; ?>">
                    <a href="<?php echo $urlPatientBookingList; ?>/6" id="story" data-target="link">传小结</a>
                </li>
            </ul>
        </nav>
        <article id="bookingList_article" class="active" data-scroll="true">
            <div class="">
                <div class="">
                    <?php
                    $bookings = $data->results;
                    if ($bookings) {
                        for ($i = 0; $i < count($bookings); $i++) {
                            $booking = $bookings[$i];
                            ?>
                            <a href="<?php echo $this->createUrl('order/orderView', array('bookingid' => $booking->id, 'addBackBtn' => 1)); ?>" data-target="link">
                                <div class="p10 bt5-gray">
                                    <div class="grid mt10">
                                        <div class="col-0">患者姓名:</div>
                                        <div class="col-1 pl5"><?php echo $booking->name; ?></div>
                                    </div>
                                    <div class="grid mt10">
                                        <div class="col-0">疾病名称:</div>
                                        <div class="col-1 pl5"><?php echo $booking->diseaseName; ?></div>
                                    </div>
                                    <div class="grid mt10 mb10">
                                        <div class="col-0">就诊意向:</div>
                                        <div class="col-1 pl5">邀请专家过来</div>
                                    </div>
                                </div>
                            </a>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="mt50 text-center">
                            暂无预约信息
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
        $('#bookingList_article').scroll(function () {
            if ($(this).scrollTop() > 0) {
                $('#bookingList_nav').addClass('bb-gray');
            } else {
                $('#bookingList_nav').removeClass('bb-gray');
            }
        });
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