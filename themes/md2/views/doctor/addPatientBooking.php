<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.validate.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/addPatientBooking.js?ts=' . time(), CClientScript::POS_END);
?>
<?php
$urlSubmit = $this->createUrl('patientbooking/ajaxCreate');
$urlReturn = $this->createUrl('order/view');
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$this->show_footer = false;
$doctor = $doctorInfo->results->doctor;
$patientInfo = $patientInfo->results->patientInfo;
?>
<header class="bg-green">
    <nav class="left">
        <a href="" data-target="back">
            <div class="pl5">
                <img src="<?php echo $urlResImage; ?>back.png" class="w11p">
            </div>
        </a>
    </nav>
    <h1 class="title">就诊意向</h1>
</header>
<div id="section_container" <?php echo $this->createPageAttributes(); ?> >
    <section id="createPatientBooking_section" class="active" data-init="true">
        <article id="createPatientBooking_article" class="active" data-scroll="true">
            <div class="pl10 pr10">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'booking-form',
                    'action' => $urlSubmit,
                    'htmlOptions' => array('data-url-return' => $urlReturn),
                    'enableClientValidation' => false,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'validateOnType' => true,
                        'validateOnDelay' => 500,
                        'errorCssClass' => 'error',
                    ),
                    'enableAjaxValidation' => false,
                ));
                ?>
                <?php echo $form->hiddenField($model, 'patient_id', array('name' => 'booking[patient_id]', 'value' => $patientInfo->id)); ?>
                <div class="mt20 triangleGreen">
                    <div class="font-s16">
                        <span class="">您的意向主刀专家：</span>
                    </div>
                    <div class="mt5">
                        <?php echo $doctor->name; ?>
                    </div>
                    <div class="mt5">
                        <?php echo $doctor->hospitalName; ?> <?php echo $doctor->hpDeptName; ?>
                    </div>
                </div>
                <?php
                if ($patientInfo->age > 5) {
                    $age = $patientInfo->age . '岁';
                } else {
                    $age = $patientInfo->age . '岁' . $patientInfo->ageMonth . '月';
                }
                ?>
                <div class="mt20 triangleGreen">
                    <div class="font-s16">
                        <span class="">您添加的患者：</span>
                    </div>
                    <div class="mt5">
                        <?php echo $patientInfo->name; ?> <?php echo $age; ?> <?php echo $patientInfo->gender; ?>
                    </div>
                </div>
                <div id="travel_type" class="mt20 triangleGreen">
                    <div class="font-s16">
                        <span class="">请选择就诊意向：</span>
                    </div>
                    <div class="grid mt5">
                        <div data-travel="1" class="col-1 w50 intention mr10">
                            邀请医生过来
                        </div>
                        <div data-travel="2" class="col-1 w50 intention ml10">
                            希望转诊治疗
                        </div>
                    </div>
                </div>
                <?php echo $form->hiddenField($model, 'travel_type', array('name' => 'booking[travel_type]')); ?>
                <div class="mt20 triangleGreen">
                    就诊意见：
                </div>
                <div class="mt5">
                    <?php
                    echo $form->textArea($model, 'detail', array(
                        'name' => 'booking[detail]',
                        'maxlength' => 1000,
                        'rows' => '4',
                        'placeholder' => '请简要表述您的需求'
                    ));
                    ?>  
                </div>
                <div class="mt20 mb30">
                    <a id="btnSubmit" class="btn btn-yes btn-full">提交</a>
                </div>
            </div>
            <?php $this->endWidget(); ?>
            </div>
        </article>
    </section>
</div>
<script>
    $(document).ready(function () {
        $('.intention').click(function (e) {
            e.preventDefault();
            $('.noTravelType').remove();
            var travelType = $(this).attr('data-travel');
            $('input[name = "booking[travel_type]"]').attr('value', travelType);
            $('.intention').each(function () {
                $(this).removeClass('active');
            });
            $(this).addClass('active');
        });
    });
</script>