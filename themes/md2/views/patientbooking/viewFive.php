<?php
/*
 * $model DoctorForm.
 */
$this->setPageID('pMyBooking');
$this->setPageTitle('发出的预约');
$urlViewFive = $this->createUrl('patientbooking/viewFive');
$urlUpdatePatientMR = $this->createUrl('patient/updatePatientMR', array('id' => 10));
$urlUploadMRFile = $this->createUrl('patient/uploadMRFile', array('id' => 10, 'type' => 'update'));
?>

<div class="aside-container" data-position="left">

</div>

<div id="section_container">

    <section id="yyFive_section" class="active" data-init="true">
        <header>
            <nav class="left">
                <a href="#" class="color-000" data-target="back" data-icon="previous"></a>
            </nav>
            <h1 class="title color-000">预约详情</h1>
            <nav class="right">
                <a href="#" data-target="section" data-icon="share"></a>
            </nav>
        </header>

        <article class="active" data-scroll="true">
            <div class="pb20">
                <div class="grid font-type ml10 mr10 mt20">
                    <div data-icon="spinner" class="col-0 w10 text-center color-yellow"></div>
                    <div class="col-0 w90 color-green">
                        请您耐心等待名医助手确认，谢谢！
                    </div>
                </div>
                <div class="bg-img w100 h30 text-center mt20">
                    <span class="label bg-green color-fff font-20">就诊意向</span>
                </div>
                <div class="ml10 mr10">
                    <div class="mb10">
                        邀请专家过来
                    </div>
                    <div class="mb10">
                        2015年10月1日-2015年10月15日
                    </div>
                    <div class="line-h">
                        如果你没有办法的话，那就去海的那边，那里会有一处无忧无虑的小村。
                        如果你没有办法的话，那就去海的那边，那里会有一处无忧无虑的小村。
                        如果你没有办法的话，那就去海的那边，那里会有一处无忧无虑的小村。
                    </div>
                </div>
                <div class="bg-img w100 h30 text-center mt20">
                    <span class="label bg-green color-fff font-20">患者资料</span>
                </div>
                <div class="ml10 mr10">
                    <div class="grid mt10 mb10">
                        <div class="col-0 w80">
                            李小白 | 男 | 19岁 | 上海
                        </div>
                        <div class="col-1 text-right">
                            <a href="<?php echo $urlUpdatePatientMR; ?>" class="color-green" data-target="link">修改</a>
                        </div>
                    </div>
                    <div class="mb20">
                        如果你没有办法的话，那就去海的那边，那里会有一处无忧无虑的小村。
                        如果你没有办法的话，那就去海的那边，那里会有一处无忧无虑的小村。
                        如果你没有办法的话，那就去海的那边，那里会有一处无忧无虑的小村。
                    </div>
                    <div class="grid mt10 mb20">
                        <div class="col-0 w80 font-type">
                            影像资料：
                        </div>
                        <div class="col-1 text-right">
                            <a href="<?php echo $urlUploadMRFile; ?>" class="color-green" data-target="link">修改</a>
                        </div>
                    </div>
                    <div class="grid mb20">
                        <div class="col-0 w33 text-center">
                            <img class="w-100 h100" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/city-nanjing.jpg" />
                        </div>
                        <div class="col-0 w33 text-center">
                            <img class="w-100 h100" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/city-nanjing.jpg" />
                        </div>
                        <div class="col-0 w33 text-center">
                            <img class="w-100 h100" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/city-nanjing.jpg" />
                        </div>
                    </div>
                </div>
            </div>
        </article>

    </section>
</div>
