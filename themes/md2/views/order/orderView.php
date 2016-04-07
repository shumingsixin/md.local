<?php
/*
 * $model DoctorForm.
 */
$this->setPageTitle('支付订单');
$urlPatientBooking = $this->createUrl('booking/patientBooking', array('id' => ''));
$urlPatientBookingList = $this->createUrl('booking/patientBookingList');
$urlPatientBookingView = $this->createUrl('patientBooking/view', array('id' => ''));
$status = Yii::app()->request->getQuery('status', 0);
$payUrl = $this->createUrl('/payment/doPingxxPay');
$refUrl = $this->createAbsoluteUrl('order/view');
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$BK_STATUS_NEW = StatCode::BK_STATUS_NEW;
$BK_STATUS_SERVICE_UNPAID = StatCode::BK_STATUS_SERVICE_UNPAID;
$BK_STATUS_SERVICE_PAIDED = StatCode::BK_STATUS_SERVICE_PAIDED;
$this->show_footer = false;
$booking = $data->results->booking;
$notPays = $data->results->notPays;
$pays = $data->results->pays;
?>
<style>
    .popup-title{color: #333333;}
    #payOrder_article{
        background-color: #EAEFF1;
    }
    #payOrder_article ul{
        box-shadow: 2px 2px 15px rgba(0,0,0,0.3);
    }
</style>
<header class="bg-green">
    <nav class="left">
        <?php
        if (($booking->statusCode == $BK_STATUS_NEW) && (isset($notPays))) {
            ?>
            <a id="noPayNew">
                <div class="pl5">
                    <img src="<?php echo $urlResImage; ?>back.png" class="w11p">
                </div>
            </a>
            <?php
        } else if (($booking->statusCode == $BK_STATUS_SERVICE_UNPAID) && (isset($notPays))) {
            ?>
            <a id="noPayService">
                <div class="pl5">
                    <img src="<?php echo $urlResImage; ?>back.png" class="w11p">
                </div>
            </a>
            <?php
        } else {
            ?>
            <a href="" data-target="back">
                <div class="pl5">
                    <img src="<?php echo $urlResImage; ?>back.png" class="w11p">
                </div>
            </a>
            <?php
        }
        ?>
    </nav>
    <h1 class="title">支付订单</h1>
</header>
<div id="section_container" <?php echo $this->createPageAttributes(); ?>>
    <section id="doctorInfo_section" class="active" data-init="true">
        <?php
        if (isset($notPays)) {
            ?>
            <footer class="bg-white grid">
                <div class="col-1 w60 color-green middle grid">¥<?php echo $notPays->finalAmount; ?>元</div>
                <div id="pay" class="col-1 w40 bg-green color-white middle grid">支付</div>;
            </footer>
            <?php
        }
        ?>
        <article id='payOrder_article' class="active" data-scroll="true">
            <div>
                <?php //var_dump($data); ?>
                <div class="grid pl10 pr10 mt20 color-green font-s18">
                    <div class="col-0">
                        <img src="<?php echo $urlResImage; ?>orderStatusIcon.png" class="w20p mr10">
                    </div>
                    <div class="col-1 pt3">
                        当前状态：<?php echo $booking->statusTitle; ?>
                    </div>
                </div>
                <div class="mt20 ml10 mr10 bbb">
                    <ul class="list">
                        <li class="grid">
                            <div class="col-0">就诊意向</div>
                            <div class="col-1 text-right"><?php echo $booking->travelType; ?></div>
                        </li>
                        <li class="grid">
                            <div class="col-0">意向专家</div>
                            <div class="col-1 text-right"><?php echo $booking->doctorName; ?></div>
                        </li>
                        <li>
                            <div>诊疗意见</div>
                            <div class="w100"><?php echo $booking->detail; ?></div>
                        </li>
                        <li class="grid">
                            <div class="col-0">患者姓名</div>
                            <div class="col-1 text-right"><?php echo $booking->patientName; ?></div>
                        </li>
                        <li>
                            <div class="text-right">
                                <a  href="<?php echo $urlPatientBookingView; ?>/<?php echo $booking->id; ?>/addBackBtn/1" class="color-green">查看详情></a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="font-s12 letter-s1 ml20 mr20 mt10">
                    <div>订单编号:<?php echo $booking->refNo; ?></div>
                    <div>创建时间:<?php echo $booking->dateCreated; ?></div>
                    <?php
                    if (isset($pays)) {
                        for ($i = 0; $i < count($pays); $i++) {
                            echo '<div>提交时间:已支付' . $pays[$i]->orderType . $pays[$i]->finalAmount . '</div>';
                        }
                    }
                    ?>
                </div>
                <?php
                if ($booking->statusCode == $BK_STATUS_SERVICE_PAIDED) {
                    ?>
                    <a>上传照片</a>
                    <?php
                }
                ?>
            </div>
        </article>
    </section>
</div>
<script>
    $(document).ready(function () {
        //待处理返回
        $('#noPayNew').tap(function () {
            J.customConfirm('提示',
                    '<div class="mb10">确定暂不支付手术预约金?</div><div class="font-s12">（稍后可在"订单-待处理"里完成）</div>',
                    '<a data="cancel" class="w50">取消</a>',
                    '<a data="ok" class="w50 color-green">确定</a>', function () {
                        location.href = history.go(-1);
                    }, function () {
                J.hideMask();
            });
        });

        //待确定返回
        $('#noPayService').tap(function () {
            J.customConfirm('提示',
                    '<div class="mb10">确定暂不支付手术服务费?</div><div class="font-s12">（稍后可在"订单-待确定"里完成）</div>',
                    '<a data="cancel" class="w50">取消</a>',
                    '<a data="ok" class="w50 color-green">确定</a>', function () {
                        location.href = history.go(-1);
                    }, function () {
                J.hideMask();
            });
        });
        $('#pay').click(function () {

        });
    });
</script>