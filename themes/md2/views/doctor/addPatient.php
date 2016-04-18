<?php
$this->setPageTitle('添加患者');
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$urlBookingDoctor = $this->createAbsoluteUrl('booking/create', array('did' => ''));
$url = $this->createUrl('home/page', array('view' => 'bookingDoctor', 'addBackBtn' => '1'));
$urlPatientCreate = $this->createUrl('patient/create', array('addBackBtn' => 1));
$this->show_footer = false;
$doctor = $doctorInfo->results->doctor;
$noBookingList = $patientList->results->noBookingList;
$id = Yii::app()->request->getQuery('id', '');
$returnUrl = $this->createUrl('doctor/addPatient', array('id' => $id, 'addBackBtn' => 1));
?>
<header id="addPatient_header" class="bg-green">
    <nav class="left">
        <a href="" data-target="back">
            <div class="pl5">
                <img src="<?php echo $urlResImage; ?>back.png" class="w11p">
            </div>
        </a>
    </nav>
    <h1 class="title">签约专家</h1>
    <nav id="btnSubmit" class="right">
        确定
    </nav>
</header>
<div id="section_container" <?php echo $this->createPageAttributes(); ?> >
    <section id="addPatient_section" class="active" data-init="true">
        <article id="addPatient_article" class="active" data-scroll="true">
            <div class="pl10 pr10">
                <div class="mt10 pt15 pb30 pl10 doctorInf">
                    <div>
                        您已选择:<?php echo $doctor->name; ?> <?php echo $doctor->mTitle; ?> <?php echo $doctor->aTitle; ?>
                    </div>
                    <div class="pt10">
                        <?php echo $doctor->hospitalName; ?>-<?php echo $doctor->hpDeptName; ?>
                    </div>
                </div>
                <div class="mt20 grid">
                    <div class="col-1 pl10">
                        请您选择患者:
                    </div>
                    <div class="col-0">
                        还没患者?
                        <a href="<?php echo $urlPatientCreate; ?>?returnUrl=<?php echo $returnUrl; ?>" class="color-green mr10">立即创建</a>
                    </div>
                </div>
                <?php
                if (count($noBookingList) > 0) {
                    for ($i = 0; $i < count($noBookingList); $i++) {
                        $patientInfo = $noBookingList[$i]['patientInfo'];
                        if ($patientInfo->age > 5) {
                            $age = $patientInfo->age . '岁';
                        } else {
                            $age = $patientInfo->age . '岁' . $patientInfo->ageMonth . '月';
                        }
                        ?>
                        <div class="grid patientList mt10">
                            <div class="col-0 w50p grid middle">
                                <img src="<?php echo $urlResImage; ?>unSelect.png" class="selectPatient w20p" data-id="<?php echo $patientInfo->id; ?>">
                            </div>
                            <div class="col-1">
                                <div class="mt10"><?php echo $patientInfo->name; ?></div>
                                <div class="grid">
                                    <div class="col-1"><?php echo $patientInfo->gender; ?> <?php echo $age; ?> <?php echo $patientInfo->cityName; ?></div>
                                    <div class="col-0">
                                        <a href="<?php echo $this->createUrl('patient/view', array('id' => $patientInfo->id, 'addBooking' => '0', 'addBackBtn' => 1)); ?>" class="color-green mr10 a-underline">
                                            查看详情
                                        </a>
                                    </div>
                                </div>
                                <div class="mb10"><?php echo $patientInfo->diseaseName; ?></div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
                <div class="pt20"></div>
            </div>
        </article>
    </section>
</div>
<script>
    $(document).ready(function () {
        $('.selectPatient').click(function () {
            $('.selectPatient').each(function () {
                $(this).removeClass('select');
                $(this).attr('src', '<?php echo $urlResImage; ?>unSelect.png');
            });
            $(this).addClass('select');
            $(this).attr('src', '<?php echo $urlResImage; ?>select.png');
        });
        $('#btnSubmit').click(function () {
            var patientId = '';
            $(".selectPatient").each(function () {
                if ($(this).hasClass('select')) {
                    patientId = $(this).attr('data-id');
                }
            });
            //console.log(patientId);
            if (patientId == '') {
                J.showToast('请先选择患者', '', 1000);
                return;
            }
            location.href = '<?php echo $this->createUrl("doctor/createPatientBooking", array("doctorId" => $doctor->id, "patientId" => "")) ?>/' + patientId + '/addBackBtn/1';
        });
    });
</script>