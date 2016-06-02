<?php
/*
 * $model DoctorForm.
 */
$this->setPageID('pMyBooking');
$this->setPageTitle('我的订单');
$status = Yii::app()->request->getQuery('status', 0);
$BK_STATUS_SERVICE_PAIDED = StatCode::BK_STATUS_SERVICE_PAIDED;
$currentUrl = $this->getCurrentRequestUrl();
$urlDoctorTerms = $this->createAbsoluteUrl('doctor/doctorTerms');
$urlPatientBookingList = $this->createUrl('patientBooking/list', array('addBackBtn' => 1, 'status' => ''));
$urlDoctorTerms.='?returnUrl=' . $currentUrl;
$urlDoctorView = $this->createUrl('doctor/view');
$urlAjaxBookingNum = $this->createUrl('patientbooking/ajaxBookingNum');
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$checkTeamDoctor = $teamDoctor;
?>
<header class="bg-green">
    <nav class="left">
        <a href="<?php echo $urlDoctorView; ?>" data-target="link">
            <div class="pl5">
                <img src="<?php echo $urlResImage; ?>back.png" class="w11p">
            </div>
        </a>
    </nav>
    <h1 class="title">我的订单</h1>
    <nav class="right">
        <a class="header-user" data-target="link" data-icon="user" href="<?php echo $urlDoctorView ?>">
            <i class="icon user"></i>
        </a>
    </nav>
</header>
<div id="section_container" <?php echo $this->createPageAttributes(); ?>>
    <section id="bookingList_section" class="active" data-init="true">
        <nav id="bookingList_nav" class="header-secondary bg-white color-black3 font-s16">
            <div class="grid w100 statusLine">
                <?php
                $statusActive = '';
                if ($status == 0) {
                    $statusActive = 'active';
                }
                ?>
                <div class="col-1 w20 <?php echo $statusActive; ?>">
                    <a href="<?php echo $urlPatientBookingList; ?>/0" id="zhuanti" data-target="link">
                        <div class="grid">
                            <div class="col-1"></div>
                            <div class="col-0 statusIcon">
                                <div class="statusText">全部</div>
                                <div id="allOrders" class="statusNum"></div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                    </a>
                </div>
                <?php
                $statusActive = '';
                if ($status == 1) {
                    $statusActive = 'active';
                }
                ?>
                <div class="col-1 w20 <?php echo $statusActive; ?>">
                    <a href="<?php echo $urlPatientBookingList; ?>/1" id="story" data-target="link">
                        <div class="grid">
                            <div class="col-1"></div>
                            <div class="col-0 statusIcon">
                                <div class="statusText">待支付</div>
                                <div id="waitPay" class="statusNum"></div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                    </a>
                </div>
                <?php
                $statusActive = '';
                if ($status == 2) {
                    $statusActive = 'active';
                }
                ?>
                <div class="col-1 w20 <?php echo $statusActive; ?>">
                    <a href="<?php echo $urlPatientBookingList; ?>/2" id="story" data-target="link">
                        <div class="grid">
                            <div class="col-1"></div>
                            <div class="col-0 statusIcon">
                                <div class="statusText">安排中</div>
                                <div id="arrange" class="statusNum"></div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                    </a>
                </div>
                <?php
                $statusActive = '';
                if ($status == 5) {
                    $statusActive = 'active';
                }
                ?>
                <div class="col-1 w20 <?php echo $statusActive; ?>">
                    <a href="<?php echo $urlPatientBookingList; ?>/5" id="story" data-target="link">
                        <div class="grid">
                            <div class="col-1"></div>
                            <div class="col-0 statusIcon">
                                <div class="statusText">待确认</div>
                                <div id="waitConfirm" class="statusNum"></div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                    </a>
                </div>
                <?php
                $statusActive = '';
                if ($status == 6) {
                    $statusActive = 'active';
                }
                ?>
                <div class="col-1 w20 <?php echo $statusActive; ?>">
                    <a href="<?php echo $urlPatientBookingList; ?>/6" id="story" data-target="link">
                        <div class="grid">
                            <div class="col-1"></div>
                            <div class="col-0 statusIcon">
                                <div class="statusText">传小结</div>
                                <div id="uploadSummary" class="statusNum"></div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                    </a>
                </div>
            </div>
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
                            <a href="<?php echo $this->createUrl('order/orderView', array('bookingid' => $booking->id, 'status' => $status, 'addBackBtn' => 1)); ?>" data-target="link">
                                <div class="p10 bt5-gray">
                                    <div class="grid mt10">
                                        <div class="col-0">患者姓名:</div>
                                        <div class="col-1 pl5"><?php echo $booking->name; ?></div>
                                        <?php
                                        if ($status == 0 || $status == $BK_STATUS_SERVICE_PAIDED) {
                                            if ($booking->statusText == '待支付') {
                                                echo '<div class="col-0 color-red4">' . $booking->statusText . '</div>';
                                            } else if ($booking->statusText == '安排中') {
                                                echo '<div class="col-0 color-green6">' . $booking->statusText . '</div>';
                                            } else if ($booking->statusText == '待确认') {
                                                echo '<div class="col-0 color-green7">' . $booking->statusText . '</div>';
                                            } else if ($booking->statusText == '待上传') {
                                                echo '<div class="col-0 color-blue4">' . $booking->statusText . '</div>';
                                            } else if ($booking->statusText == '待审核') {
                                                echo '<div class="col-0 color-blue5">' . $booking->statusText . '</div>';
                                            } else if ($booking->statusText == '已完成') {
                                                echo '<div class="col-0 color-green5">' . $booking->statusText . '</div>';
                                            } else if ($booking->statusText == '已取消') {
                                                echo '<div class="col-0 color-red3">' . $booking->statusText . '</div>';
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="grid mt10">
                                        <div class="col-0">疾病名称:</div>
                                        <div class="col-1 pl5"><?php echo $booking->diseaseName; ?></div>
                                    </div>
                                    <div class="grid mt10 mb10">
                                        <div class="col-0">就诊意向:</div>
                                        <div class="col-1 pl5"><?php echo $booking->travelType; ?></div>
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
        $.ajax({
            url: '<?php echo $urlAjaxBookingNum; ?>',
            success: function (data) {
                console.log(data);
                var info = data.results.info;
                $('#allOrders').html(info[0]);
                $('#waitPay').html(info[1]);
                $('#arrange').html(info[2]);
                $('#waitConfirm').html(info[5]);
                $('#uploadSummary').html(info[6]);
            }
        });
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