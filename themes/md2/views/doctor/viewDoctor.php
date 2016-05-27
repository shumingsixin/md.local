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
    <h1 class="title">专家介绍</h1>
</header>
<div id="section_container" <?php echo $this->createPageAttributes(); ?> >
    <section id="viewDoctor_section" class="active" data-init="true">
        <footer class="bg-white">
            <button id="bookingDoc" class="btn btn-block bg-yellow">立即预约</button>
        </footer>
        <article id="viewDoctor_article" class="active" data-scroll="true">
            <div>
                <div class="bg-green">
                    <div class="grid pt20">
                        <div class="col-1"></div>
                        <div class="col-0">
                            <div class="imgDiv">
                                <img class="imgDoc" src="<?php echo $doctor->imageUrl; ?>">
                            </div>
                        </div>
                        <div class="col-1"></div>
                    </div>
                    <div class="text-center font-s16">
                        <?php
                        echo $doctor->name;
                        if ($doctor->aTitle == '无') {
                            echo '';
                        } else {
                            echo $doctor->aTitle;
                        }
                        ?>
                    </div>
                    <div class="text-center">
                        <?php
                        if ($doctor->hpDeptName == '') {
                            echo $doctor->mTitle;
                        } else {
                            echo $doctor->hpDeptName . '<span class="ml10">' . $doctor->mTitle . '</span>';
                        }
                        ?>
                    </div>
                    <div class="grid pt2 pb20">
                        <div class="col-1"></div>
                        <div class="col-0 hosBorder">
                            <?php echo $doctor->hospitalName; ?>
                        </div>
                        <div class="col-1"></div>
                    </div>
                </div>
                <div class="grid pageIcon bg-white">
                    <div class="col-1 w50 active cardSelect" data-card="career">
                        擅长•执业经历
                    </div>
                    <div class="col-1 w50 cardSelect" data-card="honor">
                        荣誉•推荐理由
                    </div>
                </div>
                <?php
                if ((isset($doctor->description) && (trim($doctor->description) != '')) || (isset($doctor->careerExp) && !is_null($doctor->careerExp))) {
                    ?>
                    <div class="bgTriangleLeft pageCard" data-card="career">
                        <div class="bg-white">
                            <?php
                            if (isset($doctor->description) && (trim($doctor->description) != '')) {
                                ?>
                                <div class="pad10 bb-gray3">
                                    <div class="font-s16 color-black">擅长</div>
                                    <div class="color-black6"><?php echo $doctor->description; ?></div>
                                </div>
                                <?php
                            }
                            ?>
                            <?php if (isset($doctor->careerExp) && !is_null($doctor->careerExp)) { ?>
                                <div class="pad10">
                                    <div class="font-s16 color-black">执业经历</div>
                                    <div class="color-black6"><?php echo $doctor->careerExp; ?></div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <?php
                if ((isset($honour) && !is_null($honour)) || (count($doctor->reasons) != 0)) {
                    ?>
                    <div class="bgTriangleRight pageCard hide" data-card="honor">
                        <div class="bg-white">
                            <?php if (isset($honour) && !is_null($honour)) { ?>
                                <div class="pad10 bb-gray3">
                                    <div class="font-s16 color-black">
                                        荣誉
                                    </div>
                                    <?php
                                    for ($i = 0; $i < count($honour); $i++) {
                                        ?>
                                        <div class="bgStars color-black6">
                                            <?php echo $honour[$i]; ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            <?php } ?>
                            <?php if (count($doctor->reasons) != 0) { ?>
                                <div class="pad10">
                                    <div class="font-s16 color-black">
                                        推荐理由
                                    </div>
                                    <?php
                                    for ($i = 0; $i < count($doctor->reasons); $i++) {
                                        ?>
                                        <div class="bgDiamond color-black6">
                                            <?php echo $doctor->reasons[$i]; ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="mb10"></div>
            </div>
        </article>
    </section>
</div>
<script>
    $(document).ready(function () {
        $('.cardSelect').click(function () {
            var dataCard = $(this).attr('data-card');
            $('.cardSelect').each(function () {
                if (dataCard == $(this).attr('data-card')) {
                    $(this).addClass('active');
                } else {
                    $(this).removeClass('active');
                }
            });
            $('.pageCard').each(function () {
                if (dataCard == $(this).attr('data-card')) {
                    $(this).removeClass('hide');
                } else {
                    $(this).addClass('hide');
                }
            });
            $('#viewDoctor_article').scrollTop(0);
        });
        $('#bookingDoc').click(function () {
            location.href = '<?php echo $urlAddPatient; ?>/<?php echo $doctor->id; ?>/addBackBtn/1';
        });
    });
</script>