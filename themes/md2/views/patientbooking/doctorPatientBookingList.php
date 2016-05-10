<?php
/*
 * $model DoctorForm.
 */
$this->setPageID('pMyBooking');
$this->setPageTitle('收到的预约');
$urlDoctorView = $this->createUrl('doctor/view');
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
?>
<header class="bg-green">
    <nav class="left">
        <a href="" data-target="back">
            <div class="pl5">
                <img src="<?php echo $urlResImage; ?>back.png" class="w11p">
            </div>
        </a>
    </nav>
    <ul class="control-group">
        <li data-booking="processing" class="bookingMenu active">待处理</li>
        <li data-booking="done" class="bookingMenu">已完成</li>
    </ul>
    <nav class="right">
        <a class="header-user" data-target="link" data-icon="user" href="<?php echo $urlDoctorView ?>">
            <i class="icon user"></i>
        </a>
    </nav>
</header>
<div id="section_container" <?php echo $this->createPageAttributes(); ?>>
    <section id="" class="active" data-init="true">
        <article id="doctorPatientBookingList_article" class="active" data-scroll="true">
            <div class="pb20">
                <div class="processingList">
                    <?php
                    $processingList = $data->results->processingList;
                    if ($processingList) {
                        for ($i = 0; $i < count($processingList); $i++) {
                            $processingBooking = $processingList[$i];
                            ?>
                            <a href="<?php echo $this->createUrl('patientbooking/doctorPatientBooking', array('id' => $processingBooking->id, 'type' => $processingBooking->bkType, 'addBackBtn' => 1)); ?>" data-target="link">
                                <div class="p10 bt5-gray">
                                    <div class="text-right font-s12 color-green">发送时间：
                                        <?php
                                        echo $processingBooking->dateUpdated;
                                        ?>
                                    </div>
                                    <div class="grid">
                                        <div class="col-0">患者姓名:</div>
                                        <div class="col-1 pl5"><?php echo $processingBooking->name; ?></div>
                                    </div>
                                    <div class="grid mt10">
                                        <div class="col-0">疾病名称:</div>
                                        <div class="col-1 pl5"><?php echo $processingBooking->diseaseName; ?></div>
                                    </div>
                                    <div class="grid mt10 mb10">
                                        <div class="col-0">就诊意向:</div>
                                        <div class="col-1 pl5"><?php echo $processingBooking->travelType; ?></div>
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
                <div class="doneList hide">
                    <?php
                    $doneList = $data->results->doneList;
                    if ($doneList) {
                        for ($i = 0; $i < count($doneList); $i++) {
                            $doneBooking = $doneList[$i];
                            ?>
                            <a href="<?php echo $this->createUrl('patientbooking/doctorPatientBooking', array('id' => $doneBooking->id, 'type' => $doneBooking->bkType, 'addBackBtn' => 1)); ?>" data-target="link">
                                <div class="p10 bt5-gray grid">
                                    <div class="col-0 grid middle mr10">
                                        <?php
                                        if ($doneBooking->doctorAccept == 1) {
                                            $imgName = 'agree';
                                        } else {
                                            $imgName = 'disAgree';
                                        }
                                        ?>
                                        <img src="<?php echo $urlResImage; ?><?php echo $imgName; ?>.png" class="w35p">
                                    </div>
                                    <div class="col-1">
                                        <div class="text-right font-s12 color-green">发送时间：
                                            <?php
                                            if (isset($doneBooking->dateUpdated)) {
                                                echo $doneBooking->dateUpdated;
                                            } else {
                                                echo $doneBooking->dateCreated;
                                            }
                                            ?>
                                        </div>
                                        <div class="grid">
                                            <div class="col-0">患者姓名:</div>
                                            <div class="col-1 pl5"><?php echo $doneBooking->name; ?></div>
                                        </div>
                                        <div class="grid mt10">
                                            <div class="col-0">疾病名称:</div>
                                            <div class="col-1 pl5"><?php echo $doneBooking->diseaseName; ?></div>
                                        </div>
                                        <div class="grid mt10 mb10">
                                            <div class="col-0">就诊意向:</div>
                                            <div class="col-1 pl5"><?php echo $doneBooking->travelType; ?></div>
                                        </div>
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
<script>
    $(document).ready(function () {
        $(".bookingMenu").click(function () {
            var dataBooking = $(this).attr('data-booking');
            if (dataBooking == 'processing') {
                $('.doneList').addClass('hide');
                $('.processingList').removeClass('hide');
                $('#doctorPatientBookingList_article').scrollTop(0);
            } else {
                $('.processingList').addClass('hide');
                $('.doneList').removeClass('hide');
                $('#doctorPatientBookingList_article').scrollTop(0);
            }
        });
    });
</script>