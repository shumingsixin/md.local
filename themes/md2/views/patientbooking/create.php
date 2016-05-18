<?php
//Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.formvalidate.min.js', CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/patientBooking.min.js?ts=' . time(), CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.validate.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/patientBooking.js?ts=' . time(), CClientScript::POS_END);
?>
<?php
/*
 * $model PatientBookingForm.
 */
$this->setPageID('pCreateBooking');
$this->setPageTitle('就诊信息');
$urlSubmit = $this->createUrl('patientbooking/ajaxCreate');
$urlProfile = $this->createUrl('doctor/profile', array('addBackBtn' => 1));
$urlReturn = $this->createUrl('order/orderView');
$urlRealName = $this->createUrl('doctor/profile');
$urlDoctorUploadCert = $this->createUrl('doctor/uploadCert');
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$real = $userDoctorProfile;
$userDoctorCerts = $doctorCerts;
?>
<div id="section_container" <?php echo $this->createPageAttributes(); ?>>
    <section id="patientBookingCreate_section" class="active" data-init="true">
        <article id="patientBookingCreate_article" class="active" data-scroll="true">
            <div>
                <div class="form-wrapper">
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
                    <?php echo $form->hiddenField($model, 'patient_id', array('name' => 'booking[patient_id]')); ?>
                    <?php echo $form->hiddenField($model, 'user_agent', array('name' => 'booking[user_agent]')); ?>
                    <div class="pl10 pr10 pb10 bg-white">
                        <div id="travel_type" class="triangleGreen">
                            <div class="font-s16 grid pt10 pb5 bb-gray3">
                                <div class="col-1 color-green">选择就诊意向</div>
                                <div class="col-0">
                                    <img src="http://7xsq2z.com2.z0.glb.qiniucdn.com/146355869332021" class="w20p">
                                </div>
                            </div>
                            <div class="grid pt20 pb20">
                                <?php
                                $travelTrype = $model->travel_type;
                                echo '' . $travelTrype;
                                $optionsTravelType = $model->loadOptionsTravelType();
                                $i = 1;
                                foreach ($optionsTravelType as $key => $caption) {
                                    if ($travelTrype == $key) {
                                        echo '<div data-travel="' . $key . '" class="col-1 w50 intention">' . $caption . '</div>';
                                    } else {
                                        if ($i == 1) {
                                            echo '<div data-travel="' . $key . '" class="col-1 w50 intention mr10">' . $caption . '</div>';
                                        } else {
                                            echo '<div data-travel="' . $key . '" class="col-1 w50 intention">' . $caption . '</div>';
                                        }
                                    }
                                    $i++;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php echo $form->hiddenField($model, 'travel_type', array('name' => 'booking[travel_type]')); ?>
                    <div class="mt10 pl10 pr10 pb10 bg-white">
                        <div id="expectedInfo">
                            <div class="font-s16 grid pt10 pb5 bb-gray3">
                                <div class="col-1 color-green">请填写您期望预约的医生信息</div>
                                <div class="col-0">
                                    <img src="http://7xsq2z.com2.z0.glb.qiniucdn.com/146355869320460" class="w20p">
                                </div>
                            </div>
                            <div class="grid bb-gray3">
                                <div class="col-1 w50 grid br-gray2 pr10">
                                    <div class="col-0 pt8">姓名：</div>
                                    <div class="col-1">
                                        <?php echo $form->textField($model, 'expected_doctor', array('name' => 'booking[expected_doctor]', 'class' => 'noPadding expected')); ?>
                                    </div>
                                </div>
                                <div class="col-1 w50 grid pl10">
                                    <div class="col-0 pt8">科室：</div>
                                    <div class="col-1">
                                        <?php echo $form->textField($model, 'expected_hospital', array('name' => 'booking[expected_hospital]', 'class' => 'noPadding expected')); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="grid">
                                <div class="col-0 pt8">医院：</div>
                                <div class="col-1">
                                    <?php echo $form->textField($model, 'expected_dept', array('name' => 'booking[expected_dept]', 'class' => 'noPadding expected')); ?>
                                </div>
                            </div>
                            <div class="font-s12 text-right pb5">如不填，将由名医助手为您推荐</div>
                        </div>
                    </div>
                    <div class="mt10 pl10 pr10 pb10 bg-white">
                        <div class="font-s16 grid pt10 pb5 bb-gray3">
                            <div class="col-1 color-green">诊疗意见</div>
                            <div class="col-0">
                                <img src="http://7xsq2z.com2.z0.glb.qiniucdn.com/146355869336488" class="w20p">
                            </div>
                        </div>
                        <div>
                            <?php
                            echo $form->textArea($model, 'detail', array(
                                'name' => 'booking[detail]',
                                'maxlength' => 1000,
                                'rows' => '6',
                                'placeholder' => '如果有其他说明，请在此补充',
                                'class' => 'noPadding'
                            ));
                            ?>                   
                        </div>
                        <?php echo $form->error($model, 'detail'); ?>                
                    </div>
                    <div class="pt20 pb20">
                        <a id="btnSubmit" class="btn btn-yes btn-block">提交</a>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </article>
    </section>
</div>
<script>
    Zepto(function ($) {
        document.addEventListener('input', function (e) {
            e.preventDefault();
            $('#expectedError.error').remove();
        });
        //是否实名认证
        $realName = '<?php echo $real; ?>';
        $urlRealName = '<?php echo $urlRealName; ?>';
        $userDoctorCerts = '<?php echo $userDoctorCerts; ?>'
        $userDoctorUploadCert = '<?php echo $urlDoctorUploadCert; ?>';
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