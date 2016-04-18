<?php
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$urlAddPatient = $this->createAbsoluteUrl('doctor/addPatient', array('id' => ''));
$doctor = $data->results->doctor;
$honour = $doctor->honour;
$this->show_footer = false;
?>
<header class="bg-green">
    <nav class="left">
        <a href="" data-target="back">
            <div class="pl5">
                <img src="<?php echo $urlResImage; ?>back.png" class="w11p">
            </div>
        </a>
    </nav>
    <h1 class="title"><?php echo $doctor->name; ?>手术预约</h1>
</header>
<nav id="viewDoctor_nav" class="header-secondary">
    <div class="grid doctorInf w100 text-left">
        <div class="col-1 w25">
            <div class="imgDiv">
                <img class="imgDoc" src="<?php echo $doctor->imageUrl; ?>">
            </div>
        </div>
        <div class="ml10 col-1 w75">
            <div class="grid">
                <div class="col-1 w60 mt5 font-s16 color-black3">
                    <?php echo $doctor->name; ?>
                    <span class="ml10"><?php
                        if ($doctor->aTitle == '无') {
                            echo '';
                        } else {
                            echo $doctor->aTitle;
                        }
                        ?>
                    </span>
                </div>
                <div class="col-1 grid w40 text-right font-s16">
                    <div class="col-1"></div>
                    <a href="<?php echo $urlAddPatient; ?>/<?php echo $doctor->id; ?>/addBackBtn/1" data-target="link">
                        <div class="col-0 text-center w80p yellow-button">预约</div>
                    </a>
                </div>
            </div>
            <?php if ($doctor->hpDeptName == '') {
                ?>
                <div class="mt5 color-gray4"><?php echo $doctor->mTitle; ?></div>
                <?php
            } else {
                ?>
                <div class="mt5 color-gray4"><?php echo $doctor->hpDeptName; ?><span class="ml10"><?php echo $doctor->mTitle; ?></span></div>
            <?php }
            ?>
            <div class="mt5 color-black6 font-s14"><?php echo $doctor->hospitalName; ?></div>
        </div>
    </div>
</nav>
<div id="section_container" <?php echo $this->createPageAttributes(); ?> >
    <section id="viewDoctor_section" class="active" data-init="true">
        <article id="viewDoctor_article" class="" data-scroll="true">
            <div>
                <?php if (count($doctor->reasons) != 0) { ?>
                    <div class="divTJ">
                        <div class="bgReason font-s16 color-black pb5 mb5 aFontSize">
                            推荐理由
                        </div>
                        <?php
                        for ($i = 0; $i < count($doctor->reasons); $i++) {
                            ?>
                            <div class="bgStars color-black6 bFontSize">
                                <?php echo $doctor->reasons[$i]; ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                <?php } ?>
                <?php
                if (isset($doctor->description) && (trim($doctor->description) != '')) {
                    ?>
                    <div class="divSC">
                        <div class="bgSC font-s16 color-black aFontSize">擅长</div>
                        <div class="pl25 mt5 color-black6 bFontSize"><?php echo $doctor->description; ?></div>
                    </div>
                    <?php
                }
                ?>
                <?php if (isset($honour) && !is_null($honour)) { ?>
                    <div class="divHonor">
                        <div class="bgHonor font-s16 color-black mb5 aFontSize">
                            荣誉
                        </div>
                        <?php
                        for ($i = 0; $i < count($honour); $i++) {
                            ?>
                            <div class="bgStars color-black6 bFontSize">
                                <?php echo $honour[$i]; ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                <?php } ?>
                <?php if (isset($doctor->careerExp) && !is_null($doctor->careerExp)) { ?>
                    <div class="divCareer">
                        <div class="bgCareer">
                            <div class="font-s16 color-black mb5 aFontSize">执业经历</div>
                            <div class="color-black6 bFontSize"><?php echo $doctor->careerExp; ?></div>
                        </div>
                    </div>
                <?php } ?>
                <div class="mb10"></div>
            </div>
        </article>
    </section>
</div>
<script>
    $(document).ready(function () {
        var height = $('#viewDoctor_nav').height();
        $('#viewDoctor_article').css({"margin-top": height + "px"});
        $('#viewDoctor_article').addClass('active');
        $('#viewDoctor_article').scroll(function () {
            if ($('#viewDoctor_article').scrollTop() > 0) {
                $('.doctorInf').addClass('bb-gray');
            } else {
                $('.doctorInf').removeClass('bb-gray');
            }

        });
    });
</script>